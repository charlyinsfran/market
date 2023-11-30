<?php
error_reporting (0); 
include "../clases/conection.php";
//$consulta = $bd->query("SELECT MAX(idcompras) as factura from compras")->fetch(PDO::FETCH_OBJ);
$_SESSION['factura'] = $consulta;
session_start();

$nombrecliente = "";
$apellidocliente = "";
$ruc = "";
$telefono = "";
$email="";


if(isset($_SESSION['usuario'])){

    if(isset($_SESSION['clientes'])){
        $ruc = $_SESSION['clientes']->cedula;
        $nombrecliente = $_SESSION['clientes']->nombre;
        $apellidocliente = $_SESSION['clientes']->apellido;
        $codigocliente = $_SESSION['clientes']->idclientes;
        $telefono = $_SESSION['clientes']->telefono;
        $email = $_SESSION['clientes']->email;
    }
    else{

        $nombrecliente = "";
        $apellidocliente = "";
        $ruc = "";
        $telefono = "";
        $email="";

    }



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagenes/punto-de-venta.png">
    <title>VENTAS</title>

    <?php require_once "menu.php"; ?>

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <form action="modelo_ventas.php" method="post" class="form-group">
                <table class="table table-bordered">
                    <tr style= "background-color: #cdf6fc;">
                    <td style="text-align: center;"><?php // echo "Factura Nro: "."<strong>".($consulta->factura+1)."</strong>"; ?></td>
                        <td colspan="2" style="text-align: center;"><p id="time"></p></td>
                            <td style="text-align: center;"><p id="date"></p></td>
                        
                    </tr>
                <tr>    
                    <!---->
                    <td colspan="1"><label>CLIENTE</label></td>
                    <td colspan="2"><input type="text" class="form-control" name="cicliente" id="cicliente" 
                    placeholder="INGRESE RUC,NOMBRE Ó C.I DEL CLIENTE"></td>
                    <td style="text-align: center;">
                    <button name="operacion" class="btn btn-warning" value="buscar">
                        <span class="glyphicon glyphicon-search"></span>
                        
                    </button> 
                    <?php if(isset($_SESSION['clientes']) && $_SESSION['clientes']!="") {?>
                    <input type="submit" class="btn btn-danger" name="operacion" id="cancelar" value="CANCELAR">
                    
                    <?php }?>
                </td>
                </tr>
            <?php if(isset($_SESSION['clientes'])){ ?>
                <tr>
                    <th>RUC</th>
                    <th>CLIENTE</th>
                    <th>TELEFONO</th>
                    <th>EMAIL</th>
                </tr>
                <tr>
                    <td><?php echo $ruc; ?></td>
                    <td><?php echo $nombrecliente.' '.$apellidocliente; ?></td>
                    <td><?php echo $telefono; ?></td>
                    <td><?php echo $email;?></td>

                </tr>
                <?php }?>
                </table>
                </form>
            </div>
        </div>
    </div>
    <script src="../js/clock.js"></script>
</body>
</html>


<?php
}else{
    header("location:../index.php");

}
?>