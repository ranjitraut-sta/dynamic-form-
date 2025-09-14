@props([
    'title' => 'Page Title',
    'items' => [],  // array of ['label' => '...', 'url' => '...', 'active' => bool]
])

<div class="notifications-header">
    <h1>{{ $title }}</h1>
    <div class="breadcrumb-nav">
        @foreach ($items as $index => $item)
            <a href="{{ $item['url'] ?? '#' }}"
               @if(!empty($item['active'])) class="active-link" @endif>
               {{ $item['label'] }}
            </a>
            @if ($index !== count($items) - 1)
                <span>&gt;</span>
            @endif
        @endforeach
    </div>
</div>
