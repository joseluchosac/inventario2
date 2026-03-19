@php
  $breadcrumbs = [
    [
      'name' => 'Transferencias',
    ],
  ];
@endphp

<x-admin-layout title="Transferencias" :breadcrumbs="$breadcrumbs">


  <x-slot name="action">
    <x-wire-button blue href="{{route('admin.transfers.create')}}">
      Nueva transferencia
    </x-wire-button>
  </x-slot>

  <div class="mt-4">
    @livewire('admin.datatables.transfer-table')
  </div>

</x-admin-layout>