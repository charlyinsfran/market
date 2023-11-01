<?php 


require_once "../../clases/Conexion.php";
require_once "../../clases/Productos.php";


$id = $_POST['idproducto'];

$obj= new productos();

echo $obj->eliminaProducto($id);


 ?>