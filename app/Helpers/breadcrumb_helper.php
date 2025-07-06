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

        $html = '<nav aria-label="breadcrumb" class="bg-light p-lg-3 d-flex align-items-center"><ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"></li>';

        $url = '';
        $last_index = count($segments) - 1;

        foreach ($segments as $index => $segment) {
            $url .= '/' . $segment;
            $name = ucfirst(str_replace(['-', '_'], ' ', $segment));

            if ($index == $last_index) {
                $html .= '<li class="breadcrumb-item active" aria-current="page">' . esc($name) . '</li>';
            } else {
                $html .= '<li class="breadcrumb-item"><a href="' . base_url($url) . '">' . esc($name) . '</a></li>';
            }
        }

        $html .= '</ol></nav>';

        return $html;
    }
}
