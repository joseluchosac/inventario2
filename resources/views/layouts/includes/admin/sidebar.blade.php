@php
    $links = [
        [
            'header' => 'Principal',
        ],
        [
            'name' => 'dashboard',
            'title' => 'Dashboard',
            'icon' => 'fa-solid fa-gauge',
            'href' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
        ],
        [
            'name' => 'inventory',
            'title' => 'Inventario',
            'icon' => 'fa-solid fa-boxes-stacked',
            'href' => '#',
            'active' => request()->routeIs(['admin.categories.*', 'admin.products.*', 'admin.warehouses.*']),
            'submenu' => [
                [
                    'name' => 'categories',
                    'title' => 'Categorías',
                    'icon' => 'fa-solid fa-list',
                    'href' => route('admin.categories.index'),
                    'active' => request()->routeIs('admin.categories.*'),
                ],
                [
                    'name' => 'products',
                    'title' => 'Productos',
                    'icon' => 'fa-solid fa-box',
                    'href' => route('admin.products.index'),
                    'active' => request()->routeIs('admin.products.*'),
                ],
                [
                    'name' => 'warehouses',
                    'title' => 'Almacenes',
                    'icon' => 'fa-solid fa-warehouse',
                    'href' => route('admin.warehouses.index'),
                    'active' => request()->routeIs('admin.warehouses.*'),
                ],
            ],
        ],
        [
            'name' => 'purchases',
            'title' => 'Compras',
            'icon' => 'fa-solid fa-cart-shopping',
            'href' => '#',
            'active' => request()->routeIs([
                'admin.suppliers.*',
                'admin.purchase-orders.*',
                'admin.purchases.*',
            ]),
            'submenu' => [
                [
                    'name' => 'Proveedores',
                    'title' => 'Proveedores',
                    'icon' => 'fa-solid fa-truck',
                    'href' => route('admin.suppliers.index'),
                    'active' => request()->routeIs('admin.suppliers.*'),
                ],
                [
                    'name' => 'purchase_orders',
                    'title' => 'Ordenes de Compra',
                    'icon' => 'fa-solid fa-truck',
                    'href' => route('admin.purchase-orders.index'),
                    'active' => request()->routeIs('admin.purchase-orders.*'),
                ],
                [
                    'name' => 'purchases',
                    'title' => 'Compras',
                    'icon' => 'fa-solid fa-truck',
                    'href' => '',
                    'active' => false,
                ],
            ],
        ],
        [
            'name' => 'sales',
            'title' => 'Ventas',
            'icon' => 'fa-solid fa-cash-register',
            'href' => '#',
            'active' => request()->routeIs(['admin.customers.*']),
            'submenu' => [
                [
                    'name' => 'customers',
                    'title' => 'Clientes',
                    'icon' => 'fa-solid fa-users',
                    'href' => route('admin.customers.index'),
                    'active' => request()->routeIs('admin.customers.*'),
                ],
                [
                    'name' => 'quotes',
                    'title' => 'Cotizaciones',
                    'icon' => 'fa-solid fa-truck',
                    'href' => '',
                    'active' => false,
                ],
                [
                    'name' => 'sales',
                    'title' => 'Ventas',
                    'icon' => 'fa-solid fa-truck',
                    'href' => '',
                    'active' => false,
                ],
            ],
        ],
        [
            'name' => 'movements',
            'title' => 'Movimientos',
            'icon' => 'fa-solid fa-arrows-rotate',
            'href' => '#',
            'active' => request()->routeIs(['admin.customers.*']),
            'submenu' => [
                [
                    'name' => 'in_out',
                    'title' => 'Entradas y salidas',
                    'icon' => 'fa-solid fa-users',
                    'href' => route('admin.customers.index'),
                    'active' => request()->routeIs('admin.customers.*'),
                ],
                [
                    'name' => 'transfers',
                    'title' => 'Transferencias',
                    'icon' => 'fa-solid fa-truck',
                    'href' => '',
                    'active' => false,
                ],
            ],
        ],
        [
            'name' => 'reports',
            'title' => 'Reportes',
            'icon' => 'fa-solid fa-chart-line',
            'href' => '#',
            'active' => request()->routeIs(['admin.customers.*']),
            'submenu' => [
                [
                    'name' => 'nothin',
                    'title' => 'nada',
                    'icon' => 'fa-solid fa-users',
                    'href' => route('admin.customers.index'),
                    'active' => request()->routeIs('admin.customers.*'),
                ],
            ],
        ],
        [
            'header' => 'Configuración',
        ],
        [
            'name' => 'users',
            'title' => 'Usuarios',
            'icon' => 'fa-solid fa-users',
            'href' => '',
            'active' => false,
        ],
        [
            'name' => 'roles',
            'title' => 'Roles',
            'icon' => 'fa-solid fa-shield-halved',
            'href' => '',
            'active' => false,
        ],
        [
            'name' => 'permissions',
            'title' => 'Permisos',
            'icon' => 'fa-solid fa-lock',
            'href' => '',
            'active' => false,
        ],
        [
            'name' => 'settings',
            'title' => 'Ajustes',
            'icon' => 'fa-solid fa-gear',
            'href' => '',
            'active' => false,
        ],
    ];
@endphp

<aside id="logo-sidebar"
    class="fixed left-0 top-0 z-40 h-screen w-64 -translate-x-full border-r border-gray-200 bg-white pt-20 transition-transform sm:translate-x-0 dark:border-gray-700 dark:bg-gray-800"
    aria-label="Sidebar">
    <div class="h-full overflow-y-auto bg-white px-3 pb-4 dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            @foreach ($links as $link)
                @if (isset($link['header']))
                    <li class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">
                        {{ $link['header'] }}
                    </li>
                @else
                    @if (isset($link['submenu']))
                        <li>
                            <button type="button"
                                class="group flex w-full items-center rounded-lg p-2 text-base text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ $link['active'] ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                                aria-controls="{{ $link['name']}}" data-collapse-toggle="{{ $link['name']}}">
                                <span
                                    class="shrink-0 text-lg text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
                                    <i class="{{ $link['icon'] }}"></i>
                                </span>
                                <span
                                    class="ms-3 flex-1 whitespace-nowrap text-left rtl:text-right">{{ $link['title'] }}</span>
                                <span class="text-xs">
                                    @if ($link['active'])
                                        <i class="fa-solid fa-chevron-left"></i>
                                    @else
                                        <i class="fa-solid fa-chevron-down"></i>
                                    @endif
                                </span>
                            </button>
                            <ul id="{{ $link['name']}}" class="{{ $link['active'] ? '' : 'hidden' }} space-y-2 py-2">
                                @foreach ($link['submenu'] as $subitem)
                                    <li>
                                        <a href="{{ $subitem['href'] }}"
                                            class="group flex w-full items-center rounded-lg p-2 pl-11 text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ $subitem['active'] ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                            {{ $subitem['title'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li>
                            <a href="{{ $link['href'] }}"
                                class="{{ $link['active'] ? 'bg-gray-100 dark:bg-gray-700' : '' }} group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
                                <span
                                    class="shrink-0 text-lg text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
                                    <i class="{{ $link['icon'] }}"></i>
                                </span>
                                <span class="ms-2">{{ $link['title'] }}</span>
                            </a>
                        </li>
                    @endif
                @endif
            @endforeach

        </ul>
    </div>
</aside>
