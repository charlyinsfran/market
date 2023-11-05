<?php

require_once "../../clases/Conexion.php";
require_once "../../clases/Clientes.php";



$datos = array($_POST['idclientes'],$_POST['nombreupdate'],$_POST['apellidoupdate'],$_POST['rucupdate'],$_POST['direccionupdate'],
$_POST['ciudadupdate'],$_POST['emailupdate'],$_POST['telefonoupdate']);

$obj= new clientes();

echo $obj->actualizarclientes($datos);
	

	


?>