<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>INICIO</title>
  <?php

  require_once "dependencias.php";
  require_once "../clases/Conexion.php";
  $obj = new conectar();
  $sesion = $_SESSION['usuario'];
  $tipo = $_SESSION['tipousuario'];

  ?>


</head>

<body>
  


  <div id="nav">
    <div class="navbar navbar-inverse navbar-fixed-top" data-spy="affix" data-offset-top="-20">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
           aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>

          </button>

        </div>
        <div id="navbar" class="collapse navbar-collapse">

          <ul class="nav navbar-nav navbar-left">

            <li><a href="inicio.php"><span class="glyphicon glyphicon-home"
             data-toggle="modal" data-target="#presentacion"></span> Inicio</a></li>


            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="glyphicon glyphicon-qrcode">
                  <p></p>
                </span> Productos<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="categorias.php">Categorias</a></li>
                <li><a href="productos.php">Productos</a></li>
                <li><a href="proveedores.php">Proveedores</a></li>
                <?php if($tipo == "admin"){?>
                <li><a href="stock.php">Stock</a></li>
                <?php }?>


              </ul>
            </li>



          <?php if($tipo == "admin"){?>
            <li><a href="usuarios.php"><span class="glyphicon glyphicon-user"></span> Administrar usuarios</a>
            </li>
            <?php }?>
            <li><a href="clientes.php"><span class="glyphicon glyphicon-list-alt  "></span> Clientes</a>
            </li>


            

            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <span class="glyphicon glyphicon-usd"></span> Facturacion <span class="caret"></span></a>

              <ul class="dropdown-menu">


                <li>
                  <a href="ventas.php">Ventas</a>
                  <?php if($tipo == "admin"){?>
                  <a href="compras.php">Compras</a>
                  <a href="view_compras.php">Listado de Compras</a>
                  <?php } ?>
                  <a href="anularventa.php">Anular Venta</a>
                </li>

            </li>
          </ul>
          <?php if($tipo == "admin"){?>
          <li class="dropdown">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <span class="glyphicon glyphicon-file"></span> Reportes <span class="caret"></span></a>

            <ul class="dropdown-menu">
              <li><a href="report.php">All Ventas</a></li>
              <li><a href="reportesdate.php">Reportes por Fecha</a></li>
              
            </ul>
          </li>
          <?php }?>

          <li class="dropdown">
            <a href="#" style="color: red" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <span class="glyphicon glyphicon-user"></span> <strong style="text-decoration: underline;">Usuario:</strong> <?php echo strtoupper($_SESSION['usuario']);?> <span class="caret"></span></a>
            <ul class="dropdown-menu">
            <?php if($tipo != "caja"){?>

              <li> <a style="color: red" href="../procesos/salir.php"><span class="glyphicon glyphicon-off"></span> Salir</a></li>
              
              <?php }?>
              <?php if($tipo == "caja"){?>
            <li><a href="cierrecaja.php"> Ciere Caja / Exit</a>
            </li>
            <?php }?>
            
            </ul>
          </li>
          </ul>
        </div>
      </div>
    </div>
  </div>


</body>

</html>



