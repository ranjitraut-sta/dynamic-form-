@props([
    'records',
    'length' => false, // default false
])

@if ($records->hasPages())
    <nav class="d-flex justify-content-end align-items-center mt-4 gap-3">

        {{-- Show rows dropdown (only if $length is true) --}}
        @if ($length)
            <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center gap-2">
                @php
                    $perPageOptions = [10, 25, 50, 100];
                    $currentPerPage = request()->get('length', 10);
                    $queryParams = request()->except('length', 'page');
                @endphp
                <label for="lengthSelect" class="mb-0">Show rows:</label>
                <select name="length" id="lengthSelect" class="form-select form-select-sm" onchange="this.form.submit()">
                    @foreach ($perPageOptions as $option)
                        <option value="{{ $option }}" {{ $currentPerPage == $option ? 'selected' : '' }}>
                            {{ $option }}
                        </option>
                    @endforeach
                </select>

                {{-- Preserve filters --}}
                @foreach ($queryParams as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
            </form>
        @endif

        {{-- Pagination links --}}
        <ul class="amd-pagination amd-pagination-glowing mb-0">

            {{-- Previous --}}
            <li class="amd-page-item {{ $records->onFirstPage() ? 'disabled' : '' }}">
                <a class="amd-page-link" href="{{ $records->previousPageUrl() ?? '#' }}" tabindex="-1">
                    <i class="fas fa-long-arrow-alt-left"></i>
                </a>
            </li>

            @php
                $current = $records->currentPage();
                $last = $records->lastPage();
            @endphp

            @php
                $start = 1;
                $end = $last;
                $showLeftEllipsis = false;
                $showRightEllipsis = false;
                
                if ($last <= 7) {
                    // Show all pages if 7 or fewer
                    $start = 1;
                    $end = $last;
                } else {
                    // Complex logic for many pages
                    if ($current <= 4) {
                        // Current is near start: 1 2 3 4 5 ... 10
                        $start = 1;
                        $end = 5;
                        $showRightEllipsis = true;
                    } elseif ($current >= $last - 3) {
                        // Current is near end: 1 ... 6 7 8 9 10
                        $start = $last - 4;
                        $end = $last;
                        $showLeftEllipsis = true;
                    } else {
                        // Current is in middle: 1 ... 5 6 7 ... 10
                        $start = $current - 1;
                        $end = $current + 1;
                        $showLeftEllipsis = true;
                        $showRightEllipsis = true;
                    }
                }
            @endphp
            
            {{-- Show first page if not in range --}}
            @if ($showLeftEllipsis)
                <li class="amd-page-item {{ $current == 1 ? 'active' : '' }}">
                    <a class="amd-page-link" href="{{ $records->url(1) }}">1</a>
                </li>
                <li class="amd-page-item amd-page-ellipsis"><span>...</span></li>
            @endif
            
            {{-- Show main range --}}
            @for ($i = $start; $i <= $end; $i++)
                <li class="amd-page-item {{ $current == $i ? 'active' : '' }}">
                    <a class="amd-page-link" href="{{ $records->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            
            {{-- Show last page if not in range --}}
            @if ($showRightEllipsis)
                <li class="amd-page-item amd-page-ellipsis"><span>...</span></li>
                <li class="amd-page-item {{ $current == $last ? 'active' : '' }}">
                    <a class="amd-page-link" href="{{ $records->url($last) }}">{{ $last }}</a>
                </li>
            @endif

            {{-- Next --}}
            <li class="amd-page-item {{ !$records->hasMorePages() ? 'disabled' : '' }}">
                <a class="amd-page-link" href="{{ $records->nextPageUrl() ?? '#' }}">
                    <i class="fas fa-long-arrow-alt-right"></i>
                </a>
            </li>

        </ul>
    </nav>
@endif
