<?php
    include '../conexion.php';
    require 'vendor/autoload.php';
    
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    
    $queryProducts = mysqli_query($conexion, "SELECT * FROM products");
    
    $datos = [
        ['Titulo', 'Descripcion', 'Categoria', 'Precio', 'Stock'], // Títulos de las columnas
    ];
    
    if ($queryProducts->num_rows > 0) {
        while ($datosO = $queryProducts->fetch_assoc()) {
            
            $datos[] = [
                $datosO['title'],
                $datosO['description'],
                $datosO['category'],
                $datosO['price'],
                $datosO['stock'] 
            ];
            
        }
    } else {
        echo "No se encontraron registros.";
        exit; // Salir si no hay registros para evitar descargar un archivo vacío
    }
    
    // Escribir los datos en el archivo de Excel
    $fila = 1; 
    foreach ($datos as $filaDatos) {
        $columna = 'A';
        foreach ($filaDatos as $celda) {
            $sheet->setCellValue($columna . $fila, $celda);
            $columna++;
        }
        $fila++;
    }
    
    // Crear y enviar el archivo Excel al navegador
    $writer = new Xlsx($spreadsheet);
    $filename = 'productos.xlsx';
    
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'. $filename .'"');
    header('Cache-Control: max-age=0');
    
    // Guardar el archivo en la salida
    $writer->save('php://output');
    exit;
?>
