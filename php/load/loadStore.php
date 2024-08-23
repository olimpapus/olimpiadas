<?php

    session_start();
    include "../conexion.php";
    
    $products = array();
    
    if (empty($_SESSION['id_user'])) {
    
        $products[] = array(
            "id" => '0',
            "title" => '0',
            "description" => '0',
            "category" => '0',
            "price" => '0',
            "stock" => '0'
        );
    
    } else {
    
        if ($_POST['filters'] == 'all' || empty($_POST['filters'])) {
            
            $queryP = mysqli_query($conexion, "SELECT * FROM products ORDER BY `id_product` DESC ");
            
        }elseif($_POST['filters'] != 'all' && !empty($_POST['filters'])){
            
            $queryP = mysqli_query($conexion, "SELECT * FROM products WHERE category='".$_POST['filters']."' ORDER BY `id_product` DESC ");
            
        }
    
        if ($queryP) {
            
            while ($datosP = mysqli_fetch_assoc($queryP)) {
                $products[] = array(
                    "id" => $datosP["id_product"],
                    "title" => ucwords($datosP["title"]),
                    "description" => ucwords($datosP["description"]),
                    "category" => ucwords($datosP["category"]),
                    "price" => number_format($datosP["price"], 2, '.', ','),
                    "stock" => $datosP["stock"]
                );
            }
            
        } else {
          
            $products[] = array(
                "id" => '0',
                "title" => 'Error',
                "description" => 'Error al ejecutar la consulta.',
                "category" => 'N/A',
                "price" => '0',
                "stock" => '0'
            );
            
        }
    }
    
    echo json_encode($products);
?>
