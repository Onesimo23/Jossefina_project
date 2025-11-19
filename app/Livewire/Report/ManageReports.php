<?php

namespace App\Livewire\Report;

use Livewire\Component;
use App\Models\Enrollment;
use App\Models\Activity;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManageReports extends Component
{
    public $reportType = 'enrollments'; // enrollments | activities | projects
    public $format = 'csv'; // csv | pdf
    public $from = null;
    public $to = null;
    public $recent = [];

    public function mount()
    {
        $this->loadRecent();
    }

    public function render()
    {
        return view('livewire.report.manage-reports')
               ->layout('layouts.app'); // usar resources/views/layouts/app.blade.php
    }

    protected function loadRecent()
    {
        $this->recent = DB::table('report_logs')->latest()->limit(8)->get();
    }

    public function generate()
    {
        $this->validate([
            'reportType' => 'required|in:enrollments,activities,projects',
            'format' => 'required|in:csv,pdf',
            'from' => 'nullable|date',
            'to' => 'nullable|date',
        ]);

        $fileName = now()->format('YmdHis') . "_{$this->reportType}.{$this->format}";
        $path = "reports/{$fileName}";

        if ($this->format === 'csv') {
            $this->generateCsv($path);
        } else {
            $this->generatePdf($path);
        }

        // salvar log simples
        DB::table('report_logs')->insert([
            'type' => $this->reportType,
            'format' => $this->format,
            'path' => $path,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->loadRecent();

        return response()->streamDownload(function () use ($path) {
            echo Storage::disk('local')->get($path);
        }, $fileName);
    }

    protected function generateCsv($path)
    {
        $handle = fopen('php://memory', 'w+');

        if ($this->reportType === 'enrollments') {
            fputcsv($handle, ['Enrollment ID','User','User Email','Activity','Project','Status','Created At']);
            $query = Enrollment::with(['user','activity.project'])->orderBy('created_at','desc');
            if ($this->from) $query->whereDate('created_at','>=',$this->from);
            if ($this->to) $query->whereDate('created_at','<=',$this->to);
            foreach ($query->cursor() as $en) {
                fputcsv($handle, [
                    $en->id,
                    $en->user->name ?? '',
                    $en->user->email ?? '',
                    $en->activity->title ?? '',
                    $en->activity->project->title ?? '',
                    $en->status ?? '',
                    $en->created_at,
                ]);
            }
        } elseif ($this->reportType === 'activities') {
            fputcsv($handle, ['Activity ID','Title','Project','Start','End','Status','Created At']);
            $query = Activity::with('project')->orderBy('created_at','desc');
            if ($this->from) $query->whereDate('start_date','>=',$this->from);
            if ($this->to) $query->whereDate('end_date','<=',$this->to);
            foreach ($query->cursor() as $a) {
                fputcsv($handle, [
                    $a->id,
                    $a->title,
                    $a->project->title ?? '',
                    $a->start_date,
                    $a->end_date,
                    $a->status,
                    $a->created_at,
                ]);
            }
        } else { // projects
            fputcsv($handle, ['Project ID','Title','Coordinator','Start','End','Status','Created At']);
            $query = Project::orderBy('created_at','desc');
            if ($this->from) $query->whereDate('start_date','>=',$this->from);
            if ($this->to) $query->whereDate('end_date','<=',$this->to);
            foreach ($query->cursor() as $p) {
                fputcsv($handle, [
                    $p->id,
                    $p->title,
                    optional($p->coordinator)->name ?? '',
                    $p->start_date,
                    $p->end_date,
                    $p->status,
                    $p->created_at,
                ]);
            }
        }

        rewind($handle);
        $contents = stream_get_contents($handle);
        fclose($handle);

        Storage::disk('local')->put($path, $contents);
    }

    protected function generatePdf($path)
    {
        // usa view simples para PDF. requer barryvdh/laravel-dompdf instalado.
        $data = [];

        if ($this->reportType === 'enrollments') {
            $data['rows'] = Enrollment::with(['user','activity.project'])
                ->when($this->from, fn($q) => $q->whereDate('created_at','>=',$this->from))
                ->when($this->to, fn($q) => $q->whereDate('created_at','<=',$this->to))
                ->orderBy('created_at','desc')->get();
        } elseif ($this->reportType === 'activities') {
            $data['rows'] = Activity::with('project')
                ->when($this->from, fn($q) => $q->whereDate('start_date','>=',$this->from))
                ->when($this->to, fn($q) => $q->whereDate('end_date','<=',$this->to))
                ->orderBy('created_at','desc')->get();
        } else {
            $data['rows'] = Project::orderBy('created_at','desc')->get();
        }

        $html = view('reports.pdf.'.$this->reportType, $data)->render();

        // gera PDF com dompdf (usa FQCN para evitar erro de alias)
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadHTML($html)->setPaper('a4', 'portrait');

        Storage::disk('local')->put($path, $pdf->output());
    }

    public function downloadLog($id)
    {
        $log = DB::table('report_logs')->where('id',$id)->first();
        if (!$log) return session()->flash('message','Relatório não encontrado');

        return response()->streamDownload(function () use ($log) {
            echo Storage::disk('local')->get($log->path);
        }, basename($log->path));
    }
}
