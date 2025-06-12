<?php

if (!function_exists('render_dynamic_breadcrumb')) {
    function render_dynamic_breadcrumb()
    {
        // Obtener segmentos desde el servicio URI
        $segments = service('uri')->getSegments();

        $base = base_url();

        if (empty($segments)) {
            return '<nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item active" aria-current="page">Inicio</li></ol></nav>';
        }

        $html = '<nav aria-label="breadcrumb"><ol class="breadcrumb">';
        $html .= '<li class="breadcrumb-item"><a href="' . $base . '">Inicio</a></li>';

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
