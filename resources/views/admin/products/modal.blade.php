
<x-wire-modal-card title="Stock por almacén" wire:model="openModal">
  <ul class="space-y-3">
    @forelse ($inventories as $inventory)
        <li class="flex items-center justify-between p-4 rounded-lg shadow-sm">
          <div>
            <p class="text-lg uppercase font-bold">
              {{ $inventory->warehouse->name }}
            </p>
            <p class="text-sm">
              {{ $inventory->warehouse->location }}
            </p>
          </div>
          <div class="text-lg font-bold">
            <p>
              {{ $inventory->quantity_balance }}
            </p>
          </div>
        </li>
    @empty
        <li class="text-center py-6">
          No hay inventarios disponibles
        </li>
    @endforelse
  </ul>
</x-wire-modal-card>
