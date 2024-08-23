<?php

    session_start();
    include "../conexion.php";

    if (empty($_SESSION['id_user'])) {

        $products[]= array(
            "id"=>'0',
            "title"=>'0',
            "description"=>'0',
            "category"=>'0',
            "price"=>'0',
            "stock"=>'0'
        );

    }else {
        
        function truncateText($text, $wordLimit) {
            $words = explode(' ', $text);
            if (count($words) > $wordLimit) {
                $words = array_slice($words, 0, $wordLimit);
                $text = implode(' ', $words) . '...';
            }
            return $text;
        }

        $queryC = mysqli_query($conexion, "SELECT DISTINCT id_product FROM cart WHERE id_user= '".$_SESSION['id_user']."' ");
        while ($datosC = mysqli_fetch_assoc($queryC)) { 

            $queryCant= mysqli_query($conexion,"SELECT COUNT(*) 'cant' FROM cart WHERE id_user = '".$_SESSION["id_user"]."' AND id_product = '".$datosC["id_product"]."';");
            while($cant = mysqli_fetch_array($queryCant)) { 
            
                $queryP = mysqli_query($conexion, "SELECT * FROM products WHERE id_product='".$datosC['id_product']."' ");
                while ($datosP = mysqli_fetch_assoc($queryP)) { 

                    $products[]= array(
                        "id"=>$datosP["id_product"],
                        "title"=>truncateText(ucwords($datosP["title"]), '9'),
                        "description"=>truncateText(ucwords($datosP["description"]), '9'),
                        "price"=>number_format($datosP["price"], 2, '.', ','),
                        "cant"=>$cant["cant"],
                    );

                } 
            } 
        } 

    }

    $products_string = json_encode($products);
    echo $products_string; 
    


    
    
      
    
                                    