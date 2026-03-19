<div>
    <h2 class="text-lg font-semibold mb-4 dark:text-gray-400 text-gray-700">
        KARDEX DEL PRODUCTO: <span class="dark:text-gray-200 text-gray-900">{{ $product->name }}</span>
    </h2>
    <x-wire-card class="mb-6">
        <div class="grid grid-cols-2 gap-4">
            <x-wire-input label="Fecha inicial" type="date" wire:model.live="fecha_inicial" />
            <x-wire-input label="Fecha final" type="date" wire:model.live="fecha_final" />
            <x-wire-select
                class="col-span-2"
                label="Almacén"
                wire:model.live="warehouse_id"
                :options="$warehouses->select('id', 'name')"
                option-label="name"
                option-value="id"
            />
        </div>
    </x-wire-card>
    
    @if ($inventories->count())
        <div class="relative overflow-x-auto rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-2 text-center" rowspan="2">
                            Producto
                        </th>
                        <th class="px-6 py-2 text-center bg-green-100 dark:bg-green-900" colspan="3">
                            Ingreso
                        </th>
                        <th class="px-6 py-2 text-center bg-orange-100 dark:bg-orange-900" colspan="3">
                            Salida
                        </th>
                        <th class="px-6 py-2 text-center bg-blue-100 dark:bg-blue-900" colspan="3">
                            Balance
                        </th>
                        <th class="px-6 py-2 text-center" rowspan="2">
                            Fecha
                        </th>
                    <tr>

                        <th scope="col" class="px-6 py-2 bg-green-100 dark:bg-green-900">
                            Cant.
                        </th>
                        <th scope="col" class="px-6 py-2 bg-green-100 dark:bg-green-900">
                            Costo
                        </th>
                        <th scope="col" class="px-6 py-2 bg-green-100 dark:bg-green-900">
                            Total
                        </th>
                        <th scope="col" class="px-6 py-2 bg-orange-100 dark:bg-orange-900">
                            Cant.
                        </th>
                        <th scope="col" class="px-6 py-2 bg-orange-100 dark:bg-orange-900">
                            Costo
                        </th>
                        <th scope="col" class="px-6 py-2 bg-orange-100 dark:bg-orange-900">
                            Total
                        </th>
                        <th scope="col" class="px-6 py-2 bg-blue-100 dark:bg-blue-900">
                            Cant.
                        </th>
                        <th scope="col" class="px-6 py-2 bg-blue-100 dark:bg-blue-900">
                            Costo
                        </th>
                        <th scope="col" class="px-6 py-2 bg-blue-100 dark:bg-blue-900">
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventories as $inventory)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{$inventory->detail}}
                            </th>
                            <td class="px-6 py-4">
                            {{$inventory->quantity_in}}
                            </td>
                            <td class="px-6 py-4">
                                {{$inventory->cost_in}}
                            </td>
                            <td class="px-6 py-4">
                                {{$inventory->total_in}}
                            </td>
                            <td class="px-6 py-4">
                                {{$inventory->quantity_out}}
                            </td>
                            <td class="px-6 py-4">
                                {{$inventory->cost_out}}
                            </td>
                            <td class="px-6 py-4">
                                {{$inventory->total_out}}
                            </td>
                            <td class="px-6 py-4">
                                {{$inventory->quantity_balance}}
                            </td>
                            <td class="px-6 py-4">
                                {{$inventory->cost_balance}}
                            </td>
                            <td class="px-6 py-4">
                                {{$inventory->total_balance}}
                            </td>
                            <td class="px-6 py-4">
                                {{$inventory->created_at->format('Y-m-d')}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{$inventories->links()}}
        </div>
    @else
        <div class="text-center">
            No hay registro de inventario para este producto
        </div>
    @endif
</div>
