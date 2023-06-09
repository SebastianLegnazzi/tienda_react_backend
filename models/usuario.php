<?php

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

//Lista un usuario por su nombre
Flight::route('GET /usuarios/@nombre', function($nombre){
    $query = Flight::db()->prepare("SELECT * FROM `usuario` WHERE usNombre = ?");
    $query->bindParam(1,$nombre);
    $query->execute();
    $datos = $query->fetchAll();
    Flight::json($datos);
});

//Lista un usuario por su email
Flight::route('GET /usuarios/email/@email', function($email){
    $query = Flight::db()->prepare("SELECT * FROM `usuario` WHERE usMail = ?");
    $query->bindParam(1,$email);
    $query->execute();
    $datos = $query->fetchAll();
    Flight::json($datos);
});

//Carga usuarios a la base de datos
Flight::route('POST /usuarios', function(){
    $nombre = (Flight::request()->data['usNombre']);
    $pass = (Flight::request()->data['usPass']);
    $mail = (Flight::request()->data['usMail']);
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
Flight::route('DELETE /usuarios/@id', function($id){
    $query = Flight::db()->prepare("DELETE FROM usuario WHERE idUsuario=?");
    $query->bindParam(1,$id);
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


?>