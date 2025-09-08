<?php
if (!function_exists('user_logged')) {
    /** Verifica si el usuario inició sesión */
    function user_logged()
    {
        return session()->get('id') !== null;
    }
}
if (!function_exists('check_user')) {
    /** Verifica si el usuario inició sesión y si su rol corresponde a la vista */
    function check_user(string $page_role)
    {
        if (!session()->get('id')) return '/';
        if (session()->get('role') !== $page_role) return session()->get('current_page');
        return null;
    }
}
if (!function_exists('guard_business')) {
    function guard_business(string $page)
    {
        if (!session()->get('business_id')) return redirect()->to('business/new');
        $redirect = check_user('businessman');
        if ($redirect !== null) return redirect()->to($redirect);
        else session()->set('current_page', $page);
    }
}
