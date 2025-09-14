
@props([
    'route',
    'id',
    'class' => 'btn btn-sm btn-default',
    'title' => '',
    'icon' => 'fa fa-edit',
])

<a href="{{ route($route, $id) }}" class="{{ $class }}" title="{{ $title }}">
    <span class="{{ $icon }}"></span>
</a>
