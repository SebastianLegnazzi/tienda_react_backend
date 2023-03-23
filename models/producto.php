<?php

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
Flight::route('DELETE /producto/@id', function($id){
    $query = Flight::db()->prepare("DELETE FROM producto WHERE idProducto=?");
    $query->bindParam(1,$id);
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

?>