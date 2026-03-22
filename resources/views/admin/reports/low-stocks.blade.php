@php
  $breadcrumbs = [
    [
      'name' => 'Stocks bajos',
    ],
  ];
@endphp

<x-admin-layout title="Stocks bajos" :breadcrumbs="$breadcrumbs">

    @livewire('admin.datatables.low-stock-table')

</x-admin-layout>