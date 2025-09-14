<ul class="nav flex-column active amd-sidebar-nav nav nav-pills p-3 gap-3">
    @if (auth()->check())
        @foreach ($items as $index => $item)
            @php
                $hasSubmenu = isset($item['submenu']);

                $permittedSubmenu = collect($item['submenu'] ?? [])->filter(function ($sub) {
                    if (!isset($sub['permission']['controller'], $sub['permission']['method'])) {
                        return true; // allow items without permission
                    }

                    return Blade::check('canAccess', [$sub['permission']['controller'], $sub['permission']['method']]);
                });

                // Check permission for single items
                $hasPermission = true;
                if (!$hasSubmenu && isset($item['permission']['controller'], $item['permission']['method'])) {
                    $hasPermission = Blade::check('canAccess', [
                        $item['permission']['controller'],
                        $item['permission']['method'],
                    ]);
                }

                $shouldDisplayParent =
                    (!$hasSubmenu && $hasPermission) || ($hasSubmenu && $permittedSubmenu->isNotEmpty());

                $collapseId = 'collapseMenu' . $index;
                $isActive =
                    $hasSubmenu &&
                    $permittedSubmenu->contains(function ($sub) {
                        return request()->routeIs($sub['route'] . '*') ||
                            request()->routeIs($sub['route']) ||
                            (isset($sub['route_pattern']) && request()->routeIs($sub['route_pattern']));
                    });
            @endphp

            @if ($shouldDisplayParent)
                <li class="nav-item">
                    @if ($hasSubmenu)
                        <a class="nav-link d-flex align-items-center position-relative {{ $isActive ? 'active' : 'collapsed' }}"
                            data-bs-toggle="collapse" href="#{{ $collapseId }}" role="button"
                            aria-expanded="{{ $isActive ? 'true' : 'false' }}" aria-controls="{{ $collapseId }}">
                            <i class="{{ $item['icon'] }}"></i>
                            <span class="">{{ $item['title'] }}</span>
                            <i class="fas fa-chevron-down amd-rotate-icon ms-auto"></i>
                        </a>
                        <div class="collapse amd-submenu ps-4 {{ $isActive ? 'show' : '' }}" id="{{ $collapseId }}">
                            @foreach ($permittedSubmenu as $sub)
                                <a href="{{ route($sub['route']) }}"
                                    class="amd-submenu-link {{ request()->routeIs($sub['route'] . '*') || request()->routeIs($sub['route']) || (isset($sub['route_pattern']) && request()->routeIs($sub['route_pattern'])) ? 'active' : '' }}">
                                    {{ $sub['title'] }}
                                </a>
                            @endforeach
                        </div>
                    @else
                        <a href="{{ route($item['route']) }}"
                            class="nav-link d-flex align-items-center {{ request()->routeIs($item['route']) || (isset($item['route_pattern']) && request()->routeIs($item['route_pattern'])) ? 'active' : '' }}">
                            <i class="{{ $item['icon'] }}"></i>
                            <span class="ms-2">{{ $item['title'] }}</span>
                        </a>
                    @endif
                </li>
            @endif
        @endforeach
    @endif
</ul>
