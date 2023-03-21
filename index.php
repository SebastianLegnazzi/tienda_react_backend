<?php

// NO TOCAR NECESARIO PARA QUE NO DEVUELVA ERROR LA CONSULTA HTTP
require 'flight/Flight.php';
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}
/*****************************************************************/

// Mensaje cuando no se ingresa ningun clase
Flight::route('/', function () {
    echo 'Debes seleccionar una clase para empezar a trabjar!';
});

/**************************************/
/************* CONFIG BD **************/
/**************************************/
$host = "localhost";
$bd = "carrito_compras";
$user = "root";
$pass = "";

// Conectamos a la Base de Datos
Flight::register('db', 'PDO', array('mysql:host='.$host.';dbname='.$bd.'',$user,$pass));

/**************************************/
/*********** MODELOS DE BD ************/
/**************************************/
include_once('./models/usuario.php');
include_once('./models/usuarioRol.php');
include_once('./models/producto.php');
include_once('./models/compra.php');
include_once('./models/compraEstado.php');
include_once('./models/compraItem.php');


Flight::start();
