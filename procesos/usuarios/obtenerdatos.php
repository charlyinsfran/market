<?php 
require_once "../../clases/Conexion.php";
require_once "../../clases/Usuarios.php";

$obj = new usuarios();
$ide = $_POST['idusuario'];


echo json_encode($obj->obtenerdatos($ide));






?>