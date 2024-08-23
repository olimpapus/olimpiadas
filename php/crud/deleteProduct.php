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
            
            $queryRepetido = mysqli_query($conexion, "SELECT * FROM products WHERE id_product='".$_POST['id']."' ");
            if(mysqli_num_rows($queryRepetido) > 0){
                
                $delete = mysqli_query($conexion, "DELETE FROM products WHERE id_product = '".$_POST['id']."' ");
                
                if ($delete) {
                    
                    $deleteCart = mysqli_query($conexion, "DELETE FROM cart WHERE id_product = '".$_POST['id']."' ");
                    
                    if($deleteCart){
                        
                        $response = array(
                            'success' => true,
                            'message' => '<div class="alert alert-success" role="alert">Producto eliminado con exito.</div>'
                        );
                    
                    }else{
                        
                        $response = array(
                            'success' => false,
                            'message' => '<div class="alert alert-danger" role="alert">ups, error.</div>'
                        );
                        
                    }
                    
                }else {
                    
                    $response = array(
                        'success' => false,
                        'message' => '<div class="alert alert-danger" role="alert">ups, error.</div>'
                    );
                    
                }
                
            }else {
                
                $response = array(
                    'success' => false,
                    'message' => '<div class="alert alert-danger" role="alert">Usuario no existe.</div>'
                );
                
            }
        }
    }

    header('Content-type: application/json');
    echo json_encode($response);















