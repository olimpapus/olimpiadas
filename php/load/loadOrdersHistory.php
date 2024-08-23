<?php

session_start();
include '../conexion.php';

    $JSON = array();

    if (empty($_SESSION['id_user']) || $_SESSION['permissions'] != 'admin') {

        $JSON[] = array(
            "id" => '0', 
            "name" => '0',
            "shopping" => '0'
        );

    } else {
        
        function truncateText($text, $wordLimit) {
            $words = explode(' ', $text);
            if (count($words) > $wordLimit) {
                $words = array_slice($words, 0, $wordLimit);
                $text = implode(' ', $words) . '...';
            }
            return $text;
        }

        $queryO = mysqli_query($conexion, "SELECT * FROM orders ORDER BY `id_order` DESC");
        while ($datosO = mysqli_fetch_array($queryO)) {

            $tablas = "";
            $btnEntregado = "";
            $processed_products = array(); 

            $queryU = mysqli_query($conexion, "SELECT * FROM users WHERE id_user = '".$datosO['id_user']."' ");
            $datosU = mysqli_fetch_array($queryU);
            
            $shopping_items = json_decode($datosO['shopping'], true); 

            $product_counts = array();

            foreach ($shopping_items as $shopping_item) {
                
                if (isset($product_counts[$shopping_item['id_product']])) {
                    $product_counts[$shopping_item['id_product']]++;
                } else {
                    $product_counts[$shopping_item['id_product']] = 1;
                }
            }

            foreach ($product_counts as $id_product => $quantity) {
                if (!in_array($id_product, $processed_products)) {
                    $queryP = mysqli_query($conexion, "SELECT * FROM products WHERE id_product = '".$id_product."' ");
                    while ($datosP = mysqli_fetch_array($queryP)) {

                        $tablas .= "
                            <tr>
                                <td>".$datosP['title']."</td>
                                <td>".truncateText(ucwords($datosP["description"]), '9')."</td>
                                <td>".$quantity."</td>
                            <!--<td>
                                    <form class='deleteOrder'>
                                        <input type='hidden' name='id_product' value='".$id_product."'>
                                        <input type='hidden' name='id_order' value='".$datosO['id_order']."'>
                                        <button type='submit' class='btn btn-danger btn-icon-text'>
                                            Eliminar 
                                        </button>
                                    </form> 
                                </td>-->
                            </tr>
                        ";

                    }

                    $processed_products[] = $id_product;
                }
            }
            
            if($datosO['status'] == 'pending'){
                $btnEntregado = '
                    <form method="post" class="formUpdateOrders">
                        <input type="hidden" name="id" value="'.$datosO['id_order'].'">
                        <button type="submit" class="btn btn-primary btn-icon-text">
                            Marcar como entregado
                        </button>
                    </form> 
                ';
            }

            $JSON[] = array(
                "id" => $datosO['id_order'], 
                "name" => $datosU['name'],
                "status" => $datosO['status'],
                "shopping" => $tablas,
                "btn" => $btnEntregado,
                "date"=>$dtaosO['date']
            );
        }
    }

    $JSON_ENCODE = json_encode($JSON);
    echo $JSON_ENCODE;

?>
