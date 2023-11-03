<?php
session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/Proveedores.php";




$idusuario = $_SESSION['iduser'];
$ciudad = $_POST['ciudad'];
$razon = $_POST['razon_social'];
$ruc = $_POST['ruc'];
$direccion = $_POST['direccion'];
$correo = $_POST['email'];
$telefono = $_POST['telefono'];

date_default_timezone_set('America/Asuncion');
$fecha = date('Y-m-d H:i:s');

$datos = array($razon,$ruc,$direccion,$ciudad,$correo,$telefono,$idusuario,$fecha);

$obj = new proveedores();

echo $obj->new_proveedor($datos);


?>


