<?php 


require_once "../../clases/Conexion.php";
require_once "../../clases/Categorias.php";


$idcateg = $_POST['idcategoria'];

$obj= new categorias();

echo $obj->eliminaCategoria($idcateg);


 ?>