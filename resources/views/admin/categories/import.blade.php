@php
    $breadcrumbs = [
        [
            'name' => 'Categorías',
            'href' => route('admin.categories.index'),
        ],
        [
            'name' => 'Importación',
        ],
    ];
@endphp

<x-admin-layout title="Importación" :breadcrumbs="$breadcrumbs">
    @livewire('admin.import-of-categories')
</x-admin-layout>