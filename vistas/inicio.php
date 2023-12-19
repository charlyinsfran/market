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

    //query para mostrar la cantidad de clientes
    $clientes = "SELECT count(idclientes) from clientes";
    $ret_clientes= mysqli_query($conexion,$clientes);


    $compras = "SELECT SUM(total) from compras;";
    $ret_compras= mysqli_query($conexion,$compras);

    $ventas = "SELECT SUM(total) from ventas;";
    $ret_ventas= mysqli_query($conexion,$ventas);

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
        <a href="#"><div class="circle-tile-heading dark-blue"><i class="glyphicon glyphicon-barcode gi-1" style="padding-top: 10px;"></i></div></a>
        <div class="circle-tile-content dark-blue">
          <div class="circle-tile-description text-faded"> Productos</div>
          <div class="circle-tile-number text-faded "><?php while ($ver = mysqli_fetch_row($result)) : echo $ver[0];  endwhile; ?></div>
          <a class="circle-tile-footer" href="productos.php">Ver<i class=""></i></a>
        </div>
      </div>
    </div>
     
    
    
    
    <div class="col-lg-3 col-sm-6">
      <div class="circle-tile ">
        <a href="#"><div class="circle-tile-heading purple"><i class="glyphicon glyphicon-bookmark gi-1" style="padding-top: 10px;"></i></div></a>
        <div class="circle-tile-content purple">
          <div class="circle-tile-description text-faded"> Clientes </div>
          <div class="circle-tile-number text-faded "><?php while ($ver = mysqli_fetch_row($ret_clientes)) : echo $ver[0];  endwhile; ?></div>
          <a class="circle-tile-footer" href="clientes.php">Ver<i class=""></i></a>
        </div>
      </div>
    </div> 

    <div class="col-lg-3 col-sm-6">
      <div class="circle-tile ">
        <a href="#"><div class="circle-tile-heading green"><i class="glyphicon glyphicon-shopping-cart gi-1" style="padding-top: 10px;"></i></div></a>
        <div class="circle-tile-content green">
          <div class="circle-tile-description text-faded"> Compras de Productos </div>
          <div class="circle-tile-number text-faded "><?php while ($ver = mysqli_fetch_row($ret_compras)) : echo 'GS. '.number_format($ver[0], 0, ",", ".");  endwhile; ?></div>
          <a class="circle-tile-footer" href="view_compras.php">Ver<i class=""></i></a>
        </div>
      </div>
    </div> 

    <div class="col-lg-3 col-sm-6">
      <div class="circle-tile ">
        <a href="#"><div class="circle-tile-heading blue"><i class="glyphicon glyphicon-usd gi-1" style="padding-top: 10px;"></i></div></a>
        <div class="circle-tile-content blue">
          <div class="circle-tile-description text-faded"> Ventas</div>
          <div class="circle-tile-number text-faded "><?php while ($ver = mysqli_fetch_row($ret_ventas)) : echo 'GS. '.number_format($ver[0], 0, ",", ".");  endwhile; ?></div>
          <a class="circle-tile-footer" href="view_compras.php">Ver<i class=""></i></a>
        </div>
      </div>
    </div> 



  </div> 
</div>  
  
<div class="container">

      <div class="row">

        <div class="col-sm-12">


          <div class="panel">
            
            <div class="panel panel-body">

              <div class="row">
                <div class="col-sm-6">
                  
                  <div id="graficolineal"></div>
                </div>
                <div class="col-sm-6">
                 
                  <div id="graficobarras"></div>


                </div>
              </div>


            </div>
          </div>

        </div>

      </div>

    </div>
   
</body>
</html>

<script>
  $(document).ready(function(){
$('#graficolineal').load('graficos/ventas.php');
$('#graficobarras').load('graficos/compras.php');
});
</script>


<?php
}else{
    header("location:../index.php");

}
?>