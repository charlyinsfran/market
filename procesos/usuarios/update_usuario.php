<?php

require_once "../../clases/Conexion.php";
require_once "../../clases/Usuarios.php";



$datos = array($_POST['idusuarioactualiza'],$_POST['nombreactualiza'],$_POST['apellidoactualiza'],$_POST['emailactualiza'],
$_POST['direccionactualiza'],$_POST['telefonoactualiza'],$_POST['useractualiza'],$_POST['tipousuarioactualiza']);

$obj= new usuarios();

echo $obj->actualizarusuarios($datos);
	

	


?>