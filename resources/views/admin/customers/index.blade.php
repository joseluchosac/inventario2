@php
  $breadcrumbs = [
    [
      'name' => 'Clientes',
    ],
  ];
@endphp

<x-admin-layout title="Clientes" :breadcrumbs="$breadcrumbs">
  <x-slot name="action">
    <x-wire-button blue href="{{route('admin.customers.create')}}">
      Nuevo cliente
    </x-wire-button>
  </x-slot>

  <div class="mt-4">
    @livewire('admin.datatables.customer-table')
  </div>

</x-admin-layout>