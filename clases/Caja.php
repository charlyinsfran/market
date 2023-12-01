<?php

class caja{
    function aperturacaja($datos){
        $c = new conectar();
        $conexion = $c->conexion();


        $sql = "INSERT INTO control_caja(aperturamonto,fec_hora_apertura,id_usuariocj) values ('$datos[0]','$datos[1]','$datos[2]')";

        return mysqli_query($conexion,$sql);
    }


    function cierrecaja($datos){
        $c = new conectar();
        $conexion = $c->conexion();


        $sql = "UPDATE control_caja set cierre_monto = '$datos[0]',
         fec_hora_cierre = '$datos[1]',
         diferencia = '$datos[2]' 
         WHERE idcontrol_caja = '$datos[3]'";

        return mysqli_query($conexion,$sql);
    }
}


?>
