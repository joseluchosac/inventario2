<div class="flex items-center space-x-2">
  <x-wire-button blue xs
    href="{{route('admin.suppliers.edit', $supplier)}}"
  >
    Editar
  </x-wire-button>
  <form 
    class="delete-form"
    data-name="{{$supplier->name}}"
    action="{{route('admin.suppliers.destroy', $supplier)}}"
    method="post"
  >
    @csrf
    @method('DELETE')
      <x-wire-button type='submit' red xs
      >
        Eliminar
      </x-wire-button>
  </form>
</div>