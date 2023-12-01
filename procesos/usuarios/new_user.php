<?php 

session_start();
require_once "../../clases/Conexion.php";
require_once "../../clases/Usuarios.php";


$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$usuarionombre = $_POST['user'];
$contrasenha = sha1($_POST['password']);
$id_rol = $_POST['tipousuario'];




date_default_timezone_set('America/Asuncion');
$fecha = date('Y-m-d H:i:s');

$datos = array($nombre,$apellido,$email,$direccion,$telefono,$usuarionombre,$contrasenha,$fecha,$id_rol);

$obj = new usuarios();

echo $obj->new_usuario($datos);



?>