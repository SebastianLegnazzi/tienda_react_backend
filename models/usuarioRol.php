<?php

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
Flight::route('DELETE /usuariorol/@idUsuario/@idRol', function($idUsuario, $idRol){
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

?>
