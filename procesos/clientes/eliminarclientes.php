<?php 


require_once "../../clases/Conexion.php";
require_once "../../clases/Clientes.php";


$id = $_POST['idcliente'];

$obj= new clientes();

echo $obj->eliminacliente($id);


 ?>