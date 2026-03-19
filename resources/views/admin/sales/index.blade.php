@php
  $breadcrumbs = [
    [
      'name' => 'Ventas',
    ],
  ];
@endphp

<x-admin-layout title="Ventas" :breadcrumbs="$breadcrumbs">


  <x-slot name="action">
    <x-wire-button blue href="{{route('admin.sales.create')}}">
      Nueva venta
    </x-wire-button>
  </x-slot>

  <div class="mt-4">
    @livewire('admin.datatables.sale-table')
  </div>

</x-admin-layout>