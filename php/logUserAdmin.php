<?php

    session_start();
    include "conexion.php";

    if (empty($_SESSION['id_user']) || $_SESSION['permissions'] != 'admin') {

        echo '';

    }else {
        
        echo '
        <a class="nav-link collapsed" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
            <span class="menu-icon">
              <i class="mdi mdi-laptop"></i>
            </span>
            <span class="menu-title">Administrador</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="ui-basic">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="products">Productos</a></li>
              <li class="nav-item"> <a class="nav-link" href="ordersHistory">Pedidos</a></li>
              <li class="nav-item"> <a class="nav-link" href="users">Usuarios</a></li>
            </ul>
          </div>
        ';

    }

    
    
      
    
                                    