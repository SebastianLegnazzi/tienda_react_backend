<?php

require 'flight/Flight.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}


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
/*********** CLASE USUARIO ************/
/**************************************/

//Lista todos los usuarios
Flight::route('GET /usuarios', function(){
    $query = Flight::db()->prepare("SELECT * FROM `usuario`"); // Armamos consulta SQL
    $query->execute(); // Ejecutamos consulta
    $datos = $query->fetchAll(); // Nos devuelve todo 
    Flight::json($datos); // armamos y devolvemos el JSON al cliente
});

//Lista un usuario
Flight::route('GET /usuarios/@id', function($id){
    $query = Flight::db()->prepare("SELECT * FROM `usuario` WHERE idUsuario = ?");
    $query->bindParam(1,$id);
    $query->execute();
    $datos = $query->fetchAll();
    Flight::json($datos);
});


//Carga usuarios a la base de datos
Flight::route('POST /usuarios', function(){
    $nombre = (Flight::request()->data['nombre']);
    $pass = (Flight::request()->data['pass']);
    $mail = (Flight::request()->data['mail']);
    //Asignamos el parametro en el cual pusimos "?" (mientras mas hayan se ponen en orden de derecha a izquierda incrementando el numero)
    //                                                                                  1  2  3
    $query = Flight::db()->prepare("INSERT INTO usuario (usNombre,usPass,usMail) VALUES(?, ?, ?)");
    $query->bindParam(1,$nombre); 
    $query->bindParam(2,$pass);
    $query->bindParam(3,$mail);
    $query->execute();
    
    Flight::json(["resp" => 1]);  //Devolvemos "1" en caso de que haya sido sactifactorio el resultado
});

//Borrar un usuario
Flight::route('DELETE /usuarios', function(){
    $idUsuario = (Flight::request()->data['idUsuario']);
    $query = Flight::db()->prepare("DELETE FROM usuario WHERE idUsuario=?");
    $query->bindParam(1,$idUsuario);
    $query->execute();
    Flight::json(["resp" => 1]);
});

//Actualizar un usuario
Flight::route('PUT /usuarios', function(){
    $idUsuario = (Flight::request()->data['idUsuario']);
    $nombre = (Flight::request()->data['nombre']);
    $pass = (Flight::request()->data['pass']);
    $mail = (Flight::request()->data['mail']);
    $query = Flight::db()->prepare("UPDATE usuario SET usNombre=? , usPass=? , usMail=? WHERE idUsuario=?");
    $query->bindParam(1,$nombre);
    $query->bindParam(2,$pass);
    $query->bindParam(3,$mail);
    $query->bindParam(4,$idUsuario);
    $query->execute();
    Flight::json(["resp" => 1]);
});


/**************************************/
/*********** CLASE USUARIOROL *********/
/**************************************/

//Lista todos los usuariorol
Flight::route('GET /usuariorol', function(){
    $query = Flight::db()->prepare("SELECT * FROM `usuariorol`"); // Armamos consulta SQL
    $query->execute(); // Ejecutamos consulta
    $datos = $query->fetchAll(); // Nos devuelve todo 
    Flight::json($datos); // armamos y devolvemos el JSON al cliente
});

//Lista un usuariorol
Flight::route('GET /usuariorol/@id', function($id){
    $query = Flight::db()->prepare("SELECT * FROM `usuariorol` WHERE idUsuario = ?");
    $query->bindParam(1, $id);
    $query->execute();
    $datos = $query->fetchAll();
    Flight::json($datos);
});


//Carga usuariorol a la base de datos
Flight::route('POST /usuariorol', function(){
    $idUsuario = (Flight::request()->data['idUsuario']);
    $idRol = (Flight::request()->data['idRol']);
    $query = Flight::db()->prepare("INSERT INTO usuariorol (idUsuario,idRol) VALUES(?, ?)");
    $query->bindParam(1,$idUsuario); 
    $query->bindParam(2,$idRol);
    $query->execute();
    
    Flight::json(["resp" => 1]);  //Devolvemos "1" en caso de que haya sido sactifactorio el resultado
});

