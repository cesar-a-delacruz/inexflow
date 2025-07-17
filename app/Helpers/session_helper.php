<?php
if (!function_exists('user_logged')) {
    function user_logged() {
        return session()->get('id') !== null;
    }
}
if (!function_exists('is_admin')) {
    function is_admin() {
        return session()->get('role') === 'admin';
    }
}
if (!function_exists('check_user')) {
    function check_user($page_role) {
        if(!session()->get('id')) return '/';
        if (session()->get('role') !== $page_role) return session()->get('current_page');

        return null;
    }
}
