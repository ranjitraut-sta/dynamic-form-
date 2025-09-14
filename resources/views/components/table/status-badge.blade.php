@props([
    'status' => null,
    'type' => null,
    'label' => null,
])

@php
    // Normalize status (string/number/boolean) to lower-case string keywords
    $normalizedStatus = match (strtolower((string) $status)) {
        '1', 'true', 'active' => 'active',
        '0', 'false', 'inactive', 'o' => 'inactive',
        'blocked' => 'blocked',
        'pending' => 'pending',
        default => 'unknown',
    };

    $color = match ($normalizedStatus) {
        'active' => 'primary',
        'inactive' => 'secondary',
        'blocked' => 'danger',
        'pending' => 'warning',
        default => 'dark',
    };

    $displayLabel = $label ?? ucfirst($normalizedStatus);
@endphp

<span class="amd-badge amd-badge-outline-{{ $color }}">{{ $displayLabel }}</span>
