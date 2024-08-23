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

            $stockProduct = mysqli_query($conexion, "SELECT * FROM products WHERE id_product='".$_POST['id']."' ");
            $stockRow = $stockProduct->fetch_assoc();

            $cantProducts = mysqli_query($conexion, "SELECT * FROM cart WHERE id_product= '".$_POST['id']."' AND id_user='".$_SESSION['id_user']."' ");

            if (mysqli_num_rows($cantProducts) >= $stockRow['stock']) {

                $response = array(
                    'success' => false,
                    'message' => '<div class="alert alert-danger" role="alert">Sin stock disponible.</div>'
                );

            }else {

                for ($i=0; $i < $_POST['cant']; $i++) { 
            
                    $insert = mysqli_query($conexion, "INSERT INTO cart (id_product, id_user) VALUES ('".$_POST['id']."', '".$_SESSION['id_user']."')");
                }
    
                if ($insert) {
    
                    $response = array(
                        'success' => true,
                        'message' => '<div class="alert alert-success" role="alert">Agregado al carrito.</div>'
                    );
    
                }else {
    
                    $response = array(
                        'success' => false,
                        'message' => '<div class="alert alert-danger" role="alert">ups, error.</div>'
                    );
                    
                }

            }


                
        }
        
    }

    header('Content-type: application/json');
    echo json_encode($response);















