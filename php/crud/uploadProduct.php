<?php

    session_start();
    include "../conexion.php";

    if (empty($_SESSION['id_user']) || $_SESSION['permissions'] != 'admin') {

        $response = array(
            'success' => false,
            'message' => '<div class="alert alert-danger" role="alert">No tienes los permisos necesarios.</div>'
        );

    }else {

        if (empty($_POST['title']) || empty($_POST['description']) || empty($_POST['category']) || empty($_POST['price']) || empty($_POST['stock'])) {

            $response = array(
                'success' => false,
                'message' => '<div class="alert alert-danger" role="alert">Comprete todos los campos.</div>'
            );

        }else {
             
            $insert = mysqli_query($conexion, "INSERT INTO products (title, description, category, price, stock) VALUES ('".$_POST['title']."', '".$_POST['description']."', '".$_POST['category']."', '".$_POST['price']."', '".$_POST['stock']."')");

            if ($insert) {

                $response = array(
                    'success' => true,
                    'message' => '<div class="alert alert-success" role="alert">Producto subido con exito.</div>'
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















