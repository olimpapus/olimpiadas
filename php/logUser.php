<?php

    session_start();
    include "conexion.php";

    if (empty($_SESSION['id_user'])) {

        echo '
            <a class="nav-link btn btn-info create-new-button" href="login">Iniciar Sesion</a>      
        ';

    }else {
        
        $queryU = mysqli_query($conexion, "SELECT * FROM users WHERE id_user = '".$_SESSION['id_user']."' ");
        while ($datosU = mysqli_fetch_assoc($queryU)) { 

            echo'
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                    <div class="navbar-profile">
                        <img class="img-xs rounded-circle" src="assets/images/faces/face15.jpg" alt="">
                        <p class="mb-0 d-none d-sm-block navbar-profile-name">'.ucwords($datosU['name']).'</p>
                        <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                    <a class="dropdown-item preview-item" href="profile">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-account text-success"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">Perfil</p>
                        </div>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item preview-item" href="php/logOut">
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-dark rounded-circle">
                                <i class="mdi mdi-logout text-danger"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject mb-1">Salir</p>
                        </div>
                    </a>
                </div>
            ';

        } 

    }

    
    
      
    
                                    