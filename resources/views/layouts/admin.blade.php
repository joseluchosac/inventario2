@props([
  'title' => "",
  'breadcrumbs' => []
])

@php
    $themeCookie = Cookie::get('theme', 'system');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ? $title . ' | ' . config('app.name', 'Laravel') : config('app.name', 'Laravel')}}</title>

    {{-- theme --}}
    <script>
        (function() {
            try {
                const theme = @json($themeCookie);
                const root = document.documentElement;
                
                // Aplicar tema inmediatamente
                if (theme === 'system') {
                    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                    root.classList.add(systemTheme);
                } else {
                    root.classList.add(theme);
                }

                
                // Guardar en window para debug
                window.currentTheme = theme;
            } catch (e) {
                console.warn('Error applying theme:', e);
                // Fallback seguro
                document.documentElement.classList.add('light');
            }
        })();
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- fontawesome --}}
    <script src="https://kit.fontawesome.com/404907bd95.js" crossorigin="anonymous"></script>
    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <wireui:scripts />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    @stack('css')
</head>

<body class="font-sans antialiased bg-slate-50 dark:bg-gray-900 text-gray-900 dark:text-slate-50">

    @include('layouts.includes.admin.navigation')
    @include('layouts.includes.admin.sidebar')

    <div class="md:p-2 sm:ml-64">
        <div class="mt-14 rounded-lg border-gray-200 p-4 dark:border-gray-700">
      <div class="md:flex md:justify-between md:items-center">
        @include('layouts.includes.admin.breadcrumb')
        @isset($action)
          {{$action }}
        @endisset
      </div>

      {{ $slot }}
    </div>
    </div>



    @stack('modals')

    @livewireScripts

    {{-- flowbite --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

    {{-- Script para eventos livewire --}}
    <script>
        Livewire.on('swal', function(data){
            Swal.fire(data[0]);
        })

    </script>

    {{-- Script para eventos flash --}}
    @if (session('swal'))
        <script>
            Swal.fire(@json(session('swal')));
        </script>
    @endif

          <script>
        const forms = document.querySelectorAll('.delete-form');
        forms.forEach(form => {
          form.addEventListener('submit', e => {
            e.preventDefault();
            Swal.fire({
              title: "Confirmar eliminación",
              text: `¡No podrás revertir esta acción!`,
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Sí, eliminar!",
              cancelButtonText: "No",
            }).then((result) => {
              if (result.isConfirmed) {
                form.submit()
              }
            });
          })
        })
      </script>

    @stack('js')

</body>

</html>
