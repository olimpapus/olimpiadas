<?php

session_start();
include "../conexion.php";

    if (empty($_SESSION['id_user'])) {

        $response = array(
            'success' => false,
            'message' => '<div class="alert alert-danger" role="alert">No tienes los permisos necesarios.</div>'
        );

    }else {

        $queryRepetido = mysqli_query($conexion, "SELECT * FROM orders WHERE id_order = '".$_POST['id_order']."' ");

        if ($queryRepetido && mysqli_num_rows($queryRepetido) > 0) {

            while ($a = mysqli_fetch_array($queryRepetido)) {

                if ($a['id_user'] == $_SESSION['id_user'] || $_SESSION['permissions'] == 'admin') {

                    $array_data = json_decode($a['shopping'], true);
                    $position_to_remove = null;
                    foreach ($array_data as $index => $item) {
                        if ($item['id_product'] == $_POST['id_product']) {
                            $position_to_remove = $index;
                            break;
                        }
                    }

                    if ($position_to_remove !== null) {
                        
                        unset($array_data[$position_to_remove]);
                        $array_data = array_values($array_data);
                        $new_json_data = json_encode($array_data);

                        $update_query = mysqli_query($conexion, "UPDATE orders SET shopping = '$new_json_data' WHERE id_order = '".$_POST['id_order']."' ");

                        if ($update_query) {

                            $response = array(
                                'success' => true
                            );

                        } else {

                            $response = array(
                                'success' => false,
                                'message' => '<div class="alert alert-danger" role="alert"Ups. error</div>'
                            );

                        }
                        
                    } else {

                        $response = array(
                            'success' => false,
                            'message' => '<div class="alert alert-danger" role="alert">No se encuentra ese producto en la orden.</div>'
                        );

                    }
                    
                }else {
                    
                    $response = array(
                        'success' => false,
                        'message' => '<div class="alert alert-danger" role="alert">Esta orden no corresponde a esta id_user.</div>'
                    );

                }

            
            }
        } else {

            $response = array(
                'success' => false,
                'message' => '<div class="alert alert-danger" role="alert">No se encuentra esa orden.</div>'
            );

        }
    }


?>
