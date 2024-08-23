<?php

    include 'conexion.php';
 
    if (empty($_POST["email"]) || empty($_POST["password"])){

        $response = array(
            'success' => false,
            'message' => '<div class="alert alert-danger" role="alert">Comprete todos los campos.</div>'
        );

    }else {
        if (strlen($_POST["password"]) > '7') {
            $sql = mysqli_query($conexion, "SELECT * FROM users WHERE email='".$_POST["email"]."' ");

            if(mysqli_num_rows($sql) > 0){

                while($datosU = mysqli_fetch_array($sql)){
    
                    if (password_verify($_POST["password"], $datosU['password'])) {
                        
                        session_start();
                        $_SESSION['id_user'] = $datosU['id_user'];
                        $_SESSION['permissions'] = $datosU['permissions'];
                        
                        $response = array(
                            'success' => true
                        );
                      
                    }else {
    
                        $response = array(
                            'success' => false,
                            'message' => '<div class="alert alert-danger" role="alert">Usuario o Contraseña incorrecta.</div>'
                        );
                     
                    }	
                }

            }else {
                
                $response = array(
                    'success' => false,
                    'message' => '<div class="alert alert-danger" role="alert">Usuario o Contraseña incorrecta.</div>'
                );

            }
            
            
        }else{

            $response = array(
                'success' => false,
                'message' => '<div class="alert alert-danger" role="alert">Contraseña muy corta.</div>'
            );
            
        }
            
    } 

    header('Content-type: application/json');
    echo json_encode($response); 
?>