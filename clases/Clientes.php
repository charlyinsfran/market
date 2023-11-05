<?php




class clientes{


public function new_cliente($datos){

    $c = new conectar();
    $conexion = $c->conexion();

    $sql = "INSERT INTO clientes
    (nombre,apellido,cedula,direccion,id_ciudad,email,telefono,id_usuario,fecha_carga_dato)
    VALUES('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]','$datos[7]','$datos[8]')";

        return mysqli_query($conexion,$sql);
    }



    public function obtenerdatos($ide){
        $c = new conectar();
        $conexion = $c->conexion();
        $sql = "SELECT idclientes,nombre,apellido,cedula,direccion,id_ciudad,email,telefono 
        FROM clientes WHERE idclientes = '$ide'";
        $result = mysqli_query($conexion,$sql);

        $ver = mysqli_fetch_row($result);

        $datos = array("idclientes"=>$ver[0],"nombre"=>$ver[1],"apellido"=>$ver[2],"cedula"=>$ver[3],
        "direccion"=>$ver[4],"id_ciudad"=>$ver[5],"email"=>$ver[6],"telefono"=>$ver[7]);


        return $datos;
    }


    public function actualizarclientes($datos){

        $c = new conectar();
        $conexion = $c->conexion();
        $sql = "UPDATE clientes SET nombre = '$datos[1]',
                                    apellido = '$datos[2]',
                                        cedula = '$datos[3]',
                                        direccion = '$datos[4]',
                                        id_ciudad = '$datos[5]',
                                        email = '$datos[6]',
                                        telefono = '$datos[7]'
                                         where idclientes = '$datos[0]'";
       return mysqli_query($conexion,$sql);

    }


    public function eliminacliente($id){
        $c = new conectar();
        $conexion=$c->conexion();
        $sql = "DELETE FROM clientes where idclientes = '$id'";
        return mysqli_query($conexion,$sql);

        
    }



}


?>