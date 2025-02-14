@if ($paginator->hasPages())
  <div class="join mt-5 justify-center">
    @if ($paginator->onFirstPage())
        <a class="join-item btn btn-sm btn-disabled">Prev</a>
    @else
        <a class="join-item btn btn-sm" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">Prev</a>
    @endif
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <a class="join-item btn btn-sm">{{ $element }}</a>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <a class="join-item btn btn-sm btn-disabled">{{ $page }}</a>
                @else
                    <a class="join-item btn btn-sm btn-disabled" href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->hasMorePages())
        <a class="join-item btn btn-sm" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
    @else
        <a class="join-item btn btn-sm btn-disabled" rel="next">Next</a>
    @endif
  </div>
@endif

