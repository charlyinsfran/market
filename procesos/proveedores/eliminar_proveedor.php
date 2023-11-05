<?php 


require_once "../../clases/Conexion.php";
require_once "../../clases/Proveedores.php";


$id = $_POST['idproveedor'];

$obj= new proveedores();

echo $obj->eliminaProveedor($id);


 ?>