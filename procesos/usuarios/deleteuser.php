<?php 


require_once "../../clases/Conexion.php";
require_once "../../clases/Usuarios.php";


$id = $_POST['idusuario'];

$obj= new usuarios();

echo $obj->eliminausuario($id);


 ?>