@php
    $breadcrumbs = [
        [
            'name' => 'Ordenes de compra',
            'href' => route('admin.purchase-orders.index'),
        ],
        [
            'name' => 'Nuevo',
        ],
    ];
@endphp

<x-admin-layout title="Nueva orden de compra" :breadcrumbs="$breadcrumbs">

    @livewire('admin.purchase-order-create')

</x-admin-layout>
