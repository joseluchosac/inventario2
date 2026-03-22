<div class="flex items-center space-x-2">
  <x-wire-button green 
    class="text-xl" 
    title="Enviar email"
    wire:click="openModal({{$movement->id}})"
  >
    <i class="fa-solid fa-envelope"></i>
  </x-wire-button>
  <x-wire-button blue class="text-xl" href="{{route('admin.movements.pdf', $movement)}}" title="Generar pdf">
    <i class="fa-solid fa-file-pdf"></i>
  </x-wire-button>
</div>