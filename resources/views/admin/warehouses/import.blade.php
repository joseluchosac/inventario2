@php
    $breadcrumbs = [
        [
            'name' => 'Almacenes',
            'href' => route('admin.warehouses.index'),
        ],
        [
            'name' => 'Importación',
        ],
    ];
@endphp

<x-admin-layout title="Importación" :breadcrumbs="$breadcrumbs">
    @livewire('admin.import-of-warehouses')
</x-admin-layout>