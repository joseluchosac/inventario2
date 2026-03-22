@php
    $breadcrumbs = [
        [
            'name' => 'Productos',
            'href' => route('admin.products.index'),
        ],
        [
            'name' => 'Nuevo',
        ],
    ];
@endphp

<x-admin-layout title="Nuevo producto" :breadcrumbs="$breadcrumbs">


    <div class="max-w-4xl mx-auto">
        <x-wire-card>
            <form class="space-y-4" action="{{ route('admin.products.store') }}" method="POST">
                @csrf
                <x-wire-input label="Nombre" name="name" value="{{ old('name') }}" />
                
                <x-wire-textarea label="Descripción" name="description">
                    {{ old('description') }}
                </x-wire-textarea>

                <x-wire-input label="Precio" name="price" value="{{ old('price') }}" type="number" step="0.01" />

                <x-wire-native-select label="Categoría" name="category_id">
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}" @selected(old('category_id') == $category->id) >
                            {{$category->name}}
                        </option>
                    @endforeach
                </x-wire-native-select>
                <x-wire-input label="Stock mínimo" name="min_stock" value="{{ old('min_stock'. 5) }}" type="number" step="1" />
                <div class="flex justify-end items-center gap-4">
                    <a href="{{ route('admin.products.index') }}">
                        <button type="button">Cancelar</button>
                    </a>
                    <x-button type="submit">Guardar</x-button>
                </div>

            </form>
        </x-wire-card>
    </div>
</x-admin-layout>
