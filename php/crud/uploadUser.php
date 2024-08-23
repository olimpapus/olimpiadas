<?php

    session_start();
    include "../conexion.php";

    if (empty($_SESSION['id_user']) || $_SESSION['permissions'] != 'admin') {

        $response = array(
            'success' => false,
            'message' => '<div class="alert alert-danger" role="alert">No tienes los permisos necesarios.</div>'
        );

    }else {

        if (empty($_POST['name']) || empty($_POST['user']) || empty($_POST['email']) || empty($_POST['permissions'])) {

            $response = array(
                'success' => false,
                'message' => '<div class="alert alert-danger" role="alert">Comprete todos los campos.</div>'
            );

        }else {
             
            $insert = mysqli_query($conexion, "INSERT INTO users (name, user, email, permissions) VALUES ('".$_POST['name']."', '".$_POST['user']."', '".$_POST['email']."', '".$_POST['permissions']."')");

            if ($insert) {

                $response = array(
                    'success' => true,
                    'message' => '<div class="alert alert-success" role="alert">Usuario subido con exito.</div>'
                );

            }else {

                $response = array(
                    'success' => false,
                    'message' => '<div class="alert alert-danger" role="alert">ups, error.</div>'
                );
                
            }
                
        }
        
    }

    header('Content-type: application/json');
    echo json_encode($response);















