<?php

    session_start();
    include "../conexion.php";

    if (empty($_SESSION['id_user'])) {

        echo number_format(0, 2 ,'.', ',');

    }else {

        $queryCart = mysqli_query($conexion, "SELECT SUM(products.price) as total FROM cart INNER JOIN products ON products.id_product = cart.id_product WHERE id_user = '".$_SESSION["id_user"]."' ");
        while($total = mysqli_fetch_array($queryCart)) { 
        
            echo "$".number_format($total['total'], 2 ,'.', ',');
        }

    }



    
    
      
    
                                    