@if ($paginator->lastPage() > 1)
  <ul class="uk-pagination uk-pagination-right">
    @if ($paginator->currentPage() >= 4)
      <li class="blue">
        <a href="{{ $paginator->url(1) }}" >
          <<
        </a>
      </li>
    @endif

{{--    @if($paginator->currentPage() != 1)
      <li>
        <a href="{{ $paginator->url($paginator->currentPage()-1) }}" >
          <
        </a>
      </li>
    @endif--}}

    @for($i = max($paginator->currentPage()-2, 1); $i <= min(max($paginator->currentPage()-2, 1)+4,$paginator->lastPage()); $i++)
      <li class="{{ ($paginator->currentPage() == $i) ? ' uk-active' : '' }}">
        <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
      </li>
    @endfor

{{--    @if ($paginator->currentPage() != $paginator->lastPage())
      <li>
        <a href="{{ $paginator->url($paginator->currentPage()+1) }}" >
          >
        </a>
      </li>
    @endif--}}

    @if ($paginator->currentPage() <= ($paginator->lastPage() - 3) && $paginator->lastPage() >= 5)
      <li class="blue">
        <a href="{{ $paginator->url($paginator->lastPage()) }}" >
          >>
        </a>
      </li>
    @endif

    </ul>
@endif