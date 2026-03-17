@php
  $breadcrumbs = [
    [
      'name' => 'Ordenes de Compra',
    ],
  ];
@endphp

<x-admin-layout title="Ordenes de compra" :breadcrumbs="$breadcrumbs">


  <x-slot name="action">
    <x-wire-button blue href="{{route('admin.purchase-orders.create')}}">
      Nueva orden de compra
    </x-wire-button>
  </x-slot>

  <div class="mt-4">
    @livewire('admin.datatables.purchase-order-table')
  </div>

</x-admin-layout>