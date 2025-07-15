<?php
if (!function_exists('check_user')) {
    function check_user($page_role) {
        if(!session()->get('id')) return '/';
        if (session()->get('role') !== $page_role) return session()->get('current_page');

        return null;
    }
}
