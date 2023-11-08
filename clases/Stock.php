<?php 
class stock{


public function obtenerdatos($idproducto) { 
    $c = new conectar();
    $conexion = $c->conexion();
    $sql = "SELECT id_producto,nombre,cantidad from productos where id_producto = '$idproducto'";
    $result = mysqli_query($conexion,$sql);

$ver = mysqli_fetch_row($result);

$datos = array("id_producto"=>$ver[0],"nombre"=>$ver[1],"cantidad"=>$ver[2] );


return $datos;    

}

public function actualizarstock($datos){

    $c = new conectar();
    $conexion = $c->conexion();
   

    $query = "INSERT INTO stock(id_producto,id_usuario,cantidad,fechaCaptura) values('$datos[0]','$datos[2]','$datos[1]','$datos[3]')"; 
    $cast =  mysqli_query($conexion,$query);

    return 1;
   

}


}
    
    ?>