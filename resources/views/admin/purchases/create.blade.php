@php
    $breadcrumbs = [
        [
            'name' => 'Compras',
            'href' => route('admin.purchases.index'),
        ],
        [
            'name' => 'Nuevo',
        ],
    ];
@endphp

<x-admin-layout title="Nueva compra" :breadcrumbs="$breadcrumbs">

    @livewire('admin.purchase-create')

</x-admin-layout>
