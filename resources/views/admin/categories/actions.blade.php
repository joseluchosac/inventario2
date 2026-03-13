<div class="flex items-center space-x-2">
  <x-wire-button blue xs
    href="{{route('admin.categories.edit', $category)}}"
  >
    Editar
  </x-wire-button>
  <form 
    class="delete-form"
    data-name="{{$category->name}}"
    action="{{route('admin.categories.destroy', $category)}}"
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