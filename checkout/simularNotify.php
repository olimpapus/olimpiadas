

<?php

    session_start();
    include '../php/conexion.php';
    
    $responses = file_get_contents("http://worldtimeapi.org/api/timezone/America/Argentina/Buenos_Aires");
    $data = json_decode($responses, true);
    
//------------------JSON productos------------------//

    $resultado = mysqli_query($conexion, "SELECT * FROM cart WHERE id_user = '".$_SESSION['id_user']."' ");
    while ($a = mysqli_fetch_array($resultado)) {

        $JSON[] = array(
            "id_cart" => $a['id_cart'], 
            "id_product" => $a['id_product'],
            "id_user" => $a['id_user']

        );
    }

    $JSON_ENCODE = json_encode($JSON);

//------------------JSON productos------------------//
 
    
        $insert = mysqli_query($conexion, "INSERT INTO orders (id_user, shopping, status, date) VALUES ('".$_SESSION['id_user']."', '".$JSON_ENCODE."', 'pending', '".$data['datetime']."')");
        
        if ($insert) {
        
            $descontarStock = mysqli_query($conexion, "SELECT id_product, COUNT(*) AS repeat_count FROM cart WHERE id_user = '".$_SESSION['id_user']."' GROUP BY id_product  ");
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

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Success</title>
  <link href="assets/bootstrap/bootstrap.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="../assets/vendors/jvectormap/jquery-jvectormap.css">
  <link rel="stylesheet" href="../assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="../assets/vendors/owl-carousel-2/owl.carousel.min.css">
  <link rel="stylesheet" href="../assets/vendors/owl-carousel-2/owl.theme.default.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="shortcut icon" href="../assets/images/favicon.png" />
  <style>
        body {
          font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial, sans-serif; 
        }
        h2{
            color: #000 !important;
        }
  </style>
</head>
<body>

    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper">
            <!-- header orizontal -->
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo-mini" href="index"><img src="../assets/images/favicon.png" style="width: 30px;" alt="logo" /></a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <ul class="navbar-nav w-100">
                    </ul>
                    <ul class="navbar-nav navbar-nav-right">
                    </ul>
                </div>
            </nav>
            <!-- main -->
            <div class="main-panel">
                <div class="content-wrapper">
                      
                </div>
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com 2020</span>
                        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin templates</a> from Bootstrapdash.com</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../assets/vendors/chart.js/Chart.min.js"></script>
    <script src="../assets/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="../assets/vendors/jvectormap/jquery-jvectormap.min.js"></script>
    <script src="../assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="../assets/vendors/owl-carousel-2/owl.carousel.min.js"></script>
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/misc.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <script src="../js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
      Swal.fire({
        title: "Pago realizado con éxito.(simulacion)",
        icon: "success",
        width: 600,
        padding: "3em",
        color: "#716add",
        background: "#fff url()",
        backdrop: `
          rgba(0,0,123,0.4)
          url("https://sweetalert2.github.io/images/nyan-cat.gif")
          left top
          no-repeat
        `
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "/orders";
        }
      });
    </script>

</body>
</html>





