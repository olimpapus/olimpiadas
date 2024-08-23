<?php

    session_start();
    include "conexion.php";

    if (empty($_SESSION['id_user'])) {

        $user[]= array(
            "id"=>'0',
            "name"=>'0',
            "user"=>'0',
            "email"=>'0',
            "permissions"=>'0'
        );

    }else {
        
        $queryU = mysqli_query($conexion, "SELECT * FROM users WHERE id_user='".$_SESSION['id_user']."' ");
        while ($datosU = mysqli_fetch_assoc($queryU)) { 

            $user[]= array(
                "id"=>$datosU["id_user"],
                "name"=>ucwords($datosU["name"]),
                "user"=>ucwords($datosU['user']),
                "email"=>$datosU['email'],
                "permissions"=>$datosU['permissions']
            );

        } 
    }

    $user_string = json_encode($user);
    echo $user_string; 
    


    
    
      
    
                                    