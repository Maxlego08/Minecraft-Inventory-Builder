@if ($paginator->hasPages())
    <ul class="main-pagination pagination justify-content-center">
        <li class="prev page-item">
            @if ($paginator->onFirstPage())
                <a href="{{ $paginator->previousPageUrl() }}" class="page-link" title="{{ __('pagination.previous') }}">
                    <i class="bi bi-arrow-left"></i>
                </a>
            @else
                <span class="disabled page-link">
            <i class="bi bi-arrow-left"></i>
        </span>
            @endif
        </li>

        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="item page-item disabled">
                    <span>{{ $element }}</span>
                </li>
            @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="item page-item">
                                <a href="{{ $url }}" class="page-link" title="{{ __('pagination.page', ['page' => $page]) }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
        @endforeach

        <li class="next page-item">
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class=" page-link" title="{{ __('pagination.next') }}">
                    <i class="bi bi-arrow-right"></i>
                </a>
            @else
                <span class="disabled page-link">
                    <i class="bi bi-arrow-right"></i>
                </span>
            @endif
        </li>
    </ul>
@endif
