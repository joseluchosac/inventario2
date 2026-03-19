<div
    x-data="{
        products: @entangle('products').live, {{-- variable livewire declarada e sincronizada con los datos del modelo --}}
        total: @entangle('total'), {{-- variable livewire declarada e sincronizada con los datos del modelo --}}

        removeProduct(index) {
            this.products.splice(index, 1);
        },

        init()
        {
            this.$watch('products', (newProducts) => {
                let total = 0;
                newProducts.forEach(product => {
                    total += product.quantity * product.price;
                });
                this.total = total;
            });
        }
    }">
    <x-wire-card>
        <form wire:submit="save" class="space-y-4">
            <div class="grid md:grid-cols-4 gap-4">
                <x-wire-native-select label="Tipo de comprobante" wire:model="voucher_type" >
                    <option value="1">Factura</option>
                    <option value="2">Boleta</option>
                </x-wire-native-select>
                <div class="grid grid-cols-2 gap-4">
                    <x-wire-input label="Serie" wire:model="serie" disabled />
                    <x-wire-input label="Correlativo" wire:model="correlative" disabled />
                </div>
                <x-wire-input label="Fecha" wire:model="date" type="date" />
                <x-wire-select 
                    label="Cotización"
                    wire:model.live="quote_id"
                    :async-data="[
                        'api' => route('api.quotes.index'),
                        'method' => 'POST'
                    ]"
                    option-label="name"
                    option-value="id"
                    option-description="description"
                />
                <div class="col-span-2">
                    <x-wire-select 
                        label="Cliente"
                        wire:model="customer_id"
                        :async-data="[
                            'api' => route('api.customers.index'),
                            'method' => 'POST'
                        ]"
                        option-label="name"
                        option-value="id"
                    />
                </div>
                <div class="col-span-2">
                    <x-wire-select 
                        label="Almacén"
                        wire:model="warehouse_id"
                        :async-data="[
                            'api' => route('api.warehouses.index'),
                            'method' => 'POST'
                        ]"
                        option-label="name"
                        option-value="id"
                        option-description="description"
                    />
                </div>
            </div>
            <div class="md:flex gap-4">
                <x-wire-select 
                    label="Producto"
                    wire:model="product_id"
                    :async-data="[
                        'api' => route('api.products.index'),
                        'method' => 'POST'
                    ]"
                    option-label="name"
                    option-value="id"
                    class="flex-1"
                />
                <div class="h-10 mt-3 md:mt-6.5 justify-self-center">
                    <x-wire-button
                        wire:click="addProduct"
                        class="text-nowrap"
                        spinner
                    >
                        Agregar producto
                    </x-wire-button>
                </div>
            </div>
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="py-2 px-4">Producto</th>
                            <th class="py-2 px-4">Cantidad</th>
                            <th class="py-2 px-4">Precio</th>
                            <th class="py-2 px-4">Subtotal</th>
                            <th class="py-2 px-4"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(product, index) in products" :key="product.id">
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <td 
                                    class="px-6 py-2" 
                                    x-text="product.name"
                                >
                                </td>
                                <td class="px-6 py-2">
                                    <x-wire-input
                                        x-model.live="product.quantity"
                                        type="number"
                                        class="w-20"
                                        min="0"
                                    />
                                </td>
                                <td class="px-6 py-2">
                                    <x-wire-input
                                        x-model.live="product.price"
                                        type="number"
                                        class="w-20"
                                        step="0.01"
                                        min="0"
                                    />
                                </td>
                                <td 
                                    class="px-6 py-2"
                                    x-text="(product.quantity * product.price).toFixed(2)"
                                >
                                </td>
                                <td class="px-6 py-2">
                                    <x-wire-mini-button
                                        x-on:click="removeProduct(index)" {{-- metodo de alpine --}}
                                        rounded
                                        icon='trash' 
                                        red
                                    />
                                </td>
                            </tr>
                        </template>

                        <template x-if="!products.length">
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                <td colspan="5" class="text-center px-6 py-4">No hay productos agregados</td>
                            </tr>
                        </template>

                    </tbody>
                </table>
            </div>
            <div class="md:flex md:items-center space-x-4 mt-4">
                <x-wire-input
                    label="Observaciones"
                    class="flex-1"
                    wire:model="observation"
                />
                <div class="text-lg text-center mt-4">
                    Total: S/ <span x-text="total.toFixed(2)"></span>
                </div>
            </div>
            <div class="text-center md:text-end mt-6">
                <x-wire-button
                    type='submit'
                    icon='check'
                    spinner
                >
                    Guardar venta
                </x-wire-button>

            </div>
        </form>
    </x-wire-card>
</div>