//Borrar un usuariorol
Flight::route('DELETE /usuariorol', function(){
    $idUsuario = (Flight::request()->data['idUsuario']);
    $idRol = (Flight::request()->data['idRol']);
    $query = Flight::db()->prepare("DELETE FROM usuariorol WHERE idUsuario = ? AND idRol = ?");
    $query->bindParam(1,$idUsuario);
    $query->bindParam(2,$idRol);
    $query->execute();
    Flight::json(["resp" => 1]);
});

//Actualizar un usuariorol
Flight::route('PUT /usuariorol', function(){
    $idUsuario = (Flight::request()->data['idUsuario']);
    $idRol = (Flight::request()->data['idRol']);
    $idUsuarioNuevo = (Flight::request()->data['idUsuarioNuevo']);
    $idRolNuevo = (Flight::request()->data['idRolNuevo']);
    $query = Flight::db()->prepare("UPDATE usuariorol SET idUsuario = ? , idRol = ? WHERE idusuariorol = ? AND idRol = ?");
    $query->bindParam(1,$idUsuarioNuevo);
    $query->bindParam(2,$idRolNuevo);
    $query->bindParam(3,$idUsuario);
    $query->bindParam(4,$idRol);
    $query->execute();
    Flight::json(["resp" => 1]);
});

/***************************************/
/*********** CLASE PRODUCTO ************/
/***************************************/

//Lista todos los producto
Flight::route('GET /producto', function(){
    $query = Flight::db()->prepare("SELECT * FROM `producto`"); // Armamos consulta SQL
    $query->execute(); // Ejecutamos consulta
    $datos = $query->fetchAll(); // Nos devuelve todo 
    Flight::json($datos); // armamos y devolvemos el JSON al cliente
});

//Lista un producto
Flight::route('GET /producto/@id', function($id){
    $query = Flight::db()->prepare("SELECT * FROM `producto` WHERE idProducto = ?");
    $query->bindParam(1,$id);
    $query->execute();
    $datos = $query->fetchAll();
    Flight::json($datos);
});


//Carga producto a la base de datos
Flight::route('POST /producto', function(){
    $detalle = (Flight::request()->data['proDetalle']);
    $cantStock = (Flight::request()->data['proCantStock']);
    $precio = (Flight::request()->data['proPrecio']);
    $urlImg = (Flight::request()->data['urlImagen']);
    //Asignamos el parametro en el cual pusimos "?" (mientras mas hayan se ponen en orden de derecha a izquierda incrementando el numero)
    //                                                                                  1  2  3
    $query = Flight::db()->prepare("INSERT INTO producto (proDetalle,proCantStock,proPrecio,urlImagen) VALUES(?, ?, ?, ?)");
    $query->bindParam(1,$detalle); 
    $query->bindParam(2,$cantStock);
    $query->bindParam(3,$precio);
    $query->bindParam(4,$urlImg);
    $query->execute();
    
    Flight::json(["resp" => 1]);
});

//Borrar un producto
Flight::route('DELETE /producto', function(){
    $idProducto = (Flight::request()->data['idProducto']);
    $query = Flight::db()->prepare("DELETE FROM producto WHERE idProducto=?");
    $query->bindParam(1,$idProducto);
    $query->execute();
    Flight::json(["resp" => 1]);
});

//Actualizar un producto
Flight::route('PUT /producto', function(){
    $idProducto = (Flight::request()->data['idProducto']);
    $detalle = (Flight::request()->data['proDetalle']);
    $cantStock = (Flight::request()->data['proCantStock']);
    $precio = (Flight::request()->data['proPrecio']);
    $urlImg = (Flight::request()->data['urlImagen']);
    $query = Flight::db()->prepare("UPDATE producto SET proDetalle=? , proCantStock=? , proPrecio=?, urlImagen=? WHERE idProducto=?");
    $query->bindParam(1,$detalle); 
    $query->bindParam(2,$cantStock);
    $query->bindParam(3,$precio);
    $query->bindParam(4,$urlImg);
    $query->bindParam(5,$idProducto);
    $query->execute();
    Flight::json(["resp" => 1]);
});


