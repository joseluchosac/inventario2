@php
    $breadcrumbs = [
        [
            'name' => 'Proveedores',
            'href' => route('admin.suppliers.index'),
        ],
        [
            'name' => 'Nuevo',
        ],
    ];
@endphp

<x-admin-layout title="Nuevo proveedor" :breadcrumbs="$breadcrumbs">
    <div class="max-w-4xl mx-auto">
        <x-wire-card>
            <form class="space-y-4" action="{{ route('admin.suppliers.store') }}" method="POST">
                @csrf
                <div class="grid md:grid-cols-2 gap-4">
                    <x-wire-native-select label="Tipo de documento" name="identity_id">
                        @foreach ($identities as $identity)
                            <option value="{{$identity->id}}" @selected(old('identity_id') == $identity->id) >
                                {{$identity->name}}
                            </option>
                        @endforeach
                    </x-wire-native-select>
                    <x-wire-input label="Nro. de documento" name="document_number" value="{{ old('document_number') }}" />
                </div>
                <x-wire-input label="Nombre" name="name" value="{{ old('name') }}" />
                <x-wire-input label="Dirección" name="address" value="{{ old('address') }}" />
                <x-wire-input label="email" name="email" value="{{ old('email') }}" />
                <x-wire-input label="Teléfono" name="phone" value="{{ old('phone') }}" />

                <div class="flex justify-end items-center gap-4">
                    <a href="{{ route('admin.suppliers.index') }}">
                        <button type="button">Cancelar</button>
                    </a>
                    <x-button type="submit">Guardar</x-button>
                </div>

            </form>
        </x-wire-card>
    </div>
</x-admin-layout>
