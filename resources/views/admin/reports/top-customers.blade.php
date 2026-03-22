@php
  $breadcrumbs = [
    [
      'name' => 'Clientes frecuentes',
    ],
  ];
@endphp

<x-admin-layout title="Clientes frecuentes" :breadcrumbs="$breadcrumbs">

  @livewire('admin.datatables.top-customers-table')

</x-admin-layout>