/***************************************/
/************ CLASE COMPRA ************/
/***************************************/

//Lista todos los compra
Flight::route('GET /compra', function(){
    $query = Flight::db()->prepare("SELECT * FROM `compra`"); // Armamos consulta SQL
    $query->execute(); // Ejecutamos consulta
    $datos = $query->fetchAll(); // Nos devuelve todo 
    Flight::json($datos); // armamos y devolvemos el JSON al cliente
});

//Lista una compra
Flight::route('GET /compra/@id', function($id){
    $query = Flight::db()->prepare("SELECT * FROM `compra` WHERE idCompra = ?");
    $query->bindParam(1,$id);
    $query->execute();
    $datos = $query->fetchAll();
    Flight::json($datos);
});


//Carga una compra a la base de datos
Flight::route('POST /compra', function(){
    $fecha = (Flight::request()->data['coFecha']);
    $idUsuario = (Flight::request()->data['idUsuario']);
    //Asignamos el parametro en el cual pusimos "?" (mientras mas hayan se ponen en orden de derecha a izquierda incrementando el numero)
    //                                                                                  1  2  3
    $query = Flight::db()->prepare("INSERT INTO compra (coFecha,idUsuario) VALUES(?, ?)");
    $query->bindParam(1,$fecha); 
    $query->bindParam(2,$idUsuario);
    $query->execute();
    
    Flight::json(["resp" => 1]);
});

//Borrar una compra
Flight::route('DELETE /compra', function(){
    $idCompra = (Flight::request()->data['idCompra']);
    $query = Flight::db()->prepare("DELETE FROM compra WHERE idCompra=?");
    $query->bindParam(1,$idCompra);
    $query->execute();
    Flight::json(["resp" => 1]);
});

//Actualizar una compra
Flight::route('PUT /compra', function(){
    $idCompra = (Flight::request()->data['idCompra']);
    $fecha = (Flight::request()->data['coFecha']);
    $idUsuario = (Flight::request()->data['idUsuario']);
    $query = Flight::db()->prepare("UPDATE compra SET coFecha=? , idUsuario=? WHERE idCompra=?");
    $query->bindParam(1,$fecha); 
    $query->bindParam(2,$idUsuario);
    $query->bindParam(3,$idCompra);
    $query->execute();
    Flight::json(["resp" => 1]);
});


/********************************************/
/************ CLASE COMPRAESTADO ************/
/********************************************/

//Lista todos los compraestado
Flight::route('GET /compraestado', function(){
    $query = Flight::db()->prepare("SELECT * FROM `compraestado`"); // Armamos consulta SQL
    $query->execute(); // Ejecutamos consulta
    $datos = $query->fetchAll(); // Nos devuelve todo 
    Flight::json($datos); // armamos y devolvemos el JSON al cliente
});

//Lista una compraestado
Flight::route('GET /compraestado/@id', function($id){
    $query = Flight::db()->prepare("SELECT * FROM `compraestado` WHERE idCompraestado = ?");
    $query->bindParam(1,$id);
    $query->execute();
    $datos = $query->fetchAll();
    Flight::json($datos);
});


//Carga una compraestado a la base de datos
Flight::route('POST /compraestado', function(){
    $idCompra = (Flight::request()->data['idCompra']);
    $idCompraEstadoTipo = (Flight::request()->data['idCompraEstadoTipo']);
    //Asignamos el parametro en el cual pusimos "?" (mientras mas hayan se ponen en orden de derecha a izquierda incrementando el numero)
    //                                                                                  1  2  3
    $query = Flight::db()->prepare("INSERT INTO compraestado (idCompra,idCompraEstadoTipo) VALUES(?, ?)");
    $query->bindParam(1,$idCompra); 
    $query->bindParam(2,$idCompraEstadoTipo);
    $query->execute();
    
    Flight::json(["resp" => 1]);
});

