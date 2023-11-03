<?php

require_once "../../clases/Conexion.php";
require_once "../../clases/Proveedores.php";



$datos = array($_POST['idproveedor'],$_POST['razon_socialupdate'],$_POST['rucupdate'],$_POST['direccionupdateupdate'],
$_POST['ciudadupdate'],$_POST['emailupdate'],$_POST['telefonoupdate']);

$obj= new proveedores();

echo $obj->actualizarproveedores($datos);
	

	


?>