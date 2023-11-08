<?php


session_start();

if (isset($_SESSION['usuario'])) {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <script src="../js/funciones.js"></script>
        <link rel="shortcut icon" href="../imagenes/productos.png">
        <link rel="stylesheet" href="../librerias/datatables/css/dataTables.bootstrap.css">
        <link rel="stylesheet" href="../librerias/datatables/css/dataTables.bootstrap.min.css">

        <script src="../librerias/DataTables/js/jquery.dataTables.js"></script>
        <script src="../librerias/DataTables/js/dataTables.bootstrap.js"></script>
        <title>Productos</title>
        <?php require_once "menu.php"; ?>
        <?php require_once "../clases/Conexion.php";
        $c = new conectar();
        $conexion = $c->conexion();

        $sql = "Select * from categorias";
        $sqlupdate = "Select * from categorias";

        $result = mysqli_query($conexion, $sql);
        $update = mysqli_query($conexion, $sqlupdate);




        ?>
    </head>

    <body>
        <div class="col-sm-2">
            <div class="container">
                <div class="row">
                    <br>
                    <br>

                    <span class="btn btn-primary glyphicon" style="width: 190px; height: 44px; font-family:SANS-SERIF; font-size: 130%;" data-toggle="modal" data-target="#nuevoProducto">Agregar Nuevo</span>

                </div>
            </div>

        </div>

        <div class="col-sm-9">

            <div id="tablaProductosLoad" style="align-content:left;">

            </div>

        </div>

        <!-- MODAL PARA AGREGAR productos	-->

        <div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Productos</h4>
                    </div>
                    <div class="modal-body">


                        <form id="frm_productos" enctype="multipart/form-data">
                            <!--	<input type="text" id="idcategoria" name="idcategoria" hidden="">-->
                            <label>Descripcion</label>
                            <input type="text" class="form-control input-sm" id="descripcion" name="descripcion">
                            <label>Detalle</label>
                            <input type="text" class="form-control input-sm" id="detalle" name="detalle">
                            <label>Categoria</label>
                            <select class="form-control input-sm" name="categoria_select" id="categoria_select">

                                <option value="A">Seleccionar Categoria:</option>
                                <?php while ($view = mysqli_fetch_row($update)) : ?>
                                    <option value="<?php echo $view[0] ?>"><?php echo $view[2]; ?></option>
                                <?php endwhile; ?>
                            </select>
                            <label>Imagen</label>
                            <input type="file" id="imagen" name="imagen">
                            <label>Stock</label>
                            <input type="text" class="form-control input-sm" id="stock" name="stock" value="0" disabled>
                            <label>Precio</label>
                            <input type="text" class="form-control input-sm" id="precio" name="precio">
                            <label>IVA</label>
                            <select class="form-control input-sm" name="iva_select" id="iva_select">
                                <option value="A">Seleccionar IVA:</option>
                                <option value="5">5%</option>
                                <option value="10">10%</option>
                            </select>

                        </form>



                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnAgregaProductos" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                        <a href="productos.php"> <span class="btn btn-danger">Cancelar</span></a>

                    </div>
                </div>
            </div>
        </div>

        <!-- *************************************************************************
**************************************************************************
********************************
MODAL PARA ACTUALIZAR PRODUCTOS   -->

        <div class="modal fade" id="actualizaProductos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Actualiza Productos</h4>
                    </div>
                    <div class="modal-body">
                        <form id="frm_productosupdates">
                            <input type="text" hidden="" id="idproducto" name="idproducto">
                            <label>Descripcion</label>
                            <input type="text" class="form-control input-sm" id="descripcionupdate" name="descripcionupdate">
                            <label>Detalle</label>
                            <input type="text" class="form-control input-sm" id="detalleupdate" name="detalleupdate">
                            <label>Categoria</label>
                            <select class="form-control input-sm" name="categoria_selectupdate" id="categoria_selectupdate">

                                <option value="A">Seleccionar Categoria:</option>
                                <?php while ($ver = mysqli_fetch_row($result)) : ?>
                                    <option value="<?php echo $ver[0] ?>"><?php echo $ver[2]; ?></option>
                                <?php endwhile; ?>
                            </select>

                            <label>Stock</label>
                            <input type="text" class="form-control input-sm" id="stockupdate" name="stockupdate" value="0" disabled>
                            <label>Precio</label>
                            <input type="text" class="form-control input-sm" id="precioupdate" name="precioupdate">
                            <label>IVA</label>
                            <select class="form-control input-sm" name="iva_selectupdate" id="iva_selectupdate">
                                <option value="A">Seleccionar IVA:</option>
                                <option value="5">5%</option>
                                <option value="10">10%</option>
                            </select>

                        </form>



                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnActualizaProductos" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                        <a href="productos.php"><span class="btn btn-danger">Cancelar</span></a>

                    </div>
                </div>
            </div>
        </div>


    </body>

    </html>



    <script type="text/javascript">
        $(document).ready(function() {
            $('#tablaProductosLoad').load("productos/table_productos.php");
            $('#btnAgregaProductos').click(function() {
                $vacios = validarFormVacio('frm_productos');


                if (vacios > 0) {
                    alertify.alert("No se permiten campos vacíos");
                    return false;
                }

                var formData = new FormData(document.getElementById("frm_productos"));

                $.ajax({
                    url: "../procesos/productos/insert_file.php",
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: function(r) {

                        $('#frm_productos')[0].reset();
                        $('#tablaProductosLoad').load("productos/table_productos.php");
                        alertify.success("Agregado con exito");

                    }
                });

            });

        });
    </script>


    <script>
        function agregadatoproducto(idproducto) {
            $.ajax({
                type: "POST",
                data: "idproducto=" + idproducto,
                url: "../procesos/productos/obtenerdatos.php",
                success: function(r) {

                    dato = jQuery.parseJSON(r);

                    $('#idproducto').val(dato['id_producto']);
                    $('#categoria_selectupdate').val(dato['id_categoria']);
                    $('#descripcionupdate').val(dato['nombre']);
                    $('#detalleupdate').val(dato['descripcion']);
                    $('#stockupdate').val(dato['cantidad']);
                    $('#precioupdate').val(dato['precio']);
                    $('#iva_selectupdate').val(dato['iva']);

                }
            });
        }
    </script>


    <script>
        $(document).ready(function() {

            $('#btnActualizaProductos').click(function() {
                datos = $('#frm_productosupdates').serialize();

                $.ajax({
                    type: "POST",
                    data: datos,
                    url: "../procesos/productos/actualizarproductos.php",
                    success: function(r) {
                        if (r == 1) {
                            alertify.success("Registro Actualizado");
                            $('#tablaProductosLoad').load("productos/table_productos.php");
                            $('#frm_productosupdates')[0].reset();



                        } else {
                            alertify.error("Error al Actualizar");
                        }

                    }
                });

            });

        });
    </script>


<script>

function eliminaProducto(idproducto) {
            alertify.confirm('¿Desea eliminar?', function() {
                $.ajax({
                    type: "POST",
                    data: "idproducto=" + idproducto,
                    url: "../procesos/productos/eliminarproducto.php",
                    success: function(r) {
                        if (r == 1) {
                            $('#tablaProductosLoad').load("productos/table_productos.php");
                            alertify.success("Eliminado con exito!!");
                        } else {
                            alertify.error("No se pudo eliminar");
                        }
                    }
                });
            }, function() {
                alertify.error('Cancelo !')
            });

        }
</script>


<?php
} else {
    header("location:../index.php");
}
?>