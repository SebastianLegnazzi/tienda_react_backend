<?php

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

//Lista una compra
Flight::route('GET /compraitem/compra/@id', function($id){
    $query = Flight::db()->prepare("SELECT * FROM `compraitem` WHERE idCompra = ?");
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
    $query = Flight::db()->prepare("INSERT INTO compraitem (idProducto,idCompra,ciCantidad) VALUES(?, ?, ?)");
    $query->bindParam(1,$idProducto); 
    $query->bindParam(2,$idCompra);
    $query->bindParam(3,$cant);
    $query->execute();
    
    Flight::json(["resp" => 1]);
});

//Borrar una compraitem
Flight::route('DELETE /compraitem/@id', function($id){
    $query = Flight::db()->prepare("DELETE FROM compraitem WHERE idCompraitem=?");
    $query->bindParam(1,$id);
    $query->execute();
    Flight::json(["resp" => 1]);
});

//Actualizar una compraitem
Flight::route('PUT /compraitem', function(){
    $idCompraItem = (Flight::request()->data['idCompraItem']);
    $idProducto = (Flight::request()->data['idProducto']);
    $idCompra = (Flight::request()->data['idCompra']);
    $cant = (Flight::request()->data['ciCantidad']);
    $query = Flight::db()->prepare("UPDATE compraitem SET idProducto=?, idCompra=?, ciCantidad=?  WHERE idCompraItem=?");
    $query->bindParam(1,$idProducto); 
    $query->bindParam(2,$idCompra);
    $query->bindParam(3,$cant);
    $query->bindParam(4,$idCompraItem);
    $query->execute();
    Flight::json(["resp" => 1]);
});


?>