@php
    $breadcrumbs = [
        [
            'name' => 'Productos',
            'href' => route('admin.products.index'),
        ],
        [
            'name' => 'Kardex',
        ],
    ];
@endphp

<x-admin-layout title="Kardex" :breadcrumbs="$breadcrumbs">
  @livewire('admin.kardex', ['product' => $product])
</x-admin-layout>