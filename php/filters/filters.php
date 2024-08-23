<?php

    include "../conexion.php";

        echo '<option value="all">Todas las categorias</option>';

        $queryC = mysqli_query($conexion, "SELECT DISTINCT category FROM products ");
        while ($datosC = mysqli_fetch_assoc($queryC)) { 

            echo '<option value="'.$datosC['category'].'">'.ucwords($datosC['category']).'</option>';
        } 

    

   
    


    
    
      
    
                                    