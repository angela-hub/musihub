<?php 
// directorio raiz
if ( !defined('ROOT_PATH') )
    define('ROOT_PATH', dirname(__FILE__)."/");

// directorio de modelos 
if ( !defined('MODEL_PATH') )
    define('MODEL_PATH', ROOT_PATH."modelos/");

// directorio de administracion
if ( !defined('VIEW_PATH') )
    define('VIEW_PATH', ROOT_PATH."admin/");

// directorio de controlodares
if ( !defined('CONTROLLER_PATH') )
    define('CONTROLLER_PATH', ROOT_PATH."controladores/");

// directorio de utilidades
if ( !defined('UTILITY_PATH') )
    define('UTILITY_PATH', ROOT_PATH."utilidades/");

// directorio de imagenes
if ( !defined('IMAGE_PATH') )
    define('IMAGE_PATH', ROOT_PATH."imagenes/");
    
//directorio de PDF para la descarga del mismo
    if ( !defined('VENDOR_PATH') )
    define('VENDOR_PATH', ROOT_PATH."vendor/");
?>