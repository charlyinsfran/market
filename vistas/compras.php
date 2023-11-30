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
    <link rel="stylesheet" href="estilocompras.css">

    <title>COMPRAS - DCHRSOFT</title>

    <?php require_once "menu.php"; ?>


</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <form action="modelo_compras.php" method="post" class="form-group">
                <table class="table table-bordered">
                    <tr style= "background-color: #cdf6fc;">
                    <td style="text-align: center;"><?php echo "Factura Nro: 001-001-000"."<strong>".($consulta->factura+1)."</strong>"; ?></td>
                        <td colspan="1" style="text-align: center;"><p id="time"></p></td>
                            <td colspan="1" style="text-align: center;"><p id="date">date</p></td>
                        
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

                    <?php if(!isset($_SESSION['proveedor']) && $_SESSION['proveedor']=="") {?>
                    <a class="btn" style="background-color: BLUE;">
                    <span class="glyphicon glyphicon-plus" style="color:#cdf6fc;" data-toggle="modal" data-target="#verproveedores"><strong style="color:#cdf6fc;">NEW</strong></span></a>
                    <?php }?>
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
                <table class="table table-bordered" style="overflow:scroll; height:200px; width:1200px;"      >
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
                        <strong style="font-size: 1.3em;">IVA</strong>
                        <td colspan="2" style="font-size:1.3em; font-family:'Trebuchet MS', sans-serif; background-color: #FFFF00; text-align: center;">
                    <?php echo "GS. ".number_format($imp_iva, 0, ",", "."); ?></td>
                    </td></tr>


                <tr><td colspan="4" style="text-align: right; font-family: 'Times New Roman', serif;">
                        <strong style="font-size: 1.5em;">SUBTOTAL</strong>
                        <td colspan="2" style="font-size:1.3em; font-family:'Trebuchet MS', sans-serif; background-color: #FFFF00; text-align: center;">
                    <?php echo "GS. ".number_format($imp_subtotal, 0, ",", "."); ?> <input type="text" name="totalfactura" id="totalfactura" value="<?php echo $imp_subtotal;?>"  hidden></td>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right; font-family: 'Times New Roman', serif;">
                        <strong style="font-size: 1.3em;">TOTAL</strong>
                    </td>
                    <td colspan="2" style="font-size:1.3em; font-family:'Trebuchet MS', sans-serif; background-color: #FFFF00; text-align: center;">
                    <?php echo "GS. ".number_format($total, 0, ",", "."); ?><input type="text" name="subtotalfactura" id="subtotalfactura" value="<?php echo $total;?>"  hidden></td>
                </tr>
                
                </table>
                
                <?php }if(isset($_SESSION['productos'])){?>
                    <label>Forma de Pago</label>
                    <select class="form-control" style="height:30px; width:150px;" name="condicion" id="condicion">
                        <option value="Contado">Contado</option>
                        <option value="Credito">Credito</option>
                    </select>
                    <br>
                    
                <td><span class="btn btn-success" data-toggle="modal" data-target="#comprar" id="vermodalcompra" name="vermodalcompra">Grabar</span></td>
                <td><button class="btn btn-danger" name="operacion" id="cancelar2" value="cancelar2" >Anular</button></td>
                

                <?php }?>
            </div>

        </div>
    </div>




    <div class="modal fade" id="verproveedores" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document" style="width: 600px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">View Proveedores</h4>
                    </div>
                    <div class="modal-body" align="center">

                        <table class="table-hover table-condensed table-bordered" style="width: 500px;">
                            <thead>
                            <tr style="text-align: center; font-weight: bold;">
                                <td>Codigo</td>
                                 <td>Razon Social</td>
                                 <td>Ruc</td>
                                 <td>Telefono</td>
                                 <td>+</td>
                             </tr>
                        </thead>
                    <tbody>
                <?php
    require_once "../clases/Conexion.php";
    $c = new conectar();
    $conexion = $c->conexion();
    $sql = "SELECT idproveedores,razon_social,ruc,telefono from proveedores  ORDER BY idproveedores";
    
    $result = mysqli_query($conexion, $sql);
    while ($ver = mysqli_fetch_row($result)) :
    ?>

        <tr style="font-size: 14px;" >
            <td style="width: 20px; text-align:center; height:10px;"><?php echo $ver[0]; ?></td>
            <td style="text-align: center; height:10px;"><?php echo $ver[1]; ?></td>
            <td style="text-align: center; height:10px;"><?php echo $ver[2]; ?></td>
            <td style="text-align: center; height:10px;"><?php echo $ver[3]; ?></td>
            <td><span class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-menu-left" onclick="cargar('<?php echo $ver[2] ?>')"></span>
            </span></td>
            
            </tr>


    <?php endwhile; ?>
    </tbody>

                        </table>
                        



                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="comprar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document" style="width: 300px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Generar Compra</h4>
                    </div>
                    <div class="modal-body">
                    <form id="frm_grabar" action="modelo_compras.php" method="POST">
                            
                            <label>Total</label>
                            <input type="text" class="form-control input-sm" id="totalmodal" name="totalmodal">
                            <label>Metodo de Pago</label>
                            <input type="text" class="form-control input-sm" id="pagomodal" name="pagomodal">
                            <p></p>
                            <button class="btn btn-success glyphicon glyphicon-check" name="operacion" id="generarcompra" value="generarcompra" ></button>
                        </form>
                    </div>
                    <div class="modal-footer">

                    </div>
                </div>
            </div>
        </div>

    <script src="../js/clock.js"></script>
</body>
</html>

<script>
    
    $('#comprar').on('shown.bs.modal', function () {
         //$('#dineromodal').focus();
         var datoformapago = document.getElementById("condicion").value;
         var totalapagar = document.getElementById("subtotalfactura").value;
         document.getElementById("totalmodal").value = totalapagar;
         document.getElementById("pagomodal").value = datoformapago;

        })
    
                 
              
    
        
</script>

<script>
    function cargar(ruc){
        //alert(ruc);
        var dato = ruc;
        document.getElementById("rucproveedor").value = dato;
        $('#verproveedores').modal('hide');
    }
</script>
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
            $("#rucproveedor").focus();
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