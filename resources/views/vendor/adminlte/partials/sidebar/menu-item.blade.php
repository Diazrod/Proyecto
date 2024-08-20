@inject('sidebarItemHelper', 'JeroenNoten\LaravelAdminLte\Helpers\SidebarItemHelper')

@php
    if (!function_exists('userCanAccess')) {
        function userCanAccess($item) {
            $permisos = session('user_permisos', []);
            $module_id = $item['module_id'] ?? null;

            if ($module_id) {
                return collect($permisos)
                    ->where('COD_OBJETO', $module_id)
                    ->where('IND_MODULO', '1')
                    ->isNotEmpty();
            }

            return true;
        }
    }
@endphp

@if (userCanAccess($item))

    @if ($sidebarItemHelper->isHeader($item))
        {{-- Header --}}
        @include('adminlte::partials.sidebar.menu-item-header')

    @elseif ($sidebarItemHelper->isLegacySearch($item) || $sidebarItemHelper->isCustomSearch($item))
        {{-- Search form --}}
        @include('adminlte::partials.sidebar.menu-item-search-form')

    @elseif ($sidebarItemHelper->isMenuSearch($item))
        {{-- Search menu --}}
        @include('adminlte::partials.sidebar.menu-item-search-menu')

    @elseif ($sidebarItemHelper->isSubmenu($item))
        {{-- Treeview menu --}}
        @include('adminlte::partials.sidebar.menu-item-treeview-menu')

    @elseif ($sidebarItemHelper->isLink($item))
        {{-- Link --}}
        @include('adminlte::partials.sidebar.menu-item-link')

    @endif

@endif
