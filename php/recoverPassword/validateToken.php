<?php
    
    include '../conexion.php';

    $comprobarExistencia = mysqli_query($conexion, "SELECT * FROM tokens WHERE uuid = '".$_POST['uuid']."' ");
    if(mysqli_num_rows($comprobarExistencia) > 0){

        while ($datosT = mysqli_fetch_assoc($comprobarExistencia)) { 

            echo'
                <form method="post" id="formUpdatePassword">
                    <input type="hidden" value="'.$datosT['uuid'].'" name="uuid">
                    <div class="form-group">
                        <label>Nueva contraseña</label>
                        <input type="password" name="password" class="form-control p_input">
                    </div>
                    <div class="form-group">
                        <label>Nueva contraseña</label>
                        <input type="password" name="password2" class="form-control p_input">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-block enter-btn">Cambiar Contraseña</button>
                    </div>
                </form>
            ';
                
        } 

    }else{ 

        echo'
            <form>
                <div class="form-group">
                    <label>Este Token ya se uso</label>
                </div>
            </form>
        ';

    }

?>

            