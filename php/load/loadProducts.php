<?php

    session_start();
    include "../conexion.php";

    if (empty($_SESSION['id_user']) || $_SESSION['permissions'] != 'admin') {

        $products[]= array(
            "id"=>'0',
            "title"=>'0',
            "description"=>'0',
            "category"=>'0',
            "price"=>'0',
            "stock"=>'0'
        );

    }else {
        
        $queryP = mysqli_query($conexion, "SELECT * FROM products ORDER BY `id_product` DESC ");
        while ($datosP = mysqli_fetch_assoc($queryP)) { 

            $products[]= array(
                "id"=>$datosP["id_product"],
                "title"=>ucwords($datosP["title"]),
                "description"=>ucwords($datosP["description"]),
                "category"=>ucwords($datosP["category"]),
                "price"=>number_format($datosP["price"], 2, '.', ','),
                "stock"=>$datosP["stock"]
            );

        } 

    }

    $products_string = json_encode($products);
    echo $products_string; 
    


    
    
      
    
                                    