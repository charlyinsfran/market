<?php 

class operacion{

    public function anularventa($datos){

    $c = new conectar();
    $conexion = $c->conexion();
    $var = self::traePass($datos);
    
    if($var > 0){

    $sql = "DELETE FROM detalle_ventas where venta_nro = '$datos[0]'";
    return mysqli_query($conexion,$sql);
    
    echo mysqli_query($conexion,$sql);
    }

    else{

        return 0;

    }
        
    
    }

    public function traePass($datos){
        $c = new conectar();
        $conexion=$c->conexion();

        $codigo = sha1($datos[2]);
    
        $sql = "Select id_usuario from usuarios where password = '$codigo'";
    
        $result = mysqli_query($conexion,$sql);
        
        if(mysqli_num_rows($result) > 0){
            return mysqli_fetch_row($result)[0];
        }else{
            $dut = 0;
            return $dut;
        }

       
    }

}
?>