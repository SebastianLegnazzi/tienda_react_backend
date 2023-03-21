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


?>