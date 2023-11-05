<?php 
require_once "../../clases/Conexion.php";
require_once "../../clases/Clientes.php";

$obj = new clientes();
$ide = $_POST['idcliente'];


echo json_encode($obj->obtenerdatos($ide));






?>