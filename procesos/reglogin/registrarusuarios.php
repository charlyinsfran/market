<?php

require_once "../../clases/Conexion.php";
require_once "../../clases/Usuarios.php";

$obj = new usuarios();

$pass = sha1($_POST['pass']);

$datos = array(
$nombre = $_POST['nombre'],
$apellido = $_POST['apellido'],
$email = $_POST['email'],
$direccion = $_POST['direccion'],
$telefono = $_POST['telefono'],
$usuario = $_POST['usuario'],
$pass

);

echo $obj->registrarUsuario($datos);






?>