//Borrar una compraestado
Flight::route('DELETE /compraestado', function(){
    $idCompraestado = (Flight::request()->data['idCompraestado']);
    $query = Flight::db()->prepare("DELETE FROM compraestado WHERE idCompraestado=?");
    $query->bindParam(1,$idCompraestado);
    $query->execute();
    Flight::json(["resp" => 1]);
});

//Actualizar una compraestado
Flight::route('PUT /compraestado', function(){
    $idCompraestado = (Flight::request()->data['idCompraestado']);
    $idCompra = (Flight::request()->data['idCompra']);
    $idCompraEstadoTipo = (Flight::request()->data['idCompraEstadoTipo']);
    $coFechaIni = (Flight::request()->data['coFechaIni']);
    $coFechaFin = (Flight::request()->data['coFechaFin']);
    $query = Flight::db()->prepare("UPDATE compraestado SET idCompra=? , idCompraEstadoTipo=?, coFechaIni=?, coFechaFin=?  WHERE idCompraestado=?");
    $query->bindParam(1,$idCompra); 
    $query->bindParam(2,$idCompraEstadoTipo);
    $query->bindParam(3,$coFechaIni);
    $query->bindParam(4,$coFechaFin);
    $query->bindParam(5,$idCompraestado);
    $query->execute();
    Flight::json(["resp" => 1]);
});

/******************************************/
/************ CLASE COMPRAITEM ************/
/******************************************/

//Lista todos los compraitem
Flight::route('GET /compraitem', function(){
    $query = Flight::db()->prepare("SELECT * FROM `compraitem`"); // Armamos consulta SQL
    $query->execute(); // Ejecutamos consulta
    $datos = $query->fetchAll(); // Nos devuelve todo 
    Flight::json($datos); // armamos y devolvemos el JSON al cliente
});

//Lista una compraitem
Flight::route('GET /compraitem/@id', function($id){
    $query = Flight::db()->prepare("SELECT * FROM `compraitem` WHERE idCompraitem = ?");
    $query->bindParam(1,$id);
    $query->execute();
    $datos = $query->fetchAll();
    Flight::json($datos);
});


//Carga una compraitem a la base de datos
Flight::route('POST /compraitem', function(){
    $idProducto = (Flight::request()->data['idProducto']);
    $idCompra = (Flight::request()->data['idCompra']);
    $cant = (Flight::request()->data['ciCantidad']);
    //Asignamos el parametro en el cual pusimos "?" (mientras mas hayan se ponen en orden de derecha a izquierda incrementando el numero)
    //                                                                                  1  2  3
    $query = Flight::db()->prepare("INSERT INTO compraitem (idProducto,idCompra,cant) VALUES(?, ?, ?)");
    $query->bindParam(1,$idProducto); 
    $query->bindParam(2,$idCompra);
    $query->bindParam(3,$cant);
    $query->execute();
    
    Flight::json(["resp" => 1]);
});

//Borrar una compraitem
Flight::route('DELETE /compraitem', function(){
    $idCompraitem = (Flight::request()->data['idCompraitem']);
    $query = Flight::db()->prepare("DELETE FROM compraitem WHERE idCompraitem=?");
    $query->bindParam(1,$idCompraitem);
    $query->execute();
    Flight::json(["resp" => 1]);
});

//Actualizar una compraitem
Flight::route('PUT /compraitem', function(){
    $idCompraitem = (Flight::request()->data['idCompraitem']);
    $idProducto = (Flight::request()->data['idProducto']);
    $idCompra = (Flight::request()->data['idCompra']);
    $cant = (Flight::request()->data['ciCantidad']);
    $query = Flight::db()->prepare("UPDATE compraitem SET idProducto=? , idProducto=?, cant=?  WHERE idCompraitem=?");
    $query->bindParam(1,$idProducto); 
    $query->bindParam(2,$idCompra);
    $query->bindParam(3,$cant);
    $query->bindParam(4,$idCompraitem);
    $query->execute();
    Flight::json(["resp" => 1]);
});


Flight::start();
