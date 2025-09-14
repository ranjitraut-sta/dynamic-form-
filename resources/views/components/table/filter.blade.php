@php
    $rowClass = 'row-selector position-relative';
    if (!$search) {
        $rowClass .= ' mb-3';
    }
@endphp

<form action="{{ $action }}" method="GET" class="amd-soft-subheader">
    @if ($paginate)
        <div class="row-selector position-relative {{ $rowClass }}" style="display: inline-block;">
            <label for="rowCount">Show rows:</label>
            <select name="length" class="form-select form-select-sm d-inline-block w-auto" id="rowCount"
                onchange="this.form.submit()">
                @foreach ([10, 25, 50, 100] as $num)
                    <option value="{{ $num }}" {{ request('length') == $num ? 'selected' : '' }}>
                        {{ $num }}
                    </option>
                @endforeach
            </select>
            <i class="fa-solid fa-chevron-down amd__dropdown-icon"></i>
        </div>
    @endif

    @if ($search)
        <div class="amd-soft-header-right justify-content-end">
            <div class="p-3">
                <div class="search-wrapper">
                    <input type="search" name="search" value="{{ request('search') }}" id="tableSearch"
                        aria-label="Search table" placeholder="{{ $placeholder ?? 'Search...' }}"
                        onchange="this.form.submit()" />
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                </div>
            </div>
        </div>
    @endif
</form>
