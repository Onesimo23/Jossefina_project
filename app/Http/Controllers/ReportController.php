<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function download($type, $format)
    {
        $file = DB::table('report_logs')->where('type',$type)->where('format',$format)->latest()->first();
        if (!$file) abort(404);
        return response()->streamDownload(fn() => print(Storage::disk('local')->get($file->path)), basename($file->path));
    }
}
