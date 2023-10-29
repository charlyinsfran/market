<?php
session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/Categorias.php";

$idusuario = $_SESSION['iduser'];
$descripcion = $_POST['categoria'];
date_default_timezone_set('America/Asuncion');
$fecha = date('Y-m-d');

$datos = array($idusuario,$descripcion,$fecha);

$obj = new categorias();

echo $obj->agregacategorias($datos);


?>



