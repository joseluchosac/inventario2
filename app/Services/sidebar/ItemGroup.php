<?php

namespace App\Services\Sidebar;

class ItemGroup implements ItemInterface
{
  private string $title;
  private string $icon;
  private bool $active;
  private array $items = [];

  public function __construct(string $title, string $icon, bool $active)
  {
    $this->title = $title;
    $this->icon = $icon;
    $this->active = $active;
  }

  public function add(ItemInterface $item): self
  {
      $this->items[] = $item;
      return $this;
  }

  public function render(): string
  {
    $open = $this->active ? 'true' : 'false';
    $itemsHtml = collect($this->items)
      ->map(function(ItemInterface $item){
        return '<li class="pl-4">'. $item->render() . '</li>';
      })->implode("\n");

    $activeClass = $this->active ? 'bg-gray-100 dark:bg-gray-700' : '';
    return <<<HTML
      <div x-data="{open:{$open}}">
        <button type="button"
            class="group flex w-full items-center rounded-lg p-2 text-base text-gray-900 transition duration-75 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {$activeClass}"
            @click="open = !open"
        >
            <span
                class="shrink-0 text-lg text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
                <i class="{$this->icon}"></i>
            </span>
            <span
                class="ms-3 flex-1 whitespace-nowrap text-left rtl:text-right">{$this->title}</span>
            <span class="text-xs">
                <i :class="{
                    'fa-solid fa-chevron-up': open,
                    'fa-solid fa-chevron-down': !open
                }"></i>
            </span>
        </button>
        <ul x-show="open" x-cloak class="space-y-2 py-2">
            {$itemsHtml}
        </ul>
    </div>
    HTML;
  }

  public function authorize(): bool
  {
    return true;
  }
}