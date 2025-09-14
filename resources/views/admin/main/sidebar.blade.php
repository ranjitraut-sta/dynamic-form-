<div id="amdSidebar" class="amd-sidebar expanded shadow-sm">
    <div class="close-btn d-md-none text-end px-3 pt-3">
        <i class="fas fa-times fa-lg" id="closeSidebar" style="cursor: pointer; color: var(--light-text);"></i>
    </div>
    <div class="amd-logo ">
        <a href="{{ route('adminLayout') }}">
            <img src="https://amdsoft.com.np/wp-content/uploads/2024/10/amd-jpg-01.jpg" alt=""
                style="height: 40px; width: auto; object-fit: contain; ">
        </a>
    </div>
    <hr>

    {{-- Sidebar Menu Appended From A Components --}}
    @php
        $menuItems = [
            [
                'title' => 'Dashboard',
                'icon' => 'fas fa-home amd-icon-color4',
                'route' => 'adminLayout',
                'permission' => ['controller' => 'DashboardManagementController', 'method' => 'adminLayout'],
            ],
            [
                'title' => 'User Manage',
                'icon' => 'fas fa-user amd-icon-color6',
                'iconColor' => 'icon-color-7',
                'submenu' => [
                    [
                        'title' => 'Role',
                        'route' => 'role.index',
                        'route_pattern' => 'role.*',
                        'permission' => ['controller' => 'RoleController', 'method' => 'index'],
                    ],
                    [
                        'title' => 'Permission',
                        'route' => 'permission.index',
                        'route_pattern' => 'permission.*',
                        'permission' => ['controller' => 'PermissionController', 'method' => 'index'],
                    ],
                    [
                        'title' => 'Users',
                        'route' => 'user.index',
                        'route_pattern' => 'user.*',
                        'permission' => ['controller' => 'UserController', 'method' => 'index'],
                    ],
                ],
            ],
        ];
    @endphp

    <x-ui.sidebar-menu :items="$menuItems" />

</div>
