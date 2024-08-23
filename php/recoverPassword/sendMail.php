<?php
session_start();
include '../conexion.php';

    function generateUuidV4() {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf(
            '%s%s-%s-%s-%s-%s%s%s',
            str_split(bin2hex($data), 4)
        );
    }

    if (empty($_POST['email'])) {
    
        $response = array(
            'success' => false,
            'message' => '<div class="alert alert-danger" role="alert">Comprete todos los campos.</div>'
        );
    
    }else {
        
        $queryExistencia = mysqli_query($conexion, "SELECT * FROM users WHERE email='".$_POST['email']."' ");
        if(mysqli_num_rows($queryExistencia) > 0){

            while ($datosU = mysqli_fetch_assoc($queryExistencia)) {

                $uuid = generateUuidV4();

                $deleteTokens = mysqli_query($conexion, "DELETE FROM tokens WHERE id_user = '".$datosU['id_user']."' ");
                $insert = mysqli_query($conexion, "INSERT INTO tokens (id_user, uuid) VALUES ('".$datosU['id_user']."', '".$uuid."')");

                $email = $_POST['email'];
                $mensajeFinal = '
                     <div>	
                        <div>
                            <div style="background:#f9f9f9">
                                <div style="background-color:#f9f9f9">
                                    <div style="margin:0px auto;max-width:640px;background:transparent">
                                        <table style="font-size:0px;width:100%;background:transparent" align="center" border="0">
                                            <tbody>
                                                <tr>
                                                    <td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:40px 0px">
                                                        <div style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%">
                                                            <table width="100%" border="0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="word-break:break-word;font-size:0px;padding:0px" align="center">
                                                                            <table style="border-collapse:collapse;border-spacing:0px" align="center" border="0">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style="width:138px">
                                                                                            <a href="" target="_blank">
                                                                                                <img alt="" title="" height="100px" src="https://mitecnica.com/img/logo.png" width="100" class="CToWUd" data-bit="iit">
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="max-width:640px;margin:0 auto;border-radius:4px;overflow:hidden">
                                        <div style="margin:0px auto;max-width:640px;background:#ffffff">
                                            <table style="font-size:0px;width:100%;background:#ffffff" align="center" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td style="text-align:center;vertical-align:top;direction:ltr;font-size:0px;padding:40px 50px">
                                                            <div style="vertical-align:top;display:inline-block;direction:ltr;font-size:13px;text-align:left;width:100%">
                                                                <table width="100%" border="0">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="word-break:break-word;font-size:0px;padding:0px" align="left">
                                                                                <div style="color:#737f8d;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:16px;line-height:24px;text-align:left">
    
                                                                                    <h2 style="font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-weight:500;font-size:20px;color:#4f545c;letter-spacing:0.27px">
                                                                                        Hola '.ucwords($datosU['user']).'
                                                                                    </h2>
                                                                                    <p>
                                                                                        Puedes restablecer tu contraseña haciendo clic en el botón que aparece a continuación. Si no solicitaste una nueva contraseña, ignora este correo electrónico.
                                                                                    </p>
    
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="word-break:break-word;font-size:0px;padding:10px 25px;padding-top:20px" align="center">
                                                                                <table style="border-collapse:separate" align="center" border="0">
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td style="border:none;border-radius:3px;color:white;padding:15px 19px;" align="center" bgcolor="#0090e7">
                                                                                                <a href="https://olimpiadas.yianweb.com.ar/resetPassword?token='.$uuid.'" style="text-decoration: none;">
                                                                                                  <p style="text-decoration: none;color: #fff;">Cambiar Contraseña</p>
                                                                                                </a>
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="word-break:break-word;font-size:0px;padding:30px 0px">
                                                                                <p style="font-size:1px;margin:0px auto;border-top:1px solid #dcddde;width:100%"></p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div style="margin:0px auto;max-width:640px;background:transparent">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    ';
                $headers = "From: Sistema para olimpiadas <olimpiadas@gmail.com>\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        
        
        
        
                if(mail($email, "Restablecer Contraseña", $mensajeFinal, $headers)){
                    
                    $response = array(
                        'success' => true,
                        'message' => '<div class="alert alert-success" role="alert">Hemos enviado instrucciones para cambiar tu contraseña a <strong>'.$email.'</strong>. Revisa la bandeja de entrada y la carpeta de spam.</div>'
                    );
                    
                }else{
                    
                    $response = array(
                        'success' => false,
                        'message' => '<div class="alert alert-danger" role="alert">ups, error.</div>'
                    );
                    
                }
            }
            
    
           
           
    
        }else {
            
            $response = array(
                'success' => false,
                'message' => '<div class="alert alert-danger" role="alert">No existe este usuario.</div>'
            );
            
    
        }
        
    }





header('Content-type: application/json');
echo json_encode($response);







