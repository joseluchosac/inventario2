<?php
return [
  [
    'type' => 'header',
    'title' => 'Principal',
  ],
  [
    'type' => 'link',
    'title' => 'Dashboard',
    'icon' => 'fa-solid fa-gauge',
    'route' => 'admin.dashboard',
    'active' => 'admin.dashboard',
  ],
  [
    'type' => 'group',
    'title' => 'Inventario',
    'icon' => 'fa-solid fa-boxes-stacked',
    'active' => ['admin.categories.*', 'admin.products.*', 'admin.warehouses.*'],
    'items' => [
      [
        'type' => 'link',
        'title' => 'Categorías',
        'route' => 'admin.categories.index',
        'active' => 'admin.categories.*',
      ],
      [
        'type' => 'link',
        'title' => 'Productos',
        'route' => 'admin.products.index',
        'active' => 'admin.products.*',
      ],
      [
        'type' => 'link',
        'title' => 'Almacenes',
        'route' => 'admin.warehouses.index',
        'active' => 'admin.warehouses.*',
      ],
    ],
  ],
  [
    'type' => 'group',
    'title' => 'Compras',
    'icon' => 'fa-solid fa-cart-shopping',
    'active' => [
      'admin.suppliers.*',
      'admin.purchase-orders.*',
      'admin.purchases.*',
    ],
    'items' => [
      [
        'type' => 'link',
        'title' => 'Proveedores',
        'route' => 'admin.suppliers.index',
        'active' => 'admin.suppliers.*',
      ],
      [
        'type' => 'link',
        'title' => 'Ordenes de Compra',
        'route' => 'admin.purchase-orders.index',
        'active' => 'admin.purchase-orders.*',
      ],
      [
        'type' => 'link',
        'title' => 'Compras',
        'route' => 'admin.purchases.index',
        'active' => 'admin.purchases.*',
      ],
    ],
  ],
  [
    'type' => 'group',
    'title' => 'Ventas',
    'icon' => 'fa-solid fa-cash-register',
    'active' => [
      'admin.customers.*',
      'admin.quotes.*',
      'admin.sales.*',
    ],
    'items' => [
      [
        'type' => 'link',
        'title' => 'Clientes',
        'route' => 'admin.customers.index',
        'active' => 'admin.customers.*',
      ],
      [
        'type' => 'link',
        'title' => 'Cotizaciones',
        'route' => 'admin.quotes.index',
        'active' => 'admin.quotes.*',
      ],
      [
        'type' => 'link',
        'title' => 'Ventas',
        'route' => 'admin.sales.index',
        'active' => 'admin.sales.*',
      ],
    ],
  ],
  [
    'type' => 'group',
    'title' => 'Movimientos',
    'icon' => 'fa-solid fa-arrows-rotate',
    'active' => [
      'admin.movements.*',
      'admin.transfers.*',
    ],
    'items' => [
      [
        'type' => 'link',
        'title' => 'Entradas y salidas',
        'route' => 'admin.movements.index',
        'active' => 'admin.movements.*',
      ],
      [
        'type' => 'link',
        'title' => 'Transferencias',
        'route' => 'admin.transfers.index',
        'active' => 'admin.transfers.*',
      ],
    ],
  ],
  [
    'type' => 'group',
    'title' => 'Reportes',
    'icon' => 'fa-solid fa-chart-line',
    'active' => [
      'admin.reports.top-products',
      'admin.reports.top-customers',
      'admin.reports.low-stocks',
    ],
    'items' => [
      [
        'type' => 'link',
        'title' => 'Productos más vendidos',
        'route' => 'admin.reports.top-products',
        'active' => 'admin.reports.top-products',
      ],
      [
        'type' => 'link',
        'title' => 'Clientes frecuentes',
        'route' => 'admin.reports.top-customers',
        'active' => 'admin.reports.top-customers',
      ],
      [
        'type' => 'link',
        'title' => 'Stocks bajos',
        'route' => 'admin.reports.low-stocks',
        'active' => 'admin.reports.low-stocks',
      ],
    ],
  ],
  [
    'type' => 'header',
    'title' => 'Configuración',
  ],
  [
    'type' => 'link',
    'title' => 'Usuarios',
    'icon' => 'fa-solid fa-users',
    'route' => 'admin.users.index',
    'active' => 'admin.users.*',
  ],
  [
    'type' => 'link',
    'title' => 'Roles',
    'icon' => 'fa-solid fa-shield-halved',
  ],
  [
    'type' => 'link',
    'title' => 'Permisos',
    'icon' => 'fa-solid fa-lock',
  ],
  [
    'type' => 'link',
    'title' => 'Ajustes',
    'icon' => 'fa-solid fa-gear',
  ],
];
