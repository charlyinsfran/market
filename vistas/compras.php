<?php

error_reporting (0); 
include "../clases/conection.php";

$consulta = $bd->query("SELECT MAX(idcompras) as factura from compras")->fetch(PDO::FETCH_OBJ);
$_SESSION['factura'] = $consulta;



session_start();
        $ruc = "";
        $razonsocial = "";
        $codigoproveedor = "";
        $telefono = "";

        $nombreproducto = "";
        $descripcion = "";
        $precioproducto = 0;
        $cantidad = 0;
        $subtotal = 0;
        $iva = 0;
        $producto = "";
        $imp_subtotal = 0;
        $imp_iva = 0;

if(isset($_SESSION['usuario'])){

    if(isset($_SESSION['productos'])){
        $nombreproducto = $_SESSION['productos']->nombre;
        $descripcion = $_SESSION['productos']->descripcion;
        $precioproducto = $_SESSION['productos']->precio;
        $cantidad = $_SESSION['productos']->cantidadtipeada;
        $IVA = $_SESSION['productos']->iva;
        $producto = $_SESSION['productos'];
        $subtotal = $_SESSION['productos']->precio * $_SESSION['productos']->cantidadtipeada;

    

    }else{
        $nombreproducto = "";
        $descripcion = "";
        $precioproducto = 0;
        $cantidad = 0;
        $IVA = 0;
        $subtotal = 0;
        $total = 0;
    }



    if(isset($_SESSION['proveedor'])){
        $ruc = $_SESSION['proveedor']->ruc;
        $razonsocial = $_SESSION['proveedor']->razon_social;
        $codigoproveedor = $_SESSION['proveedor']->idproveedores;
        $telefono = $_SESSION['proveedor']->telefono;
    }
    else{

        $ruc = "";
        $razonsocial = "";
        $codigoproveedor = "";
        $telefono = "";

    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagenes/compra.png">
    
   
    

    <title>COMPRAS</title>

    <?php require_once "menu.php"; ?>


</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <form action="modelo_compras.php" method="post" class="form-group">
                <table class="table table-bordered">
                    <tr style= "background-color: #cdf6fc;">
                    <td style="text-align: center;"><?php echo "Factura Nro: "."<strong>".($consulta->factura+1)."</strong>"; ?></td>
                        <td colspan="1" style="text-align: center;"><p id="time"></p></td>
                            <td style="text-align: center;"><p id="date">date</p></td>
                        
                    </tr>
                <tr>    
                    <!---->
                    <td><label>PROVEEDOR</label></td>
                    <td><input type="text" class="form-control" name="rucproveedor" id="rucproveedor" 
                    placeholder="INGRESE RUC,NOMBRE Ó CODIGO DEL PROVEEDOR o INGRESE '0'"></td>
                    <td style="text-align: center;">
                    <button name="operacion" class="btn btn-warning" value="BUSCAR">
                        <span class="glyphicon glyphicon-search"></span></button> 
                    <?php if(isset($_SESSION['proveedor']) && $_SESSION['proveedor']!="") {?>
                    <input type="submit" class="btn btn-danger" name="operacion" id="cancelar" value="CANCELAR">
                    
                    <?php }?>
                    <a href="../vistas/proveedores.php" class="btn btn-info"><span class="glyphicon glyphicon-plus"><strong>AÑADIR</strong></span></a>
                </td>
                </tr>
                
                <tr>
                    <th>RUC</th>
                    <th>RAZON SOCIAL</th>
                    <th>TELEFONO</th>
                </tr>
                <tr>
                    <td><?php echo $ruc; ?></td>
                    <td><?php echo $razonsocial; ?></td>
                    <td><?php echo $telefono; ?></td>
                </tr>
                </table>
                </form>

<?php if(isset($_SESSION['proveedor'])){ ?>
                <form action="modelo_compras.php" method="post" class="form-group">
                <table class="table table-bordered">
                <tr>
                    <td><label>PRODUCTO</label></td>
                    <td><input type="text" class="form-control" name="producto" id="producto" 
                    placeholder="INGRESE CODIGO DEL PRODUCTO" autofocus></td>
                    <td><input type="text" class="form-control" name="cantidad" id="cantidad"></td>
                    <td><select class="form-control" name="ivaselect" id="ivaselect">
                        <option value="cero">Seleccione IVA:</option>
                        <option value="5">5%</option>
                        <option value="10">10%</option>
                    </select></td>
                    <td colspan= "1" style="text-align: center;">
                    <button class="btn btn-info" name="operacion" value="buscarproducto" id="buscarproducto">
                        <span class="glyphicon glyphicon-search"></span>
                    </td>
                </tr>
                
                <tr style="text-align: center;">
                    <th style="text-align: center;">NOMBRE</th>
                    <th style="text-align: center;">DESCRIPCION</th>
                    <th style="text-align: center;">PRECIO</th>
                    <th style="text-align: center;">CANTIDAD</th>
                    <th style="text-align: center;">IVA</th>
                    <th style="text-align: center;">SUBTOTAL</th>
                </tr>
                
                <?php foreach($producto as $p): 
                    $contador +=1;
                    $subtotal = ($p->precio * $p->cantidadtipeada);

                    

                    ?>
                <tr style="text-align: center;">
                    <td><?php echo strtoupper($p->nombre); ?></td>
                    <td><?php echo strtoupper($p->descripcion); ?></td>
                    <td><?php echo "Gs. ".' '.number_format($p->precio, 0, ",", "."); ?></td>
                    <td><?php echo $p->cantidadtipeada; ?>
                     <input type="text" name="cantidadfinal" id="cantidadfinal" value="<?php echo $p->cantidadtipeada; ?>"
                      hidden>
                    </td>
                    <td><?php
                    
                    
                    if($p->iva == 10){
                        $ivacalculo  = 0.090909;
                        $conver = 100;
                    }
                    else if($p->iva == 5){
                        $ivacalculo = 5;
                        $conver = 1;
                    }
                    echo round(($subtotal * ($ivacalculo/100))*$conver);?> 
                    <input type="text" name="ivafinal" id="ivafinal" value="<?php echo round(($subtotal * ($ivacalculo/100))*$conver); ?>" hidden >
                    </td>
                    <td><input type="text" name="subtotal" id="subtotal" value="<?php echo $subtotal; ?>" hidden>
                     <?php echo "Gs. ".' '.number_format($subtotal, 0, ",", "."); ?>

                </td>
                </tr>
                <?php 
                
                $total += $p->precio * $p->cantidadtipeada;
                $imp_iva += ($subtotal * ($ivacalculo/100)*$conver);
                $imp_subtotal = $total - $imp_iva;
            

                ?>
                <?php endforeach;?>

                <tr><td colspan="4" style="text-align: right; font-family: 'Times New Roman', serif;">
                        <strong style="font-size: 1.5em;">IVA</strong>
                        <td colspan="2" style="font-size:1.5em; font-family:'Trebuchet MS', sans-serif; background-color: #FFFF00; text-align: center;">
                    <?php echo "GS. ".number_format($imp_iva, 0, ",", "."); ?></td>
                    </td></tr>


                <tr><td colspan="4" style="text-align: right; font-family: 'Times New Roman', serif;">
                        <strong style="font-size: 1.5em;">SUBTOTAL</strong>
                        <td colspan="2" style="font-size:1.5em; font-family:'Trebuchet MS', sans-serif; background-color: #FFFF00; text-align: center;">
                    <?php echo "GS. ".number_format($imp_subtotal, 0, ",", "."); ?> <input type="text" name="totalfactura" id="totalfactura" value="<?php echo $imp_subtotal;?>"  hidden></td>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right; font-family: 'Times New Roman', serif;">
                        <strong style="font-size: 1.5em;">TOTAL</strong>
                    </td>
                    <td colspan="2" style="font-size:1.5em; font-family:'Trebuchet MS', sans-serif; background-color: #FFFF00; text-align: center;">
                    <?php echo "GS. ".number_format($total, 0, ",", "."); ?><input type="text" name="subtotalfactura" id="subtotalfactura" value="<?php echo $total;?>"  hidden></td>
                </tr>
                
                </table>
                
                <?php }if(isset($_SESSION['productos'])){?>
                    <select class="form-control" style="height:30px; width:150px;" name="condicion" id="condicion">
                        <option value="A">Forma de Pago</option>
                        <option value="Contado">Contado</option>
                        <option value="Credito">Credito</option>
                    </select>
                    <br><br>
                    
                <td><button class="btn btn-success" name="operacion" id="generarcompra" value="generarcompra">Guardar</button></td>
                <td><button class="btn btn-danger" name="operacion" id="cancelar2" value="cancelar2">Anular</button></td>
                

                <?php }?>
            </div>

        </div>
    </div>

    <script src="../js/clock.js"></script>
</body>
</html>
<script>
$(document).ready(function() {
    //$('#rucproveedor').focus();  

    ('#buscarproducto').click(function() {
        $('#producto').focus();
                });
    
            });      
</script>

<script>
    ('#buscarproducto').click(function() {
        $('#producto').focus();
                })  

    
</script>

<?php 
	switch ($_GET['error']) {
		case 1:
		echo '<script language="Javascript">
		alertify.alert("No existe proveedor");
		</script>';

		break; 

        case 2:
            echo '<script language="Javascript">
            alertify.alert("No existe producto");
            </script>';
           
            break;
            
            
            case 3:
                echo '<script language="Javascript">
                alertify.alert("Debe Seleccionar metodo de pago");
                </script>';
               
                break;


	} 

    switch ($_GET['aviso']) {
		case 1:
		echo '<script language="Javascript">
		alertify.success("Proveedor Seleccionado");
		</script>';

		break;
        
        case 2:
            echo '<script language="Javascript">
            alertify.success("Debes ingresar ruc/codigo/nombre del proveedor");
            </script>';
    
            break;


            case 3:
                echo '<script language="Javascript">
                alertify.error("INGRESE EL CODIGO DEL PRODUCTO");
                </script>';
        
                break;

                case 5:
                    echo '<script language="Javascript">
                    alertify.error("INGRESE LA CANTIDAD");
                    </script>';
            
                break;

                case 6:
                    echo '<script language="Javascript">
                    alertify.error("INGRESE IVA CORRESPONDIENTE");
                    </script>';
            
                    break;
                    case 7:
                        echo '<script language="Javascript">
                        alertify.error("EL IVA SELECCIONADO NO COINCIDE");
                        </script>';
                
                        break;

	} 



    ?>

<?php
}else{
    header("location:../index.php");

}
?>