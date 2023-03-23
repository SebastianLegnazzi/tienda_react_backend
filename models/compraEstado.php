<?php

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

//Lista una compra
Flight::route('GET /compraestado/compra/@id', function($id){
    $query = Flight::db()->prepare("SELECT * FROM `compraestado` WHERE idCompra = ?");
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
Flight::route('DELETE /compraestado/@id', function($id){
    $query = Flight::db()->prepare("DELETE FROM compraestado WHERE idCompraestado=?");
    $query->bindParam(1,$id);
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


?>