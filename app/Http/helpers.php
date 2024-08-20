<?php
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

