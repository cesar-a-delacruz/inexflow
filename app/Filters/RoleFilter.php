<?php

namespace App\Filters;

use App\Enums\UserRole;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = service('session');
        $user_id = $session->get('user_id');
        $business_id = $session->get('business_id');
        $user_role = UserRole::from($session->get('user_role'));

        // Si no está logueado, redirigir al login
        if (!$user_id || !$business_id || !$user_role) {
            return redirect()->route('/auth/login');
        }

        // Si se pasó argumento en el filtro (ej: role:admin)
        if ($arguments && count($arguments) > 0) {
            $requiredRole = UserRole::from($arguments[0]);

            // Aquí depende cómo manejes los roles en tu app:
            if ($user_role !== $requiredRole) {
                // Opciones: redirigir a dashboard, mostrar error 403, etc.
                return redirect()->to('/')->with('error', 'No tienes permisos para acceder.');
            }
        }

        // Si pasa las validaciones, sigue con la ejecución
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Generalmente vacío
    }
}
