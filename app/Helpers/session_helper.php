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
