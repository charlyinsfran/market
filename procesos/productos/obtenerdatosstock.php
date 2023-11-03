<?php 
require_once "../../clases/Conexion.php";
require_once "../../clases/Stock.php";

$obj = new stock();
$ideproducto = $_POST['idproducto'];


echo json_encode($obj->obtenerdatos($ideproducto));






?>