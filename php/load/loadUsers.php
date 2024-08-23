<?php

    session_start();
    include "../conexion.php";

    if (empty($_SESSION['id_user']) || $_SESSION['permissions'] != 'admin') {

        $users[]= array(
            "id"=>'0',
            "name"=>'0',
            "user"=>'0',
            "email"=>'0',
            "permissions"=>'0'
        );

    }else {
        
        $queryU = mysqli_query($conexion, "SELECT * FROM users ORDER BY `id_user` DESC ");
        while ($datosU = mysqli_fetch_assoc($queryU)) { 

            $users[]= array(
                "id"=>$datosU["id_user"],
                "name"=>ucwords($datosU["name"]),
                "user"=>ucwords($datosU["user"]),
                "email"=>ucwords($datosU["email"]),
                "permissions"=>$datosU["permissions"]
            );

        } 

    }

    $users_string = json_encode($users);
    echo $users_string; 
    


    
    
      
    
                                    