<?php

    session_start();
    include "../conexion.php";

    if (empty($_SESSION['id_user']) ) {

        $response = array(
            'success' => false,
            'message' => '<div class="alert alert-danger" role="alert">Debes <a href="login">Iniciar session</a> para agregar al carrito.</div>'
        );

    }else {

        if (empty($_POST['cant']) || empty($_POST['id'])) {

            $response = array(
                'success' => false,
                'message' => '<div class="alert alert-danger" role="alert">Comprete todos los campos.</div>'
            );

        }else {
             for ($i=0; $i < $_POST['cant']; $i++) { 
        
                $delete = mysqli_query($conexion, "DELETE FROM cart WHERE id_product='".$_POST['id']."' AND id_user='".$_SESSION['id_user']."' LIMIT 1 ");
            }

            if ($delete) {

                $response = array(
                    'success' => true,
                    'message' => '<div class="alert alert-success" role="alert">Eliminado del carrito.</div>'
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















