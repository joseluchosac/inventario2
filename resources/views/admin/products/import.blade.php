@php
    $breadcrumbs = [
        [
            'name' => 'Productos',
            'href' => route('admin.products.index'),
        ],
        [
            'name' => 'Importar',
        ],
    ];
@endphp

<x-admin-layout title="Importar productos" :breadcrumbs="$breadcrumbs">
  @livewire('admin.import-of-products')
</x-admin-layout>