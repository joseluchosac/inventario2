@php
  $breadcrumbs = [
    [
      'name' => 'Entradas y salidas',
    ],
  ];
@endphp

<x-admin-layout title="Entradas y salidas" :breadcrumbs="$breadcrumbs">


  <x-slot name="action">
    <x-wire-button blue href="{{route('admin.movements.create')}}">
      Nuevo movimiento
    </x-wire-button>
  </x-slot>

  <div class="mt-4">
    @livewire('admin.datatables.movement-table')
  </div>

</x-admin-layout>