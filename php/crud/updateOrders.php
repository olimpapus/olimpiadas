<?php

    session_start();
    include "../conexion.php";

    if (empty($_SESSION['id_user']) || $_SESSION['permissions'] != 'admin') {

        $response = array(
            'success' => false,
            'message' => '<div class="alert alert-danger" role="alert">No tienes los permisos necesarios.</div>'
        );

    }else {

        if (empty($_POST['id'])) {

            $response = array(
                'success' => false,
                'message' => '<div class="alert alert-danger" role="alert">Comprete todos los campos.</div>'
            );

        }else {
        
            $update = mysqli_query($conexion, "UPDATE orders SET status='delivered' WHERE id_order='".$_POST['id']."' ");

            if ($update) {

                $response = array(
                    'success' => true,
                    'message' => '<div class="alert alert-success" role="alert">Orden modificada con exito.</div>'
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















