<?php

class productos{

    public function subir_imagen($datos){
        $c = new conectar();
        $conexion = $c->conexion();

        $sql = "INSERT INTO imagenes(id_categoria,nombre,ruta,fechaSubida) values ('$datos[0]','$datos[1]','$datos[2]','$datos[3]')";

        $result = mysqli_query($conexion,$sql);

        return mysqli_insert_id($conexion);
    }


    public function agregaproductos($datos){
        $c = new conectar();
        $conexion = $c->conexion();
        date_default_timezone_set('America/Asuncion');
        $fecha = date('Y-m-d');

        $sql = "INSERT INTO productos(id_categoria,id_imagen,id_usuario,nombre,descripcion,cantidad,precio,iva,fechaCaptura)
        values ('$datos[0]','$datos[1]','$datos[2]','$datos[3]','$datos[4]','$datos[5]','$datos[6]','$datos[7]','$fecha')";

        return mysqli_query($conexion,$sql);
    }



    public function obtenerdatos($idproducto){
        
        $c = new conectar();
        $conexion = $c->conexion();
        $sql = "SELECT id_producto,id_categoria,nombre,descripcion,cantidad,precio,iva from productos where id_producto = '$idproducto'";
        $result = mysqli_query($conexion,$sql);

        $ver = mysqli_fetch_row($result);

        $datos = array("id_producto"=>$ver[0],"id_categoria"=>$ver[1],"nombre"=>$ver[2],"descripcion"=>$ver[3],
        "cantidad"=>$ver[4],"precio"=>$ver[5],"iva"=>$ver[6] );


        return $datos;

    }

}


?>