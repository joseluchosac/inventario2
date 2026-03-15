@php
    $breadcrumbs = [
        [
            'name' => 'Almacenes',
            'href' => route('admin.warehouses.index'),
        ],
        [
            'name' => 'Editar',
        ],
    ];
@endphp

<x-admin-layout title="Editar almacén" :breadcrumbs="$breadcrumbs">


    <div class="max-w-4xl mx-auto">
        <x-wire-card>
            <form class="space-y-4" action="{{ route('admin.warehouses.update', $warehouse) }}" method="POST">
                @method('PUT')
                @csrf
                <x-wire-input label="Nombre" name="name" value="{{ old('name', $warehouse->name) }}" />
                <x-wire-input label="Lugar" name="location" value="{{ old('location', $warehouse->location) }}" />

                <div class="flex justify-end items-center gap-4">
                    <a href="{{ route('admin.warehouses.index') }}">
                        <button type="button">Cancelar</button>
                    </a>
                    <x-button type="submit">Actualizar</x-button>
                </div>

            </form>
        </x-wire-card>
    </div>
</x-admin-layout>

