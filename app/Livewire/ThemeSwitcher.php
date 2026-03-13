<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Cookie;
use Livewire\Component;

class ThemeSwitcher extends Component
{

    public string $theme = 'system';

    public function mount(): void
    {
        $this->theme = Cookie::get('theme', 'system');
    }

    public function setTheme(string $theme): void
    {
        $this->theme = $theme;
        Cookie::queue('theme', $theme, 60 * 24 * 365);

        // Enviamos el evento con los datos
        $this->dispatch('themeChanged', theme: $theme);
    }



    public function render()
    {
        return view('livewire.theme-switcher');
    }
}
