@if (count($breadcrumbs))

  <nav>
    <ol class="flex flex-wrap">
      @foreach ($breadcrumbs as $item)
        <li
          class="{{ !$loop->first ? "pl-2 before:float-left before:pr-2 before:content-['/']" : '' }} text-sm leading-normal">

          @isset($item['href'])
            <a href="{{ $item['href'] }}" class="opacity-50">
              {{ $item['name'] }}
            </a>
          @else
            {{ $item['name'] }}
          @endisset
        </li>
      @endforeach
    </ol>

    {{-- @if (count($breadcrumbs) > 1)
      <h6 class="font-bold">
        {{ end($breadcrumbs)['name'] }}
      </h6>
    @endif --}}
  </nav>

@endif
