<?php
namespace App\Livewire\Activity;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Evidence;
use App\Models\EvidencePhoto;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ActivityEvidenceUploader extends Component
{
    use WithFileUploads;

    public $activityId;
    public $photos = []; // array of uploaded files
    public $caption;

    protected $rules = [
        'photos.*' => 'image|max:10240', // max 10MB por foto
        'caption' => 'nullable|string|max:1000',
    ];

    public function mount($activityId)
    {
        $this->activityId = $activityId;
    }

    public function updatedPhotos()
    {
        $this->validateOnly('photos.*');
    }

    public function save()
    {
        $this->validate();

        if (count($this->photos) === 0) {
            $this->addError('photos', 'Selecione ao menos uma foto.');
            return;
        }

        $evidence = Evidence::create([
            'activity_id' => $this->activityId,
            'user_id' => auth()->id(),
            'caption' => $this->caption,
        ]);

        foreach ($this->photos as $photo) {
            // nome do ficheiro final
            $basename = Str::random(20) . '.' . $photo->getClientOriginalExtension();
            $relativePath = 'evidences/' . $this->activityId . '/' . $basename;
            $disk = 'public';

            // grava usando o Storage::disk para garantir o destino correto
            // putFileAs aceita o UploadedFile e devolve o caminho relativo
            $stored = \Illuminate\Support\Facades\Storage::disk($disk)->putFileAs(
                'evidences/' . $this->activityId,
                $photo,
                $basename
            );

            if ($stored) {
                EvidencePhoto::create([
                    'evidence_id' => $evidence->id,
                    'filename' => $relativePath,
                    'disk' => $disk,
                ]);
            } else {
                // fallback: marca erro sem abortar todas as imagens
                $this->addError('photos', 'Falha ao gravar ' . $basename);
            }
        }

        // limpa inputs e validação
        $this->reset(['photos', 'caption']);
        $this->resetValidation();

        // apenas mensagem de confirmação (sem emit/dispatch)storage/app/livewire-tmp
        session()->flash('message', 'Evidências enviadas com sucesso.');
    }

    public function render()
    {
        return view('livewire.activity.activity-evidence-uploader');
    }
}
