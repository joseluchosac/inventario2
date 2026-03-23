@php
  $breadcrumbs = [
    [
      'name' => 'Productos',
    ],
  ];
@endphp

<x-admin-layout title="Productos" :breadcrumbs="$breadcrumbs">
  @push('css')
      <style>
        .custom-description {
          white-space: nowrap;
          max-width: 500px;
        }
        .custom-name {
          white-space: nowrap;
          max-width: 400px;
        }
      </style>
  @endpush

  <x-slot name="action">
    <div class="flex gap-2 justify-center">
      <x-wire-button flat secondary href="{{route('admin.products.import')}}" title="Importar">
        <i class="fa-solid fa-file-import"></i>
      </x-wire-button>
      <x-wire-button blue href="{{route('admin.products.create')}}">
        <i class="fa-solid fa-plus"></i>
        Nuevo producto
      </x-wire-button>
    </div>
  </x-slot>

  <div class="mt-4">
    @livewire('admin.datatables.product-table')
  </div>

</x-admin-layout>