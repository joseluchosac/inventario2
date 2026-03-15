<div class="flex items-center space-x-2">
  <x-wire-button blue xs
    href="{{route('admin.warehouses.edit', $warehouse)}}"
  >
    Editar
  </x-wire-button>
  <form 
    class="delete-form"
    data-name="{{$warehouse->name}}"
    action="{{route('admin.warehouses.destroy', $warehouse)}}"
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