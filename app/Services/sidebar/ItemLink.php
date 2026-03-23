<?php

namespace App\Services\Sidebar;

class ItemLink implements ItemInterface
{
  private string $title;
  private string $url;
  private string $icon;
  private bool $active;
  private array $can;

  public function __construct(string $title, string $url, string $icon, bool $active, array $can)
  {
    $this->title = $title;
    $this->url = $url;
    $this->icon = $icon;
    $this->active = $active;
    $this->can = $can;
  }

  public function render(): string
  {
    $activeClass = $this->active ? 'bg-gray-100 dark:bg-gray-700' : '';

    return <<<HTML
      <a href="{$this->url}"
          class="{$activeClass} group flex items-center rounded-lg p-2 text-gray-900 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">
          <span
              class="shrink-0 text-lg text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white">
              <i class="{$this->icon}"></i>
          </span>
          <span class="ms-2">{$this->title}</span>
      </a>
    HTML;
  }

  public function authorize(): bool
  {
    return true;
  }
}