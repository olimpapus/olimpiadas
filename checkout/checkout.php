<?php

    session_start();
    include '../php/conexion.php';

//------------------consulta de total a pagar------------------//

    $queryCart = mysqli_query($conexion, "SELECT SUM(products.price) as total FROM cart INNER JOIN products ON products.id_product = cart.id_product WHERE id_user = '".$_SESSION["id_user"]."' ");
    while($total = mysqli_fetch_array($queryCart)) { 

        $totalCart = $total['total'];
    }

//------------------consulta de total a pagar------------------//

//------------------integracion de mercado pago------------------//

require '../composer/vendor/autoload.php';

MercadoPago\SDK::setAccessToken('APP_USR-4160249839482030-081614-375fe24176dc352afec3527c6b905145-767749437');
$preference = new MercadoPago\Preference();

    $preference->back_urls=array(
        "success"=>"https://olimpiadas.yianweb.com.ar/checkout/success",   
        "failure"=> "https://olimpiadas.yianweb.com.ar/checkout/failure",  
        "pending"=> "https://olimpiadas.yianweb.com.ar/checkout/pending", 
    );

    $item = new MercadoPago\Item();
    $item->id = 1;                         
    $item->title = 'Olimpiadas';            
    $item->description = $arrayProductos;		
    $item->quantity = 1;				    
    $item->unit_price = $totalCart;     	    
    $item->currency_id = 'ARG';			    
    $preference->items = array($item);

    $preference->binary_mode = true;
    $preference->notification_url = "https://olimpiadas.yianweb.com.ar/checkout/notify?id_user=".$_SESSION['id_user'];

    $preference->save();

//------------------integracion de mercado pago------------------//

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Pasarela de pago</title>
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
    .form-control:disabled{
      background-color: transparent;
    }
    #totalCart{
      text-align: right;
      margin: 10px;
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
                    
                    <a href="simularNotify">
                        <button class="btn mb-5 btn-info fg btn-lg mt-25" type="submit">
                            Simular pago
                        </button>
                        <br>
                    </a>   
                    
                    <a href="<?php echo $preference->init_point; ?>">
                        <button class="btn btn-info fg btn-lg mt-25" type="submit">
                            Pagar Con Mercado Pago
                        </button>
                        <br>
                    </a>   
                    
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

    <!-- alerta -->
    <div id="alert"></div>

    <script>
        const mp = new MercadoPago('APP_USR-c3a25c1b-f183-4a69-82b5-f915df8e70e9', {
        locale: 'es-AR'
        });
        const checkout = mp.checkout({
            preference: {
                id: '<?php echo $preference->id; ?>'
            },
            autoOpen: true,
        });
    </script>
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

</body>
</html>


