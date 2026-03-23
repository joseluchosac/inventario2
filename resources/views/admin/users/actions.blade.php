<div class="flex items-center space-x-2">
  <x-wire-button blue xs
    href="{{route('admin.users.edit', $user)}}"
  >
    Editar
  </x-wire-button>
  <form 
    class="delete-form"
    data-name="{{$user->name}}"
    action="{{route('admin.users.destroy', $user)}}"
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