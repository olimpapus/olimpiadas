<?php

    session_start();
    include '../conexion.php';
    require 'vendor/autoload.php';
    
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    if (empty($_SESSION['id_user'])) {
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Producto');
        $sheet->setCellValue('D1', 'Descripción');
        $sheet->setCellValue('E1', 'Cantidad');
        $sheet->setCellValue('F1', 'Estado');
        $sheet->setCellValue('A2', '0');
        $sheet->setCellValue('B2', '0');
        $sheet->setCellValue('C2', '0');
    } else {
        $queryO = mysqli_query($conexion, "SELECT * FROM orders WHERE status = 'delivered' ORDER BY `id_order` DESC");
    
        $sheet->setCellValue('A1', 'ID Pedido');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Producto');
        $sheet->setCellValue('D1', 'Descripción');
        $sheet->setCellValue('E1', 'Cantidad');
        $sheet->setCellValue('F1', 'Estado');
    
        $fila = 2; 
    
        while ($datosO = mysqli_fetch_array($queryO)) {
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
                        // Escribimos los datos en la hoja de cálculo
                        $sheet->setCellValue('A' . $fila, $datosO['id_order']);
                        $sheet->setCellValue('B' . $fila, $datosU['name']);
                        $sheet->setCellValue('C' . $fila, $datosP['title']);
                        $sheet->setCellValue('D' . $fila, $datosP['description']);
                        $sheet->setCellValue('E' . $fila, $quantity);
                        $sheet->setCellValue('F' . $fila, $datosO['status']);
                        $fila++;
                    }
                    $processed_products[] = $id_product;
                }
            }
        }
    }
    
    $writer = new Xlsx($spreadsheet);
    $filename = 'compras.xlsx';
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'. $filename .'"');
    header('Cache-Control: max-age=0');
    
    $writer->save('php://output');
    exit;
?>
