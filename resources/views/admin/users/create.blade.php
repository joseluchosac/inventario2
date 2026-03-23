@php
    $breadcrumbs = [
        [
            'name' => 'Usuarios',
            'href' => route('admin.users.index'),
        ],
        [
            'name' => 'Nuevo',
        ],
    ];
@endphp

<x-admin-layout title="Nuevo usuario" :breadcrumbs="$breadcrumbs">
    <div class="max-w-4xl mx-auto">
        <x-wire-card>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <x-wire-input label="Nombre" name="name" value="{{ old('name') }}" />
                    <x-wire-input label="Email" name="email" type="email" value="{{ old('email') }}" />
                    <x-wire-input label="Contraseña" name="password" type="password" />
                    <x-wire-input label="Confirmar contraseña" name="password_confirmation" type="password" />
                </div>
                <div class="flex justify-end items-center gap-4 mt-4">
                    <a href="{{ route('admin.users.index') }}">
                        <button type="button">Cancelar</button>
                    </a>
                    <x-button type="submit">Guardar</x-button>
                </div>

            </form>
        </x-wire-card>
    </div>
</x-admin-layout>
