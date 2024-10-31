@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-sm mt-2">
            @if ($paginator->onFirstPage())
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)" tabindex="-1" aria-label="Previous">
                    <span aria-hidden="true">
                        <i data-feather='chevron-left'></i>
                    </span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" tabindex="-1" aria-label="Previous">
                    <span aria-hidden="true">
                        <i data-feather='chevron-left'></i>
                    </span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            @endif
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
                        </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                    <span aria-hidden="true">
                        <i data-feather='chevron-right'></i>
                    </span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
            @else
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)" aria-label="Next">
                    <span aria-hidden="true">
                        <i data-feather='chevron-right'></i>
                    </span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
            @endif
        </ul>
    </nav>
@endif
