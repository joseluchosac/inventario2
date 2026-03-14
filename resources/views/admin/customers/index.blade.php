@php
  $breadcrumbs = [
    [
      'name' => 'Clientes',
    ],
  ];
@endphp

<x-admin-layout title="Clientes" :breadcrumbs="$breadcrumbs">
  <x-slot name="action">
    <x-wire-button blue href="{{route('admin.customers.create')}}">
      Nuevo cliente
    </x-wire-button>
  </x-slot>

  <div class="mt-4">
    @livewire('admin.datatables.customer-table')
  </div>
    @push('js')
      <script>
        const forms = document.querySelectorAll('.delete-form');
        forms.forEach(form => {
          form.addEventListener('submit', e => {
            e.preventDefault();
            Swal.fire({
              title: "Confirmar eliminación",
              text: `¿Esta seguro de eliminar el cliente "${form.dataset.name}"?`,
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