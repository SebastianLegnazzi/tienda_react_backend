<?php

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

//Lista una compra por su id
Flight::route('GET /compra/@id', function($id){
    $query = Flight::db()->prepare("SELECT * FROM `compra` WHERE idCompra = ?");
    $query->bindParam(1,$id);
    $query->execute();
    $datos = $query->fetchAll();
    Flight::json($datos);
});

//Lista una compra por su usuario
Flight::route('GET /compra/usuario/@id', function($id){
    $query = Flight::db()->prepare("SELECT * FROM `compra` WHERE idUsuario = ?");
    $query->bindParam(1,$id);
    $query->execute();
    $datos = $query->fetchAll();
    Flight::json($datos);
});


//Carga una compra a la base de datos
Flight::route('POST /compra', function(){
    $idUsuario = (Flight::request()->data['idUsuario']);
    $query = Flight::db()->prepare("INSERT INTO compra (idUsuario) VALUES(?)");
    $query->bindParam(1,$idUsuario);
    $query->execute();
    $query = Flight::db()->prepare("SELECT * FROM `compra` WHERE idUsuario = ? ORDER BY idUsuario DESC");
    $query->bindParam(1,$idUsuario);
    $query->execute();
    $datos = $query->fetchAll();
    $idUltimaCompra = end($datos)["idCompra"];
    Flight::json(["resp" => $idUltimaCompra]);
});

//Borrar una compra
Flight::route('DELETE /compra/@id', function($id){
    $query = Flight::db()->prepare("DELETE FROM compra WHERE idCompra=?");
    $query->bindParam(1,$id);
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


?>