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
    @push('js')
      <script>
        const forms = document.querySelectorAll('.delete-form');
        forms.forEach(form => {
          form.addEventListener('submit', e => {
            e.preventDefault();
            Swal.fire({
              title: "Confirmar eliminación",
              text: `¿Esta seguro de eliminar la categoría "${form.dataset.name}"?`,
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Sí, eliminar!",
              cancelButtonText: "No",
            }).then((result) => {
              if (result.isConfirmed) {
                form.submit()
              }
            });
          })
        })
      </script>
  @endpush
</x-admin-layout>