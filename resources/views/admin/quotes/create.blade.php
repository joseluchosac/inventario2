@php
    $breadcrumbs = [
        [
            'name' => 'Cotizaciones',
            'href' => route('admin.quotes.index'),
        ],
        [
            'name' => 'Nuevo',
        ],
    ];
@endphp

<x-admin-layout title="Nueva cotización" :breadcrumbs="$breadcrumbs">

    @livewire('admin.quote-create')

</x-admin-layout>
