<?php


session_start();
$idusuario = $_SESSION['iduser'];
require_once "../../clases/Conexion.php";
require_once "../../clases/Productos.php";

$obj = new productos();

date_default_timezone_set('America/Asuncion');
$fecha = date('Y-m-d');

$idcategoria = $_POST['categoria_select'];
$nombre = $_POST['descripcion'];
$descripcion = $_POST['detalle'];
$cantidad = $_POST['stock'];
$precio = $_POST['precio'];
$iva = $_POST['iva_select']; 

$nombre_imagen = $_FILES['imagen']['name'];
$ruta_almacenamiento = $_FILES['imagen']['tmp_name'];
$carpeta = '../../archivos/';
$rutafinal = $carpeta.$nombre_imagen;



$datos=array();
$datosImg = array($idcategoria,$nombre_imagen,$rutafinal,$fecha);


if(move_uploaded_file($ruta_almacenamiento,$rutafinal)){

    $idimagen = $obj->subir_imagen($datosImg);

    if($idimagen>0){

        $datos[0] = $idcategoria;
        $datos[1] = $idimagen;
        $datos[2] = $idusuario;
        $datos[3] = $nombre;
        $datos[4] = $descripcion;
        $datos[5] = $cantidad;
        $datos[6]= $precio;
        $datos[7]= $iva;

        echo $obj->agregaproductos($datos);

    }

}

?>