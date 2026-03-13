@php
  $links = [
      [
          'name' => 'Dashboard',
          'icon' => 'fa-solid fa-gauge',
          'href' => route('admin.dashboard'),
          'active' => request()->routeIs('admin.dashboard'),
      ],
      [
          'name' => 'Categorías',
          'icon' => 'fa-solid fa-list',
          'href' => route('admin.categories.index'),
          'active' => request()->routeIs('admin.categories.*'),
      ],
      [
          'name' => 'Productos',
          'icon' => 'fa-solid fa-box',
          'href' => route('admin.products.index'),
          'active' => request()->routeIs('admin.products.*'),
      ],
      [
          'header' => 'Administrar página',
      ],
      [
          'name' => 'Otros',
          'icon' => 'fa-solid fa-user',
          'href' => route('admin.dashboard'),
          'active' => request()->routeIs('admin.otros'),
      ],
      [
          'name' => 'E-commerce',
          'icon' => 'fa-solid fa-cart-shopping',
          'href' => '#',
          'active' => false,
          'submenu' => [
              [
                  'name' => 'Products',
                  'href' => '#',
                  'active' => request()->routeIs('admin.commerce.products'),
              ],
              [
                  'name' => 'Billing',
                  'href' => '#',
                  'active' => false,
              ],
              [
                  'name' => 'Invoice',
                  'href' => '#',
                  'active' => request()->routeIs('admin.commerce.invoice'),
              ],
          ],
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
                class="group flex w-full items-center rounded-lg p-2 text-base text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{$link['active'] ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                <span
                  class="shrink-0 text-lg text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
                  <i class="{{ $link['icon'] }}"></i>
                </span>
                <span class="ms-3 flex-1 whitespace-nowrap text-left rtl:text-right">{{ $link['name'] }}</span>
                <span class="text-xs">
                  @if ($link['active'])
                    <i class="fa-solid fa-chevron-left"></i>
                  @else
                    <i class="fa-solid fa-chevron-down"></i>
                  @endif
                </span>
              </button>
              <ul id="dropdown-example" class="hidden space-y-2 py-2">
                @foreach ($link['submenu'] as $subitem)
                  <li>
                    <a href="{{$subitem['href'] }}"
                      class="group flex w-full items-center rounded-lg p-2 pl-11 text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{$subitem['active'] ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                        {{ $subitem['name'] }}
                      </a>
                  </li>
                @endforeach
              </ul>
            </li>
          @else
            <li>
              <a href="{{ $link['href'] }}"
                class="{{ $link['active'] ? 'bg-gray-100 dark:bg-gray-700' : '' }} group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"">
                <span
                  class="shrink-0 text-lg text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
                  <i class="{{ $link['icon'] }}"></i>
                </span>
                <span class="ms-2">{{ $link['name'] }}</span>
              </a>
            </li>
          @endif
        @endif
      @endforeach

    </ul>
  </div>
</aside>

