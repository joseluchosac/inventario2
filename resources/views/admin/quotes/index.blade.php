@php
  $breadcrumbs = [
    [
      'name' => 'Cotizaciones',
    ],
  ];
@endphp

<x-admin-layout title="Cotizaciones" :breadcrumbs="$breadcrumbs">


  <x-slot name="action">
    <x-wire-button blue href="{{route('admin.quotes.create')}}">
      Nueva cotización
    </x-wire-button>
  </x-slot>

  <div class="mt-4">
    @livewire('admin.datatables.quote-table')
  </div>

</x-admin-layout>