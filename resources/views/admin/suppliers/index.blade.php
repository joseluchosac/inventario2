@php
  $breadcrumbs = [
    [
      'name' => 'Proveedores',
    ],
  ];
@endphp

<x-admin-layout title="Proveedores" :breadcrumbs="$breadcrumbs">
  <x-slot name="action">
    <x-wire-button blue href="{{route('admin.suppliers.create')}}">
      Nuevo proveedor
    </x-wire-button>
  </x-slot>

  <div class="mt-4">
    @livewire('admin.datatables.supplier-table')
  </div>

</x-admin-layout>