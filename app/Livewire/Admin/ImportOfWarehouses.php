<?php

namespace App\Livewire\Admin;

use App\Exports\WarehousesTemplateExport;
use App\Imports\WarehousesImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class ImportOfWarehouses extends Component
{
    use WithFileUploads;
    
    public $file;
    public $errors = [];
    public $importedCount = 0;

    public function downloadTemplate()
    {
        return Excel::download(new WarehousesTemplateExport(), 'almacenes_plantilla.xlsx');
    }
    
    public function importWarehouses()
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        $warehousesImport = new WarehousesImport();

        Excel::import($warehousesImport, $this->file);

        $this->errors = $warehousesImport->getErrors();
        $this->importedCount = $warehousesImport->getImportedCount();

        if(count($this->errors) == 0){
            session()->flash('swal', [
                'icon' =>"success",
                'title' =>"Datos de importación",
                'text' => "Se han importado {$this->importedCount} almacenes.",
            ]);

            return redirect()->route('admin.warehouses.index');
        }

    }

    public function render()
    {
        return view('livewire.admin.import-of-warehouses');
    }
}
