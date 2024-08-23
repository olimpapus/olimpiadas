<?php

    session_start();
    include "../conexion.php";

    if (empty($_SESSION['id_user']) || $_SESSION['permissions'] != 'admin') {

        $response = array(
            'success' => false,
            'message' => '<div class="alert alert-danger" role="alert">No tienes los permisos necesarios.</div>'
        );

    }else {

        if (empty($_POST['id']) || empty($_POST['title']) || empty($_POST['description']) || empty($_POST['category']) || empty($_POST['price']) || empty($_POST['stock'])) {

            $response = array(
                'success' => false,
                'message' => '<div class="alert alert-danger" role="alert">Comprete todos los campos.</div>'
            );

        }else {
        
            $insert = mysqli_query($conexion, "UPDATE products SET title='".$_POST['title']."', description='".$_POST['description']."', category='".$_POST['category']."', price='".$_POST['price']."', stock='".$_POST['stock']."' WHERE id_product='".$_POST['id']."' ");

            if ($insert) {

                $response = array(
                    'success' => true,
                    'message' => '<div class="alert alert-success" role="alert">Producto modificado con exito.</div>'
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















