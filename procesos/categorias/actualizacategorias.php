<?php 


require_once "../../clases/Conexion.php";
require_once "../../clases/Categorias.php";


$datos = array($_POST['idcategoriaold'],utf8_decode($_POST['categoriaupdate']));

$obj= new categorias();

echo $obj->actualizarCategorias($datos);


 ?>