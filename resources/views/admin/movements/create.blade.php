@php
    $breadcrumbs = [
        [
            'name' => 'Entradas y salidas',
            'href' => route('admin.movements.index'),
        ],
        [
            'name' => 'Nuevo',
        ],
    ];
@endphp

<x-admin-layout title="Nuevo movimiento" :breadcrumbs="$breadcrumbs">

    @livewire('admin.movement-create')

</x-admin-layout>
