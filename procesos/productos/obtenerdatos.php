<?php 
require_once "../../clases/Conexion.php";
require_once "../../clases/Productos.php";

$obj = new productos();
$ideproducto = $_POST['idproducto'];


echo json_encode($obj->obtenerdatos($ideproducto));






?>