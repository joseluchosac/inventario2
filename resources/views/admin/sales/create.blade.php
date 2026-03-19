@php
    $breadcrumbs = [
        [
            'name' => 'Ventas',
            'href' => route('admin.sales.index'),
        ],
        [
            'name' => 'Nuevo',
        ],
    ];
@endphp

<x-admin-layout title="Nueva venta" :breadcrumbs="$breadcrumbs">

    @livewire('admin.sale-create')

</x-admin-layout>
