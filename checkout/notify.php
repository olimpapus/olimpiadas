<?php

    include '../php/conexion.php';
    
    $responses = file_get_contents("http://worldtimeapi.org/api/timezone/America/Argentina/Buenos_Aires");
    $data = json_decode($responses, true);
    
//------------------JSON productos------------------//

    $resultado = mysqli_query($conexion, "SELECT * FROM cart WHERE id_user = '".$_GET['id_user']."' ");
    while ($a = mysqli_fetch_array($resultado)) {

        $JSON[] = array(
            "id_cart" => $a['id_cart'], 
            "id_product" => $a['id_product'],
            "id_user" => $a['id_user']

        );
    }

    $JSON_ENCODE = json_encode($JSON);

//------------------JSON productos------------------//
 
    
    $access_token = 'APP_USR-4160249839482030-081614-375fe24176dc352afec3527c6b905145-767749437';

    $raw_post_data = file_get_contents('php://input');
    $notification_data = json_decode($raw_post_data, true);
    $url = "https://api.mercadopago.com/v1/payments/{$notification_data['data']['id']}?access_token={$access_token}";
    $response = file_get_contents($url);
    $payment_data = json_decode($response, true);
                
    if ($payment_data['status'] == 'approved'){
    
        $insert = mysqli_query($conexion, "INSERT INTO orders (id_user, shopping, status, date) VALUES ('".$_GET['id_user']."', '".$JSON_ENCODE."', 'pending', '".$data['datetime']."')");
        
        if ($insert) {
        
            $descontarStock = mysqli_query($conexion, "SELECT id_product, COUNT(*) AS repeat_count FROM cart WHERE id_user = '".$_GET['id_user']."' GROUP BY id_product  ");
            while ($e = mysqli_fetch_array($descontarStock)) {
                
                $update = mysqli_query($conexion, "UPDATE products SET stock = stock - ".$e['repeat_count']." WHERE id_product = '".$e['id_product']."'");
            
            }
        
            $delete = mysqli_query($conexion, "DELETE FROM cart WHERE id_user = '".$_SESSION['id_user']."'");
            
            if ($delete) {
                
                $mensaje = "El pedido se ha realizado correctamente y el stock se ha actualizado.";
                
            } else {
                
                echo "Error al eliminar los productos del carrito: " . mysqli_error($conexion);
                
            }
        
        } else {
            
            echo "Error al insertar el pedido: " . mysqli_error($conexion);
            
        }

    }


?>
