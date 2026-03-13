<div class="flex items-center space-x-2">
  <x-wire-button blue xs
    href="{{route('admin.products.edit', $product)}}"
  >
    Editar
  </x-wire-button>
  <form 
    class="delete-form"
    data-name="{{$product->name}}"
    action="{{route('admin.products.destroy', $product)}}"
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