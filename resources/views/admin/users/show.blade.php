@php
    $breadcrumbs = [
        [
            'name' => 'Usuarios',
            'href' => route('admin.users.index'),
        ],
        [
            'name' => 'Detalles',
        ],
    ];
@endphp

<x-admin-layout title="Detalles de usuario" :breadcrumbs="$breadcrumbs">

</x-admin-layout>