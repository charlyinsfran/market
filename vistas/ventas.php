            <?php
            error_reporting(0);
            include "../clases/conection.php";
            $traeidventa = $bd->query("SELECT MAX(idventas) as idventa from ventas")->fetch(PDO::FETCH_OBJ);
            $_SESSION['idventa'] = $traeidventa;
            $id = $_SESSION['idventa']->idventa;
           
            $vueltores = $bd->query("SELECT vuelto from ventas where idventas = '$id'")->fetch(PDO::FETCH_OBJ);
            $_SESSION['vuelto'] = $vueltores;
            $vueltoimp = $_SESSION['vuelto']->vuelto;

            $consulta = $bd->query("SELECT MAX(idventas) as factura from ventas")->fetch(PDO::FETCH_OBJ);
            $_SESSION['factura'] = $consulta;
            session_start();

            $nombrecliente = "";
            $apellidocliente = "";
            $ruc = "";
            $telefono = "";
            $email = "";
            $mostrarconsulta = $consulta->factura;
            $autocompl_factura = "000000";

            $nombreproducto = "";
            $descripcion = "";
            $precioproducto = 0;
            $cantidad = 0;
            $subtotal = 0;
            $iva = 0;
            $producto = "";


            if ($mostrarconsulta > 1 && $mostrarconsulta <= 9) {
                $autocompl_factura = "000000";
            } else if ($mostrarconsulta > 9 && $mostrarconsulta <= 99) {
                $autocompl_factura = "00000";
            } else if ($mostrarconsulta > 99 && $mostrarconsulta <= 999) {

                $autocompl_factura = "0000";
            } else if ($mostrarconsulta > 999 && $mostrarconsulta <= 9999) {
                $autocompl_factura = "000";
            }

            if (isset($_SESSION['usuario'])) {

                if (isset($_SESSION['clientes'])) {
                    $ruc = $_SESSION['clientes']->cedula;
                    $nombrecliente = $_SESSION['clientes']->nombre;
                    $apellidocliente = $_SESSION['clientes']->apellido;
                    $codigocliente = $_SESSION['clientes']->idclientes;
                    $telefono = $_SESSION['clientes']->telefono;
                    $email = $_SESSION['clientes']->email;
                } else {

                    $nombrecliente = "";
                    $apellidocliente = "";
                    $ruc = "";
                    $telefono = "";
                    $email = "";
                }


                if (isset($_SESSION['productos'])) {
                    $nombreproducto = $_SESSION['productos']->id_producto;
                    $descripcion = $_SESSION['productos']->nombre;
                    $precioproducto = $_SESSION['productos']->precio;
                    $cantidad = $_SESSION['productos']->cantidadingresada;
                    $producto = $_SESSION['productos'];
                    $subtotal = $_SESSION['productos']->precio * $_SESSION['productos']->cantidadingresada;
                } else {
                    $nombreproducto = "";
                    $descripcion = "";
                    $precioproducto = 0;
                    $cantidad = 0;
                    $IVA = 0;
                    $subtotal = 0;
                    $total = 0;
                }



            ?>
                <!DOCTYPE html>
                <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="shortcut icon" href="../imagenes/punto-de-venta.png">
                    <link rel="stylesheet" href="../css/estilosventas.css">
                    <title>VENTAS</title>

                    <?php require_once "menu.php"; ?>

                </head>

                <body>
                    
                    <div class="container" style="padding-top: -5px;">
                        <div class="row">
                            <div class="col-sm-15">
                                <form action="modelo_ventas.php" method="post" class="form-group" id="for_venta">
                                <!--<button  name="operacion" class="btn btn-sm" value="prueba">Prueba
                                                    </button> -->
                                    <table class="table table-bordered">
                                        <tr style="background-color: #cdf6fc; height: 5px; width: 10px;">
                                            <td rowspan="2" style="background-color: white; text-align: center;">
                                                <label style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 1.4em; color:blueviolet">ULTIMO VUELTO</label>

                                                <p></p>
                                                <input type="text" readonly style="font-size: 2.5em; width: 200px; border: 0; text-align: center;" class="input-sm" value="<?php echo 'GS. '.number_format($vueltoimp, 0, ",", "."); ?>">
                                            </td>
                                            <td style="text-align: center;"><?php echo "Factura Nro:  " . $autocompl_factura . "<strong>" . ($mostrarconsulta + 1) . "</strong>"; ?></td>
                                            
                                            <td colspan="1" style="text-align: center;">
                                                <p id="time"></p>
                                            </td>
                                            <td style="text-align: center;">
                                                <p id="date"></p>
                                            </td>

                                        </tr>
                                        <tr style="height: 10px;">

                                            <td colspan="1" style="height: 15px; text-align: center;"><label style="text-align: center;">CLIENTE</label></td>
                                            <td colspan="1"><input type="text" class="form-control" name="cicliente" id="cicliente" placeholder="INGRESE RUC Ó C.I DEL CLIENTE" maxlength="12"></td>

                                            <td style="text-align: center;">
                                                <?php if (!isset($_SESSION['clientes'])) { ?>
                                                    
                                                    <button name="operacion" class="btn btn-sm" value="buscar" id="buscarclientebtn">
                                                        <img src="../imagenes/iconos/clienteadd.svg" alt="x" />
                                                    </button>
                                                <?php } ?>
                                                <span class="btn btn-sm" id="nuevoclientebtn">

                                                    <span data-toggle="modal" data-target="#nuevoclientemodal">
                                                        <img src="../imagenes/iconos/newwindow.svg" alt="x" />
                                                    </span>
                                                </span>

                                                <?php if (isset($_SESSION['clientes'])) { ?>
                                                    <button style="background-color: #ee1305;" name="operacion" class="btn btn-sm" name="operacion" value="cancelar" id="cancelar">
                                                        <span><img src="../imagenes/iconos/cancel_venta.svg" alt="x" /></span>
                                                    </button>

                                                <?php } ?>
                                            </td>

                                        </tr>
                                    </table>

                                    <table class="table table-hover">
                                        <?php if (isset($_SESSION['clientes'])) { ?>
                                            <tr style="background-color: #133b5c;color: rgb(241, 245, 179); text-align: center !important; font-size: 0.9em;">
                                                <th style="text-align: center !important;">RUC</th>
                                                <th style="text-align: center !important;">CLIENTE</th>
                                                <th style="text-align: center !important;">TELEFONO</th>
                                                <th style="text-align: center !important;">EMAIL</th>
                                            </tr>
                                            <tr style="text-align: center; ">
                                                <td><?php echo $ruc; ?></td>
                                                <td><?php echo $nombrecliente . ' ' . $apellidocliente; ?></td>
                                                <td><?php echo $telefono; ?></td>
                                                <td><?php echo $email; ?></td>

                                            </tr>
                                        <?php } ?>
                                    </table>
                                </form>

                                <form action="modelo_ventas.php" method="post" class="form-group">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td style="text-align: center;"><label>PRODUCTO</label></td>
                                            <td><input type="text" class="form-control" name="producto" id="producto" placeholder="INGRESE CODIGO DEL PRODUCTO" autofocus></td>
                                            <td style="text-align: center;"><label>CANTIDAD</label></td>
                                            <td><input type="text" class="form-control" name="cantidad" id="cantidad"></td>

                                            <td colspan="2" style="text-align: center;">
                                                <button style="background-color: #90e925;" class="btn" name="operacion" value="buscarproducto" id="buscarproducto">
                                                    <img src="../imagenes/iconos/addcarrito.svg" alt="x" style="color: white;" />
                                                    <span class=""></span>
                                            </td>
                                        </tr>

                                    </table>
                                    <div style="overflow-y: scroll; height: 200px;">
                                        <table class="table table-bordered table-fixed" style="font-size: 0.9em;">

                                            <tr style="background-color: #046606;color: rgb(241, 245, 179); text-align: center !important; position: sticky; top: 0;">
                                                <th style="text-align: center;">Código</th>
                                                <th style="text-align: center;">Descripcion</th>
                                                <th style="text-align: center;">Precio</th>
                                                <th style="text-align: center;">Cantidad</th>
                                                <th style="text-align: center;">Iva</th>
                                                <th style="text-align: center;">SUBTOTAL</th>
                                                
                                            </tr>

                                            <?php foreach ($producto as $p) :
                                                $contador += 1;
                                                $subtotal = ($p->precio * $p->cantidadtipeada);



                                            ?>
                                                <tr>
                                                    <td style="text-align: center;"><?php echo strtoupper($p->id_producto); ?></td>
                                                    <td style="text-align: center;"><?php echo strtoupper($p->nombre); ?></td>
                                                    <td style="text-align: center;"><?php echo "Gs. " . ' ' . number_format($p->precio, 0, ",", "."); ?></td>
                                                    <td style="text-align: center;"><?php echo $p->cantidadingresada; ?>
                                                        <input type="text" name="cantidadfinal" id="cantidadfinal" value="<?php echo $p->cantidadingresada; ?>" hidden>
                                                    </td>

                                                    <?php
                                                    $iva_return = $p->iva;
                                                    $preciop = $p->precio;

                                                    if ($iva_return == 5) {
                                                        $iva = 0.05;
                                                    } else if ($iva_return == 10) {
                                                        $iva = 0.090909;
                                                    }
                                                    ?>
                                                    <td style="text-align: center;">
                                                        <?php echo "Gs. " . ' ' . number_format((($p->precio * $p->cantidadingresada) * $iva), 0, ",", "."); ?>
                                                    </td>
                                                    <td style="text-align: center;"><?php echo "Gs. " . ' ' . number_format((($p->precio * $p->cantidadingresada) - ($p->precio * $p->cantidadingresada) * $iva), 0, ",", "."); ?></td>
                                                    <input type="text" name="subtotal" id="subtotal" value="<?php echo $p->precio * $p->cantidadingresada; ?>" hidden>

                    
                                                </tr>




                                            <?php

                                                $total += $p->precio * $p->cantidadingresada;
                                                $imp_subtotal += (($p->precio * $p->cantidadingresada) - ((($p->precio * $p->cantidadingresada) * $iva_return) / 100));
                                                $imp_iva = $total - $imp_subtotal;

                                            endforeach; ?>




                                        </table>


                                    </div>
                                    <br>

                                    <td><label style="font-size: 1.2em;">Total</label></td>
                                    <td><input type="text" id="totalventa" name="totalventa" value="<?php echo $total; ?>" hidden>
                                        <label style="width: 30px;"> -- </label>
                                        <input type="text" style="font-size: 1.3em; background-color: #e2ece2; border-radius: 1px; width: 150px;" value="<?php echo 'Gs. ' . number_format($total, 0, ",", "."); ?>" readonly>
                                    </td>
                                    <label style="width: 10%;"></label>


                                    <td><label style="font-size: 1.2em;">Sub Total</label></td>
                                    <td><input type="text" id="subtotalventa" name="subtotalventa" value="<?php echo $imp_subtotal; ?>" hidden>
                                        <label style="width: 30px;"> -- </label>
                                        <input type="text" style="font-size: 1.3em; background-color: #e2ece2; border-radius: 1px; width: 150px;" value="<?php echo 'Gs. ' . number_format($imp_subtotal, 0, ",", "."); ?>">
                                    </td>
                                    <label style="width: 20%;"></label>


                                    <td><label style="font-size: 1.2em;">IVA</label></td>
                                    <td><input type="text" id="totaliva" name="totaliva" value="<?php echo $imp_iva; ?>" hidden>
                                        <label style="width: 30px;"> -- </label>
                                        <input type="text" style="font-size: 1.3em; background-color: #e2ece2; border-radius: 1px; width: 150px;" value="<?php echo 'Gs. ' . number_format($imp_iva, 0, ",", "."); ?>">
                                    </td>
                                    <p></p>

                                    <span style="background: linear-gradient(to left, #1390f2,#0575cc);" class="btn btn-sm">

                                        <span data-toggle="modal" data-target="#facturarmodal">
                                            <img src="../imagenes/iconos/vender.svg" alt="x" />
                                        </span>
                                    </span>

                                    <button class="btn" id="anularventa" name="operacion" value="anularventa" style="background: linear-gradient(#e71c0c,#eb3224)">
                                        <img src="../imagenes/iconos/remove_shopping_cart.svg" alt="x" />
                                    </button>
                                </form>








                            </div>
                        </div>
                    </div>


                    <script src="../js/clock.js"></script>



                    <!-- Modal facturar -->
                    <div class="modal fade" id="facturarmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="exampleModalLabel">Generar Venta</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">


                                    <div class="container">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-3">
                                                <div class="form-group">
                                                    <form action="modelo_ventas.php" method="post">

                                                        <div class="input-group">
                                                            <label for="">Forma de Pago</label>
                                                            <select name="pagoselect" id="pagoselect" required class="form-control">
                                                                <option value="efectivo">EFECTIVO</option>
                                                            </select>
                                                        </div>
                                                        <p></p>
                                                        <div class="input-group">
                                                            <label required class="">Total a Pagar</label>
                                                            <input name="totalapagar" id="totalapagar" type="text" required class="form-control" readonly>
                                                        </div>
                                                        <p></p>
                                                        <div class="input-group">
                                                            <label required class="">Monto</label>
                                                            <input name="monto" id="monto" type="text" required class="form-control" onkeyup="sumar();">

                                                        </div>
                                                        <p></p>
                                                        <div class="input-group">
                                                            <label required class="">Vuelto</label>
                                                            <input name="vuelto" id="vuelto" type="text" required class="form-control" readonly>

                                                        </div>


                                                        <input type="text" id="iva" name="iva" hidden>
                                                        <input type="text" id="subtotalmodal" name="subtotalmodal" hidden>
                                                        <input type="text" id="numerofact" name="numerofact" value="<?php echo ($mostrarconsulta + 1); ?>" hidden>

                                                        
                                                </div>
                                            <p></p>
                                                <button class="btn btn-primary" name="operacion" id="facturar" value="facturar" >Procesar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">

                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Nuevo cliente -->

                    <div class="modal fade" id="nuevoclientemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Nuevo Cliente</h4>
                                </div>
                                <div class="modal-body">


                                    <form id="frm_clientes">

                                        <label>Nombre</label>
                                        <input type="text" class="form-control input-sm" id="nombre" name="nombre">
                                        <label>Apellido</label>
                                        <input type="text" class="form-control input-sm" id="apellido" name="apellido">
                                        <label>Cedula / R.U.C</label>
                                        <input type="text" class="form-control input-sm" id="ruc" name="ruc">
                                        <label>Dirección</label>
                                        <input type="text" class="form-control input-sm" id="direccion" name="direccion">
                                        <label>Ciudad</label>
                                        <p></p>
                                        <select class="form-control input-sm" name="ciudad" id="ciudad" style="width: 190px;">
                                            <option value="A">Selecciona ciudad:</option>
                                            <?php
                                            require_once "../clases/Conexion.php";
                                            $c = new conectar();
                                            $conexion = $c->conexion();

                                            $sql = "SELECT c.idciudad,c.detalle,d.descripcion from ciudad c join departamentos d on c.id_departamento = d.iddepartamentos";
                                            $result = mysqli_query($conexion, $sql);
                                            while ($view = mysqli_fetch_row($result)) : ?>
                                                <option value="<?php echo $view[0] ?>"><?php echo $view[1] . ' - ' . $view[2]; ?></option>
                                            <?php endwhile; ?>
                                        </select>
                                        <p></p>
                                        <label>Email</label>
                                        <input type="text" class="form-control input-sm" id="email" name="email" placeholder="juan.perez@yahoo.com">
                                        <label>Telefono</label>
                                        <input type="text" class="form-control input-sm" id="telefono" name="telefono" pattern="[0-9]+" placeholder="Ingrese numeros sin espacios">
                                    </form>



                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="btnGuardar" class="btn btn-success" data-dismiss="modal">Guardar</button>
                                    <a href="ventas.php"> <span class="btn btn-danger">Cancelar</span></a>

                                </div>
                            </div>
                        </div>
                    </div>
                </body>

                </html>


                <script>
                    $(document).ready(function() {
            $('#btnGuardar').click(function() {

                $vacios = validarFormVacio('frm_clientes');


                if (vacios > 0) {
                    alertify.alert("No se permiten campos vacíos");
                    return false;
                }

                datos = $('#frm_clientes').serialize();
                $.ajax({

                    type: "POST",
                    data: datos,
                    url: "../procesos/clientes/nuevo_cliente.php",
                    success: function(r) {
                        

                        if (r == 1) {
                            alertify.success("Cliente Agregado");
                            $('#frm_clientes')[0].reset();

                        } else {
                            alertify.error("Error al agregar o Dato Duplicado");
                        }

                    }
                });
            });
        });
                </script>



                <script>
                    $(document).ready(function() {
                        const dato = "<?php echo $ruc ?>";
                        if (dato != "") {

                        } else {
                            $('#cicliente').focus();
                        }
                        document.getElementById('cantidad').value = 1;
                    });
                </script>


                <script>
                    $('#facturarmodal').on('shown.bs.modal', function() {

                        var totalapagar = document.getElementById("totalventa").value;
                        var iva = document.getElementById("totaliva").value;
                        var subtotal = document.getElementById("subtotalventa").value;
                        
                        document.getElementById("totalapagar").value = totalapagar;
                        document.getElementById("iva").value = iva;
                        document.getElementById("subtotalmodal").value = subtotal;
                        

                    })
                </script>


                <script>
                    function sumar() {
                       var monto = document.getElementById('monto').value;
                       var total = document.getElementById('totalapagar').value;
                        var vuelto = monto - total;
                        document.getElementById('vuelto').value = vuelto;
                        

                    }
                </script>




                <script>
                    formulario = document.querySelector('#for_venta');
                    formulario.cicliente.addEventListener('keypress', function(e) {
                        if (!soloNumeros(event)) {
                            alertify.alert("solo se permiten numeros");
                            e.preventDefault();
                        }
                    })

                    //Solo permite introducir numeros.
                    function soloNumeros(e) {

                        var key = e.charCode;
                        return key >= 48 && key <= 57;
                    }
                </script>


                

            <?php
                switch ($_GET['error']) {

                    case 1:
                        echo '<script language="Javascript">
                $("#cicliente").focus();
                alertify.alert("Debe ingresar cedula del cliente");
                </script>';

                        break;
                    case 2:

                        echo '<script language="Javascript">
                         $("#cicliente").focus();
                        alertify.alert("No existe cliente en la base de datos");
                        </script>';

                        break;

                    case 3:
                        echo '<script language="Javascript">
                         $("#producto").focus();
                        alertify.alert("Debe ingresar codigo del producto");
                        </script>';

                        break;

                    case 4:
                        echo '<script language="Javascript">
                             $("#producto").focus();
                            alertify.alert("No existe producto");
                            </script>';

                        break;
                }



                switch ($_GET['aviso']) {
                    case 1:
                        echo '<script language="Javascript">
            alertify.success("Cliente Seleccionado");
            </script>';

                        break;
                }
            } else {
                header("location:../index.php");
            }
            ?>