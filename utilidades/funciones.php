<?php
// funcion de alerta el javascript
function alerta($texto) {
    echo '<script type="text/javascript">alert("' . $texto . '")</script>';
}
// funcion para el filtrado de datos 
function filtrado($datos) {
    $datos = trim($datos); 
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}
//funcion de codificacion en base 64
function encode($str){
    return urlencode(base64_encode($str));
}
// funcion de decodificacion en base 64
function decode($str){
    return base64_decode(urldecode($str));
}
//Creamos la funcion para coger una cadena y ver si empieza por lo que se le pasa en el primer parametro
function startsWith ($string, $startString){ 
    $len = strlen($startString); 
    return (substr($string, 0, $len) === $startString); 
} 
