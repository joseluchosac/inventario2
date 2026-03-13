@php
    $breadcrumbs = [
        [
            'name' => 'Categorías',
            'href' => route('admin.categories.index'),
        ],
        [
            'name' => 'Nuevo',
        ],
    ];
@endphp

<x-admin-layout title="Nueva categoría" :breadcrumbs="$breadcrumbs">


    <div>
        <x-wire-card>
            <form class="space-y-4" action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <x-wire-input label="Nombre" name="name" value="{{ old('name') }}" />
                <x-wire-textarea label="Descripción" name="description">
                    {{ old('description') }}
                </x-wire-textarea>

                <div class="flex justify-end items-center gap-4">
                    <a href="{{ route('admin.categories.index') }}">
                        <button type="button">Cancelar</button>
                    </a>
                    <x-button type="submit">Guardar</x-button>
                </div>

            </form>
        </x-wire-card>
    </div>
</x-admin-layout>
