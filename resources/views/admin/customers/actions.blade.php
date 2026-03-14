<div class="flex items-center space-x-2">
  <x-wire-button blue xs
    href="{{route('admin.customers.edit', $customer)}}"
  >
    Editar
  </x-wire-button>
  <form 
    class="delete-form"
    data-name="{{$customer->name}}"
    action="{{route('admin.customers.destroy', $customer)}}"
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