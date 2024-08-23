<?php

    session_start();
    include '../conexion.php';

    if (empty($_SESSION['id_user'])) {

        $response = array(
            'success' => false,
            'message' => '<div class="alert alert-danger" role="alert">No tienes los permisos necesarios.</div>'
        );

    }else {

        if (empty($_POST['name']) || empty($_POST['user']) || empty($_POST['email'])) {

            $response = array(
                'success' => false,
                'message' => '<div class="alert alert-danger" role="alert">Comprete todos los campos.</div>'
            );

        }else {
            
            $update = mysqli_query($conexion, "UPDATE users SET name='".$_POST['name']."', user='".$_POST['user']."', email='".$_POST['email']."' WHERE id_user='".$_SESSION['id_user']."' ");

            if (!empty($_POST['password']) && !empty($_POST["newPassword"]) && !empty($_POST["newPassword2"])){

                $queryU = mysqli_query($conexion,"SELECT * FROM users WHERE id_user='".$_SESSION['id_user']."' ");
                while($datosU = mysqli_fetch_array($queryU)){
    
                    if (password_verify($_POST["password"], $datosU['password'])) {

                        if ($_POST['newPassword'] == $_POST['newPassword2']) {

                            $newPassword = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);
                            
                            $updatePassword = mysqli_query($conexion, "UPDATE users SET password='".$newPassword."' WHERE id_user='".$_SESSION['id_user']."'");
                                
                            if ($updatePassword && $update){
                                
                                $response = array(
                                    'success' => true,
                                    'message' => '<div class="alert alert-success" role="alert">Datos y contraseña modificada con exito.</div>' 
                                );
        
                            }else {
                                
                                $response = array(
                                    'success' => false,
                                    'message' => '<div class="alert alert-danger" role="alert">ups algo salio mal.</div>'
                                );
        
                            }
                            
                        }else {
                            
                            $response = array(
                                'success' => false,
                                'message' => '<div class="alert alert-danger" role="alert">Las contraseñas deben coincidir.</div>'
                            );

                        }
                        
    
                    }else {
                        
                        $response = array(
                            'success' => false,
                            'message' => '<div class="alert alert-danger" role="alert">Contraseña incorecta.</div>'
                        );
    
                    }	
                    
                }
            }else {
                
                if ($update){
                                
                    $response = array(
                        'success' => true,
                        'message' => '<div class="alert alert-success" role="alert">Datos modificados con exito.</div>'
                    );
        
                }else {
                    
                    $response = array(
                        'success' => false,
                        'message' => '<div class="alert alert-danger" role="alert">ups algo salio mal.</div>'
                    );
        
                }
            }
                
        }
        
    }

    header('Content-type: application/json');
    echo json_encode($response);


