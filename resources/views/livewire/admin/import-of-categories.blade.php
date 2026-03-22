<div class="mt-4">
    <x-wire-card class="text-center">
        <h1 class="text-xl font-semibold">
            Importar categorias desde excel
        </h1>
        <x-wire-button class="mt-4" wire:click="downloadTemplate">
            <i class="fa-solid fa-download"></i>Descargar plantilla
        </x-wire-button>
        <p class="mt-4">Para importar los categorias descargue la plantilla y completa los campos requeridos</p>
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
                wire:click="importCategories"
                wire:loading.attr="disabled"
                wire:target="file"
                spinner="importCategories"
            >
                <i class="fa-solid fa-upload"></i>
                Importar categorías
            </x-wire-button>
        </div>
        @if (count($errors))
            <div class="mt-4">
                <div class="p-4 bg-yellow-100 border border-yellow-500 rounded-md">
                    @if ($importedCount)
                        <i class="fas fa-triangle-exclamation"></i>
                        <strong>Importación completada parcialmente</strong>
                        <p>Algunas categorías no se pudieron importar</p>
                    @else
                        <i class="fas fa-xmark mr-2"></i>
                        <strong>No se importó ningúna categoría</strong>
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

