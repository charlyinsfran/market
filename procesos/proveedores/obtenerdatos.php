<?php 
require_once "../../clases/Conexion.php";
require_once "../../clases/Proveedores.php";

$obj = new proveedores();
$ide = $_POST['idproveedor'];


echo json_encode($obj->obtenerdatos($ide));






?>