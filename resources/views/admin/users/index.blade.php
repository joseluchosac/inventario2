@php
  $breadcrumbs = [
    [
      'name' => 'Usuarios',
    ],
  ];
@endphp

<x-admin-layout title="Usuarios" :breadcrumbs="$breadcrumbs">
  <x-slot name="action">
    <div class="flex gap-2 justify-center">
      {{-- <x-wire-button flat secondary href="{{route('admin.warehouses.import')}}" title="Importar">
        <i class="fa-solid fa-file-import"></i>
      </x-wire-button> --}}
      <x-wire-button blue href="{{route('admin.users.create')}}">
        <i class="fa-solid fa-plus"></i>
        Nuevo usuario
      </x-wire-button>
    </div>
  </x-slot>
  <div class="mt-4">
    @livewire('admin.datatables.user-table')
  </div>
</x-admin-layout>