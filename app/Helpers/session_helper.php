<?php
if (!function_exists('user_logged')) {
    /** Verifica si el usuario inició sesión */
    function user_logged() {
        return session()->get('id') !== null;
    }
}
if (!function_exists('check_user')) {
    /** Verifica si el usuario inició sesión y si su rol corresponde a la vista */
    function check_user(string $page_role) {
        if(!session()->get('id')) return '/';
        if (session()->get('role') !== $page_role) return session()->get('current_page');

        return null;
    }
}
