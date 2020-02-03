<?php
function alerta($texto) {
    echo '<script type="text/javascript">alert("' . $texto . '")</script>';
}

function filtrado($datos) {
    $datos = trim($datos); 
    $datos = stripslashes($datos);
    $datos = htmlspecialchars($datos);
    return $datos;
}

function encode($str){
    return urlencode(base64_encode($str));
}
function decode($str){
    return base64_decode(urldecode($str));
}
function startsWith ($string, $startString){ 
    $len = strlen($startString); 
    return (substr($string, 0, $len) === $startString); 
} 
