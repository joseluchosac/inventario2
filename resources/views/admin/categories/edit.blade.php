@php
    $breadcrumbs = [
        [
            'name' => 'Categorías',
            'href' => route('admin.categories.index'),
        ],
        [
            'name' => 'Editar',
        ],
    ];
@endphp

<x-admin-layout title="Editar categoría" :breadcrumbs="$breadcrumbs">

    <div>
        <x-wire-card>
            <form class="space-y-4" action="{{ route('admin.categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                <x-wire-input label="Nombre" name="name" value="{{ old('name', $category->name) }}" />
                <x-wire-textarea label="Descripción" name="description">
                    {{ old('description', $category->description) }}
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
