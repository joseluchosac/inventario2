<div class="flex items-center space-x-2">
  <x-wire-button green xs title="Kardex"
    href="{{route('admin.products.kardex', $product)}}"
  >
    <i class="fa-solid fa-boxes-stacked"></i>
  </x-wire-button>
  <x-wire-button blue xs title="Editar"
    href="{{route('admin.products.edit', $product)}}"
  >
    <i class="fas fa-edit"></i>
  </x-wire-button>
  <form 
    class="delete-form"
    data-name="{{$product->name}}"
    action="{{route('admin.products.destroy', $product)}}"
    method="post"
  >
    @csrf
    @method('DELETE')
      <x-wire-button type='submit' red xs title="Eliminar"
      >
        <i class="fas fa-trash"></i>
      </x-wire-button>
  </form>
</div>