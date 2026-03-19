@php
    $breadcrumbs = [
        [
            'name' => 'Transferencias',
            'href' => route('admin.transfers.index'),
        ],
        [
            'name' => 'Nuevo',
        ],
    ];
@endphp

<x-admin-layout title="Nueva transferencia" :breadcrumbs="$breadcrumbs">

    @livewire('admin.transfer-create')

</x-admin-layout>
