<div class="relative" x-data="{ open: false }">
    <!-- Botón del selector -->
    <button @click="open = !open" type="button" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:text-gray-900 dark:hover:text-white focus:outline-none">
        <span x-show="$wire.theme === 'light'">☀️</span>
        <span x-show="$wire.theme === 'dark'">🌙</span>
        <span x-show="$wire.theme === 'system'">💻</span>
        <span class="hidden sm:block">
            <span x-show="$wire.theme === 'light'">Claro</span>
            <span x-show="$wire.theme === 'dark'">Oscuro</span>
            <span x-show="$wire.theme === 'system'">Dispositivo</span>
        </span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Menú desplegable -->
    <div x-show="open" @click.away="open = false" x-cloak class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-50">
        <div class="py-1">
            <button wire:click="setTheme('light')" @click="open = false" type="button" class="flex items-center gap-3 w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                <span>☀️</span>
                <span>Claro</span>
                <span x-show="$wire.theme === 'light'" class="ml-auto">✓</span>
            </button>
            <button wire:click="setTheme('dark')" @click="open = false" type="button" class="flex items-center gap-3 w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                <span>🌙</span>
                <span>Oscuro</span>
                <span x-show="$wire.theme === 'dark'" class="ml-auto">✓</span>
            </button>
            <button wire:click="setTheme('system')" @click="open = false" type="button" class="flex items-center gap-3 w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                <span>💻</span>
                <span>Dispositivo</span>
                <span x-show="$wire.theme === 'system'" class="ml-auto">✓</span>
            </button>
        </div>
    </div>
</div>

@push('js')
    <script>
        // Función para aplicar el tema inmediatamente
        function applyTheme(theme) {
            const root = document.documentElement;
            
            // Remover clases existentes
            root.classList.remove('dark', 'light');
            
            if (theme === 'system') {
                const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                root.classList.add(systemTheme);
                // console.log('Tema del sistema aplicado:', systemTheme);
            } else {
                root.classList.add(theme);
                // console.log('Tema aplicado:', theme);
            }
        }

        // Escuchar evento de Livewire
        document.addEventListener('livewire:init', function() {
            // Escuchar el evento del componente
            Livewire.on('themeChanged', (data) => {
                // console.log('Evento recibido:', data);
                // En Livewire v3, los datos vienen en un array
                const theme = data[0]?.theme || data.theme;
                applyTheme(theme);
            });

            // Aplicar tema inicial
            const initialTheme = @json($theme);
            applyTheme(initialTheme);
        });

        // Escuchar cambios en la preferencia del sistema
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            const themeCookie = document.cookie.split('; ').find(row => row.startsWith('theme='));
            const currentTheme = themeCookie ? themeCookie.split('=')[1] : 'system';
            
            if (currentTheme === 'system') {
                applyTheme('system');
            }
        });
    </script>
@endpush