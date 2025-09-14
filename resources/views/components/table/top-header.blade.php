<div class="amd-soft-table-header {{ $class ?? '' }}">
    <h4 class="amd-soft-table-title">{{ $title ?? 'List' }}</h4>

    @if (isset($createRoute))
        <div class="amd-soft-header-right">
            @if ($column)
                <button class="amd-btn amd-btn-secondary amd-btn-sm" id="columnsBtn" type="button">
                    <i class="fas fa-columns"></i>
                    {{ $columnLabel }}
                </button>
            @endif

            <a href="{{ $createRoute }}" class="amd-btn amd-btn-primary amd-btn-sm">
                <i class="fa-solid fa-plus"></i> {{ $createLabel ?? 'Add New' }}
            </a>
        </div>
    @endif
</div>
