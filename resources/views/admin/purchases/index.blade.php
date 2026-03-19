@php
  $breadcrumbs = [
    [
      'name' => 'Compras',
    ],
  ];
@endphp

<x-admin-layout title="Compras" :breadcrumbs="$breadcrumbs">


  <x-slot name="action">
    <x-wire-button blue href="{{route('admin.purchases.create')}}">
      Nueva compra
    </x-wire-button>
  </x-slot>

  <div class="mt-4">
    @livewire('admin.datatables.purchase-table')
  </div>

</x-admin-layout>