@php
  $breadcrumbs = [
    [
      'name' => 'Productos más vendidos',
    ],
  ];
@endphp

<x-admin-layout title="Productos más vendidos" :breadcrumbs="$breadcrumbs">
  @livewire('admin.datatables.top-products-table')
</x-admin-layout>