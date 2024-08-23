<?php

include '../conexion.php';

    if (empty($_POST['uuid']) || empty($_POST['password']) || empty($_POST['password2'])) {
        
        $response = array(
            'success' => false,
            'message' => '<div class="alert alert-danger" role="alert">Complete todos los campos.</div>'
        );
        
    } else {
        
        $comprobarExistencia = mysqli_query($conexion, "SELECT * FROM tokens WHERE uuid = '".$_POST['uuid']."' "); 
    
        if (mysqli_num_rows($comprobarExistencia) > 0) {
            
            while ($datosT = mysqli_fetch_assoc($comprobarExistencia)) {
                
                if($_POST['password'] == $_POST['password2']){
                    
                    if (strlen($_POST["password"]) > '7') {
                        
                        $newPasswordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        
                        $update = mysqli_query($conexion, "UPDATE users SET password = '".$newPasswordHash."' WHERE id_user='".$datosT['id_user']."' ");
        
                        $delete = mysqli_query($conexion, "DELETE FROM tokens WHERE id_token='".$datosT['id_token']."' ");
        
                        if ($update && $delete) {
                            $response = array(
                                'success' => true,
                                'message' => '<div class="alert alert-success" role="alert">Contraseña modificada con éxito.</div>'
                            );
                        } else {
                            $response = array(
                                'success' => false,
                                'message' => '<div class="alert alert-danger" role="alert">Ups. Error al modificar la contraseña.</div>'
                            );
                        }
                    } else {
                        $response = array(
                            'success' => false,
                            'message' => '<div class="alert alert-danger" role="alert">Contraseña muy corta.</div>'
                        );
                    }
                    
                }else{
                    
                    $response = array(
                        'success' => false,
                        'message' => '<div class="alert alert-danger" role="alert">Las contraseñas deben coincidir.</div>'
                    );
                    
                }
                
            }
        } else {
            $response = array(
                'success' => false,
                'message' => '<div class="alert alert-danger" role="alert">Token inválido.</div>'
            );
        }
    }

header('Content-type: application/json');
echo json_encode($response);


?>
