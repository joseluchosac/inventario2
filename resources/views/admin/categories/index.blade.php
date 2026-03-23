@php
  $breadcrumbs = [
    [
      'name' => 'Categorías',
    ],
  ];
@endphp

<x-admin-layout title="Categorías" :breadcrumbs="$breadcrumbs">
  <x-slot name="action">
    <div class="flex gap-2 justify-center">
      <x-wire-button flat secondary href="{{route('admin.categories.import')}}" title="Importar">
        <i class="fa-solid fa-file-import"></i>
      </x-wire-button>
      <x-wire-button blue href="{{route('admin.categories.create')}}">
        <i class="fa-solid fa-plus"></i>
        Nueva categoría
      </x-wire-button>
    </div>
  </x-slot>

  <div class="mt-4">
    @livewire('admin.datatables.category-table')
  </div>

</x-admin-layout>