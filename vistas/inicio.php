<?php


session_start();

if(isset($_SESSION['usuario'])){
    require_once "../clases/Conexion.php";
    $c = new conectar();
    $conexion = $c->conexion();
    $sesiontipo = $_SESSION['tipousuario'];
//query para mostrar la cantidad de productos del sistema
    $sql = "SELECT count(id_producto) from productos";
    $result = mysqli_query($conexion, $sql);

    //query para mostrar la cantidad de proveedores
    $proveedores = "SELECT count(idproveedores) from proveedores";
    $ret_proveedores = mysqli_query($conexion,$proveedores);
    
    //query para mostrar la cantidad de categorias
    $categorias = "SELECT count(id_categoria) from categorias";
    $ret_categorias= mysqli_query($conexion,$categorias);

    //query para mostrar la cantidad de categorias
    $clientes = "SELECT count(idclientes) from clientes";
    $ret_clientes= mysqli_query($conexion,$clientes);

    $compras = "SELECT COUNT(idcompras) from compras;";
    $ret_compras= mysqli_query($conexion,$compras);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagenes/inicio_market.png">
    <link rel="stylesheet" type="text/css" href="../librerias/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/font_awesome.css">
    <script src="../librerias/bootstrap/js/bootstrap.min.js"></script>
    <script src="../librerias/jquery1.js"></script>
   
    <title>INICIO</title>
    <?php require_once "menu.php";?>
</head>
<body>
<div class="container bootstrap snippet">
  <div class="row">
    <div class="col-lg-3 col-sm-6">
      <div class="circle-tile">
        <a href="#"><div class="circle-tile-heading dark-blue"><i class="glyphicon glyphicon-barcode gi-1"></i></div></a>
        <div class="circle-tile-content dark-blue">
          <div class="circle-tile-description text-faded"> Productos</div>
          <div class="circle-tile-number text-faded "><?php while ($ver = mysqli_fetch_row($result)) : echo $ver[0];  endwhile; ?></div>
          <a class="circle-tile-footer" href="productos.php">Ver<i class=""></i></a>
        </div>
      </div>
    </div>
     
    <div class="col-lg-3 col-sm-6">
      <div class="circle-tile ">
        <a href="#"><div class="circle-tile-heading gray"><i class="glyphicon glyphicon-bed gi-2"></i></div></a>
        <div class="circle-tile-content gray">
          <div class="circle-tile-description text-faded"> Proveedores </div>
          <div class="circle-tile-number text-faded "><?php while ($ver = mysqli_fetch_row($ret_proveedores)) : echo $ver[0];  endwhile; ?></div>
          <a class="circle-tile-footer" href="proveedores.php">Ver<i class=""></i></a>
        </div>
      </div>
    </div>
    
    <div class="col-lg-3 col-sm-6">
      <div class="circle-tile ">
        <a href="#"><div class="circle-tile-heading blue"><i class="glyphicon glyphicon-list-alt gi-1"></i></div></a>
        <div class="circle-tile-content blue">
          <div class="circle-tile-description text-faded"> Categorias </div>
          <div class="circle-tile-number text-faded "><?php while ($ver = mysqli_fetch_row($ret_categorias)) : echo $ver[0];  endwhile; ?></div>
          <a class="circle-tile-footer" href="categorias.php">Ver<i class=""></i></a>
        </div>
      </div>
    </div> 

    <div class="col-lg-3 col-sm-6">
      <div class="circle-tile ">
        <a href="#"><div class="circle-tile-heading purple"><i class="glyphicon glyphicon-stats gi-1"></i></div></a>
        <div class="circle-tile-content purple">
          <div class="circle-tile-description text-faded"> Clientes </div>
          <div class="circle-tile-number text-faded "><?php while ($ver = mysqli_fetch_row($ret_clientes)) : echo $ver[0];  endwhile; ?></div>
          <a class="circle-tile-footer" href="clientes.php">Ver<i class=""></i></a>
        </div>
      </div>
    </div> 

    <div class="col-lg-3 col-sm-6">
      <div class="circle-tile ">
        <a href="#"><div class="circle-tile-heading green"><i class="glyphicon glyphicon-stats gi-1"></i></div></a>
        <div class="circle-tile-content green">
          <div class="circle-tile-description text-faded"> Compras de Productos </div>
          <div class="circle-tile-number text-faded "><?php while ($ver = mysqli_fetch_row($ret_compras)) : echo $ver[0];  endwhile; ?></div>
          <a class="circle-tile-footer" href="view_compras.php">Ver<i class=""></i></a>
        </div>
      </div>
    </div> 



  </div> 
</div>  
  
</div>
</div>
   
</body>
</html>

<?php
}else{
    header("location:../index.php");

}
?>