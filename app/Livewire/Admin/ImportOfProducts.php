<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportOfProducts extends Component
{
    use WithFileUploads;

    public $file;
    public $errors = [];
    public $importedCount = 0;


    public function downloadTemplate()
    {
        return Excel::download(new \App\Exports\ProductsTemplateExport(), 'productos_plantilla.xlsx');
    }

    public function importProducts()
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        $productsImport = new \App\Imports\ProductsImport();

        Excel::import($productsImport, $this->file);

        $this->errors = $productsImport->getErrors();
        $this->importedCount = $productsImport->getImportedCount();

        if(count($this->errors) == 0){
            session()->flash('swal', [
                'icon' =>"success",
                'title' =>"Datos de importación",
                'text' => "Se han importado {$this->importedCount} productos.",
            ]);

            return redirect()->route('admin.products.index');
        }

    }

    public function render()
    {
        return view('livewire.admin.import-of-products');
    }
}
