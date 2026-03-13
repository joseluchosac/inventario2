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
    <x-wire-button blue href="{{route('admin.products.create')}}">
      Nuevo producto
    </x-wire-button>
  </x-slot>

  <div class="mt-4">
    @livewire('admin.datatables.product-table')
  </div>
    @push('js')
      <script>
        const forms = document.querySelectorAll('.delete-form');
        forms.forEach(form => {
          form.addEventListener('submit', e => {
            e.preventDefault();
            Swal.fire({
              title: "Confirmar eliminación",
              text: `¿Esta seguro de eliminar el producto?`,
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