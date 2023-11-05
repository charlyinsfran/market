<?php


session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/Clientes.php";



$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$ruc = $_POST['ruc'];
$direccion = $_POST['direccion'];
$ciudad = $_POST['ciudad'];
$correo = $_POST['email'];
$telefono = $_POST['telefono'];

$idusuario = $_SESSION['iduser'];

date_default_timezone_set('America/Asuncion');
$fecha = date('Y-m-d H:i:s');

$datos = array($nombre,$apellido,$ruc,$direccion,$ciudad,$correo,$telefono,$idusuario,$fecha);

$obj = new clientes();

echo $obj->new_cliente($datos);


?>



