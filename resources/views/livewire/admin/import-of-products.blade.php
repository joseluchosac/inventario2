<div class="mt-4">
    <x-wire-card class="text-center">
        <h1 class="text-xl font-semibold">
            Importar productos desde excel
        </h1>
        <x-wire-button class="mt-4" wire:click="downloadTemplate">
            <i class="fa-solid fa-download"></i>Descargar plantilla
        </x-wire-button>
        <p class="mt-4">Para importar los productos descargue la plantilla y completa los campos requeridos</p>
        <div class="mt-4">
            <input
                type="file"
                accept=".xlsx, .xls"
                wire:model="file"
            />
            <x-input-error for="file" class="mt-2" />
        </div>
        <div class="mt-4">
            <x-wire-button 
                green
                wire:click="importProducts"
                wire:loading.attr="disabled"
                wire:target="file"
                spinner="importProducts"
            >
                <i class="fa-solid fa-upload"></i>
                Importar productos
            </x-wire-button>
        </div>
        @if (count($errors))
            <div class="mt-4">
                <div class="p-4 bg-yellow-100 border border-yellow-500 rounded-md">
                    @if ($importedCount)
                        <i class="fas fa-triangle-exclamation"></i>
                        <strong>Importación completada parcialmente</strong>
                        <p>Algunos productos no se pudieron importar</p>
                    @else
                        <i class="fas fa-xmark mr-2"></i>
                        <strong>No se importó ningún producto</strong>
                    @endif
                </div>
                <ul>
                    @foreach ($errors as $error)
                        <li class="p-3 bg-red-500">
                            <p>
                                <i class="fas fa-file-pen"></i>
                                Fila {{$error['row']}}: 
                            </p>
                            <ul class="list-disc list-inside mt-1">
                                @foreach ($error['errors'] as $message)
                                    <li class="text-red text-sm">{{ $message }}</li>
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </x-wire-card>
</div>
