<?php

    include 'conexion.php';
 
    if (empty($_POST["name"]) || empty($_POST["user"]) || empty($_POST["email"]) || empty($_POST["password"])){

        $response = array(
            'success' => false,
            'message' => '<div class="alert alert-danger" role="alert">Comprete todos los campos.</div>'
        );

    }else {
        if (strlen($_POST["password"]) > '7') {

            $queryRepetida = mysqli_query($conexion, "SELECT * FROM users WHERE email='".$_POST["email"]."' ");

            if(mysqli_num_rows($queryRepetida) > 0){

                $response = array(
                    'success' => false,
                    'message' => '<div class="alert alert-danger" role="alert">Este email ya esta en uso.</div>'
                );
                
            }else {

                $passwordHash = password_hash($_POST["password"], PASSWORD_DEFAULT);
                $insert = mysqli_query($conexion, "INSERT INTO users (name, user, email, password, permissions) VALUES ('".$_POST['name']."', '".$_POST['user']."', '".$_POST['email']."', '".$passwordHash."', 'user')");
    
                if ($insert) {
                    $id_user = mysqli_insert_id($conexion);
                    session_start();
                    $_SESSION['id_user'] = $id_user;
                    $_SESSION['permissions'] = 'user';
                    
                    $response = array(
                        'success' => true
                    );
                    
                }else {

                    $response = array(
                        'success' => false,
                        'message' => '<div class="alert alert-danger" role="alert">Ups. error.</div>'
                    );
                    
                }	
                

            }
            
            
        }else{

            $response = array(
                'success' => false,
                'message' => '<div class="alert alert-danger" role="alert">Contraseña muy corta.</div>'
            );
            
        }
            
    } 

    header('Content-type: application/json');
    echo json_encode($response); 
?>