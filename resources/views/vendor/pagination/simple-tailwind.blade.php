@if ($paginator->hasPages())
<div class="flex">
    <div class="flex-auto">
    </div>
    <div class="justify-items-center content-center justify-center items-center">
        <div class="join p-4">
            @if ($paginator->onFirstPage())
                <span class="join-item btn btn-sm btn-outline">Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="join-item btn btn-sm btn-outline">Previous</a>
            @endif


            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="join-item btn btn-sm btn-outline">Next</a>
            @else
                <span class="join-item btn btn-sm btn-outline">Next</span>
            @endif
        </div>
    </div>
</div>
@endif
