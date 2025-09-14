@props([
    'status' => null,
    'label' => null,
])

@php
    // Normalize status to only 'active' or 'inactive'
    $normalizedStatus = match(strtolower((string) $status)) {
        '1', 'true', 'active' => 'active',
        '0', 'false', 'inactive', '2' => 'inactive',
        default => 'unknown',
    };

    // Only two colors
    $color = match($normalizedStatus) {
        'active' => 'success',
        'inactive' => 'secondary',
        default => 'dark',
    };

    $displayLabel = $label ?? ucfirst($normalizedStatus);
@endphp

<span class="amd-badge amd-badge-outline-{{ $color }}">{{ $displayLabel }}</span>
