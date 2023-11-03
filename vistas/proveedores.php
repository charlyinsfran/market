<?php


session_start();
if (isset($_SESSION['usuario'])) {




?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="../imagenes/proveedores.png">
        <title>Proveedores</title>
        <?php require_once "menu.php"; ?>
        <?php require_once "../clases/Conexion.php";
        $c = new conectar();
        $conexion = $c->conexion();

        $sql = "SELECT c.idciudad,c.detalle,d.descripcion from ciudad c join departamentos d on c.id_departamento = d.iddepartamentos";
        $result = mysqli_query($conexion, $sql);





        ?>
    </head>

    <body>

        <div class="col-sm-2">
            <div class="container">
                <div class="row">
                    <br>
                    <br>

                    <span class="btn btn-primary glyphicon glyphicon-plus" style="width: 190px; height: 44px;" 
                    data-toggle="modal" data-target="#nuevoproveedor"> Nuevo</span>

                </div>
            </div>

        </div>

        <div class="col-sm-9">

            <div id="tablaProveedoresLoad" style="align-content:left;">

            </div>

        </div>





        <div class="modal fade" id="nuevoproveedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Nuevo Proveedor</h4>
                    </div>
                    <div class="modal-body">


                        <form id="frm_proveedores">
                            <!--	<input type="text" id="idproveedor" name="idproveedor" hidden="">-->
                            <label>Razon Social</label>
                            <input type="text" class="form-control input-sm" id="razon_social" name="razon_social" onkeyup="mayus(this);">

                            <label>R.U.C</label>
                            <input type="text" class="form-control input-sm" id="ruc" name="ruc" minlength="1" maxlength="12">
                            <label>Dirección</label>
                            <input type="text" class="form-control input-sm" id="direccion" name="direccion">
                            <label>Ciudad</label>
                            <p></p>
                            <select name="ciudad" id="ciudad" class="form-control input-sm" style="width: 190px;">
                                <option value="A">Seleccionar ciudad:</option>
                                <?php while ($view = mysqli_fetch_row($result)) : ?>
                                    <option value="<?php echo $view[0] ?>"><?php echo $view[1] . ' - ' . $view[2]; ?></option>
                                <?php endwhile; ?>
                            </select>
                            <p></p>
                            <label>Correo</label>
                            <input type="text" class="form-control input-sm" id="email" name="email">
                            <label>Telefono</label>
                            <input type="text" minlength="1" maxlength="12" class="form-control input-sm" id="telefono" name="telefono">

                        </form>



                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnNuevoProveedor" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                        <a href="proveedores.php"> <span class="btn btn-danger">Cancelar</span></a>

                    </div>
                </div>
            </div>
        </div>



        <!-- modal para actualizar datos del proveedor -->


        <div class="modal fade" id="actualizaproveedor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Nuevo Proveedor</h4>
                    </div>
                    <div class="modal-body">


                        <form id="frm_proveedoresupdate">
                            	<input type="text" id="idproveedor" name="idproveedor" hidden="">
                            <label>Razon Social</label>
                            <input type="text" class="form-control input-sm" id="razon_socialupdate" name="razon_socialupdate" onkeyup="mayus(this);">

                            <label>R.U.C</label>
                            <input type="text" class="form-control input-sm" id="rucupdate" name="rucupdate" minlength="1" maxlength="12">
                            <label>Dirección</label>
                            <input type="text" class="form-control input-sm" id="direccionupdate" name="direccionupdateupdate">
                            <label>Ciudad</label>
                            <p></p>
                            <select name="ciudadupdate" id="ciudadupdate" class="form-control input-sm" style="width: 190px;">
                                <option value="A">Seleccionar ciudad:</option>
                                <?php
                                 $sqle = "SELECT c.idciudad,c.detalle,d.descripcion from ciudad c join departamentos d on c.id_departamento = d.iddepartamentos";
                                 $resulta = mysqli_query($conexion, $sqle);
                         
                                
                                while ($view = mysqli_fetch_row($resulta)) : ?>
                                    <option value="<?php echo $view[0] ?>"><?php echo $view[1] . ' - ' . $view[2]; ?></option>
                                <?php endwhile; ?>
                            </select>
                            <p></p>
                            <label>Correo</label>
                            <input type="text" class="form-control input-sm" id="emailupdate" name="emailupdate">
                            <label>Telefono</label>
                            <input type="text" minlength="1" maxlength="12" class="form-control input-sm" id="telefonoupdate" name="telefonoupdate">

                        </form>



                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnActualizaProveedor" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                        <a href="proveedores.php"> <span class="btn btn-danger">Cancelar</span></a>

                    </div>
                </div>
            </div>
        </div>
        <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////-->

    </body>

    </html>
<script type="text/javascript">
        $(document).ready(function() {
            $('#tablaProveedoresLoad').load("proveedores/tablaproveedores.php");
            $('#btnNuevoProveedor').click(function() {

                $vacios = validarFormVacio('frm_proveedores');


                if (vacios > 0) {
                    alertify.alert("No se permiten campos vacíos");
                    return false;
                }

                datos = $('#frm_proveedores').serialize();
                $.ajax({

                    type: "POST",
                    data: datos,
                    url: "../procesos/proveedores/new_proveedor.php",
                    success: function(r) {

                        if (r == 1) {
                            alertify.success("Registro Añadido");
                            $('#tablaProveedoresLoad').load("proveedores/tablaproveedores.php");
                            $('#frm')[0].reset();

                        } else {
                            alertify.error("Error al agregar o Dato Duplicado");
                        }

                    }
                });
            });
        });

</script>

<script>
    function agregadatoproveedor(idproveedor) {
            $.ajax({
                type: "POST",
                data: "idproveedor=" + idproveedor,
                url: "../procesos/proveedores/obtenerdatos.php",
                success: function(r) {

                    dato = jQuery.parseJSON(r);

                    $('#idproveedor').val(dato['idproveedores']);
                    $('#razon_socialupdate').val(dato['razon_social']);
                    $('#rucupdate').val(dato['ruc']);
                    $('#direccionupdate').val(dato['direccion']);
                    $('#ciudadupdate').val(dato['id_ciudad']);
                    $('#emailupdate').val(dato['email']);
                    $('#telefonoupdate').val(dato['telefono']);

                }
            });
        }
</script>

<script>
    $(document).ready(function() {

$('#btnActualizaProveedor').click(function() {
    datos = $('#frm_proveedoresupdate').serialize();

    $.ajax({
        type: "POST",
        data: datos,
        url: "../procesos/proveedores/update_proveedor.php",
        success: function(r) {

            
            if (r == 1) {
                alertify.success("Registro Actualizado");
                $('#tablaProveedoresLoad').load("proveedores/tablaproveedores.php");
                $('#frm_proveedoresupdate')[0].reset();



            } else {
                alertify.error("Error al Actualizar");
            }

        }
    });

});

});
</script>

    <script>
        function mayus(e) {
            e.value = e.value.toUpperCase();
        }

        $(document).ready(function() {
            $('#ciudad').select2({
                dropdownParent: $('#nuevoproveedor')
            });
            $('#ciudadupdate').select2({
                dropdownParent: $('#actualizaproveedor')
            });


        });
    </script>

<?php
} else {
    header("location:../index.php");
}
?>