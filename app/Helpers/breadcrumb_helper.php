<?php

if (!function_exists('render_breadcrumb')) {
    /**
     * Renderiza un Bread Crumb. Muestra el directorio actual del sitio web con
     * etiquetas HTML.
     */
    function render_breadcrumb()
    {
        // Obtener segmentos desde el servicio URI
        $segments = service('uri')->getSegments();

        $html = '<search><nav aria-label="breadcrumb" class="text-dark rounded-1 p-lg-3 d-flex align-items-center"><ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"></li>';

        $url = '';
        $last_index = count($segments) - 1;

        $normalice = [
            'item' => 'Elemento',
            'items' => 'Elementos',
            'new' => 'Nuevo',
            'contacts' => 'Contactos',
            'transactions' => 'Transacciones',
            'business' => 'Negocio',
            'dashboard' => 'Dashboard',
            'user' => 'Usuario'
        ];

        foreach ($segments as $index => $segment) {
            $url .= '/' . $segment;
            $name = ($normalice[$segment] ?? esc($segment));

            if ($index == $last_index) {
                $html .= '<li class="breadcrumb-item active" aria-current="page">' . $name . '</li>';
            } else {
                $html .= '<li class="breadcrumb-item"><a href="' . base_url($url) . '">' . $name . '</a></li>';
            }
        }

        $html .= '</ol></nav></search>';

        return $html;
    }
}
