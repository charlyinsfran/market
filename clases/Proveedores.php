<?php




class proveedores{


public function new_proveedor($datos){

    $c = new conectar();
    $conexion = $c->conexion();

    $sql = "INSERT INTO proveedores(razon_social,ruc,direccion,id_ciudad,email,telefono,id_usuario,fecha_crud)
    values('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]','$datos[7]')";

        return mysqli_query($conexion,$sql);
    }



    public function obtenerdatos($ide){
        $c = new conectar();
        $conexion = $c->conexion();
        $sql = "SELECT idproveedores,razon_social,ruc,direccion,id_ciudad,email,telefono 
        FROM proveedores WHERE idproveedores = '$ide'";
        $result = mysqli_query($conexion,$sql);

        $ver = mysqli_fetch_row($result);

        $datos = array("idproveedores"=>$ver[0],"razon_social"=>$ver[1],"ruc"=>$ver[2],"direccion"=>$ver[3],
        "id_ciudad"=>$ver[4],"email"=>$ver[5],"telefono"=>$ver[6]);


        return $datos;
    }


    public function actualizarproveedores($datos){

        $c = new conectar();
        $conexion = $c->conexion();
        $sql = "UPDATE proveedores SET razon_social = '$datos[1]',
                                        ruc = '$datos[2]',
                                        direccion = '$datos[3]',
                                        id_ciudad = '$datos[4]',
                                        email = '$datos[5]',
                                        telefono = '$datos[6]'
                                         where idproveedores = '$datos[0]'";
       return mysqli_query($conexion,$sql);

    }




}


?>