<?php

namespace App\Services\Sidebar;

class ItemHeader implements ItemInterface
{
  private string $title;
  private array $can;

  public function __construct(string $title, array $can)
  {
    $this->title = $title;
    $this->can = $can;
  }

  public function render(): string
  {
    return <<<HTML
      <li class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">
          {$this->title}
      </li>
    HTML;
  }

  public function authorize(): bool
  {
    return true;
  }

}