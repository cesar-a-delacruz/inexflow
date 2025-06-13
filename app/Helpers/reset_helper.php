<?php
// funcion si existe o no
 if (!function_exists('validar_contraseña')) {
    function validar_contraseña($password)
   {
        $errores = [];

        if (strlen($password) < 8) {
            $errores[] = "Debe tener al menos 8 caracteres.";
        }
        if (!preg_match('/[A-Z]/', $password)) {
            $errores[] = "Debe contener al menos una letra mayúscula.";
        }
        if (!preg_match('/[a-z]/', $password)) {
            $errores[] = "Debe contener al menos una letra minúscula.";
        }
        if (!preg_match('/[0-9]/', $password)) {
            $errores[] = "Debe contener al menos un número.";
        }
        if (!preg_match('/[\W_]/', $password)) {
            $errores[] = "Debe contener al menos un carácter especial.";
        }

        return $errores;
      }
 }
 // funcion para validar email

 if (!function_exists('validar_email')) {
    function validar_email($email)
    {
        $errores = [];

        if (empty(trim($email))) {
            $errores[] = "El campo email es obligatorio.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "El email no es válido.";
        }

        return $errores;
    }
}
