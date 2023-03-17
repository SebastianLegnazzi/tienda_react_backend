<?php

require 'flight/Flight.php';

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
    
    Flight::json(["resp" => "Usuario cargado exitosamente!"]);
});

//Borrar un usuario
Flight::route('DELETE /usuarios', function(){
    $id = (Flight::request()->data['id']);
    $query = Flight::db()->prepare("DELETE FROM usuario WHERE idUsuario=?");
    $query->bindParam(1,$id);
    $query->execute();
    Flight::json(["resp" => "Usuario borrado exitosamente!"]);
});

//Actualizar un usuario
Flight::route('PUT /usuarios', function(){
    $id = (Flight::request()->data['id']);
    $nombre = (Flight::request()->data['nombre']);
    $pass = (Flight::request()->data['pass']);
    $mail = (Flight::request()->data['mail']);
    $query = Flight::db()->prepare("UPDATE usuario SET usNombre=? , usPass=? , usMail=? WHERE idUsuario=?");
    $query->bindParam(1,$nombre);
    $query->bindParam(2,$pass);
    $query->bindParam(3,$mail);
    $query->bindParam(4,$id);
    $query->execute();
    Flight::json(["resp" => "Usuario borrado exitosamente!"]);
});

/**************************************/
/*********** CLASE PRODUCTO ************/
/**************************************/

//Lista todos los producto
Flight::route('GET /producto', function(){
    $query = Flight::db()->prepare("SELECT * FROM `producto`"); // Armamos consulta SQL
    $query->execute(); // Ejecutamos consulta
    $datos = $query->fetchAll(); // Nos devuelve todo 
    Flight::json($datos); // armamos y devolvemos el JSON al cliente
});

//Lista un usuario
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
    
    Flight::json(["resp" => "Usuario cargado exitosamente!"]);
});

//Borrar un usuario
Flight::route('DELETE /producto', function(){
    $id = (Flight::request()->data['id']);
    $query = Flight::db()->prepare("DELETE FROM producto WHERE idProducto=?");
    $query->bindParam(1,$id);
    $query->execute();
    Flight::json(["resp" => "Usuario borrado exitosamente!"]);
});

//Actualizar un usuario
Flight::route('PUT /producto', function(){
    $id = (Flight::request()->data['id']);
    $detalle = (Flight::request()->data['proDetalle']);
    $cantStock = (Flight::request()->data['proCantStock']);
    $precio = (Flight::request()->data['proPrecio']);
    $urlImg = (Flight::request()->data['urlImagen']);
    $query = Flight::db()->prepare("UPDATE producto SET proDetalle=? , proCantStock=? , proPrecio=?, urlImagen=? WHERE idProducto=?");
    $query->bindParam(1,$detalle); 
    $query->bindParam(2,$cantStock);
    $query->bindParam(3,$precio);
    $query->bindParam(4,$urlImg);
    $query->bindParam(5,$id);
    $query->execute();
    Flight::json(["resp" => "Usuario borrado exitosamente!"]);
});

Flight::start();
