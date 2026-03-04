<?php
namespace App\View\Components;

use Illuminate\View\Component;

class DocumentEditor extends Component
{
    public function __construct(
        public string $documentableType,
        public int $documentableId,
        public ?int $typeDocumentId = null,
        public ?int $documentId = null,
        public ?string $label = null,
        public ?string $icon = null,
    ) {}

    public function render()
    {
        return view('components.document-editor');
    }
}
