<?php


session_start();

if (isset($_SESSION['usuario'])) {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <script src="../js/funciones.js"></script>
        <link rel="shortcut icon" href="../imagenes/clientes.png">
        <title>Clientes</title>
        <?php require_once "menu.php";
         require_once "../clases/Conexion.php";
        $c = new conectar();
        $conexion = $c->conexion();

        $sql = "SELECT c.idciudad,c.detalle,d.descripcion from ciudad c join departamentos d on c.id_departamento = d.iddepartamentos";
        $result = mysqli_query($conexion, $sql);
        $result2 = mysqli_query($conexion, $sql);
        
        ?>
    </head>

    <body>
        <div class="col-sm-2">
            <div class="container">
                <div class="row">
                    <br>
                    <br>
                   <!-- data-toggle="modal" data-target="#nuevocliente" -->

                    <span class="btn btn-primary" style="width: 190px; height: 44px;" 
                    id="nuevocliente" name="nuevocliente" >Nuevo Cliente</span>

                </div>
            </div>

        </div>

        <div class="col-sm-9">

            <div id="tablaClientesLoad" style="align-content:left;">

            </div>

        </div>

        <!-- MODAL PARA AGREGAR NUEVO CLIENTE	-->

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
                                <?php while ($view = mysqli_fetch_row($result2)) : ?>
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
                        <a href="clientes.php"> <span class="btn btn-danger">Cancelar</span></a>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="nuevoclientemodalupdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Actualizar Cliente</h4>
                    </div>
                    <div class="modal-body">


                        <form id="frm_clientesupdate">
                            <input type="text" id="idclientes" name="idclientes" hidden>
                            <label>Nombre</label>
                            <input type="text" class="form-control input-sm" id="nombreupdate" name="nombreupdate">
                            <label>Apellido</label>
                            <input type="text" class="form-control input-sm" id="apellidoupdate" name="apellidoupdate">
                            <label>Cedula / R.U.C</label>
                            <input type="text" class="form-control input-sm" id="rucupdate" name="rucupdate">
                            <label>Dirección</label>
                            <input type="text" class="form-control input-sm" id="direccionupdate" name="direccionupdate">
                            <label>Ciudad</label>
                            <p></p>
                            <select class="form-control input-sm" name="ciudadupdate" id="ciudadupdate" style="width: 190px;">
                                <option value="A">Selecciona ciudad:</option>
                                <?php while ($view = mysqli_fetch_row($result)) : ?>
                                    <option value="<?php echo $view[0] ?>"><?php echo $view[1] . ' - ' . $view[2]; ?></option>
                                <?php endwhile; ?>
                            </select>
                            <p></p>
                            <label>Email</label>
                            <input type="text" class="form-control input-sm" id="emailupdate" name="emailupdate" placeholder="juan.perez@yahoo.com">
                            <label>Telefono</label>
                            <input type="text" class="form-control input-sm" id="telefonoupdate" name="telefonoupdate" pattern="[0-9]+" placeholder="Ingrese numeros sin espacios">
                        </form>



                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnActualizar" class="btn btn-success" data-dismiss="modal">Guardar</button>
                        <a href="clientes.php"> <span class="btn btn-danger">Cancelar</span></a>

                    </div>
                </div>
            </div>
        </div>


    </body>

    </html>

<script>
    //al dar click en el boton, se desplega el modal y el focus() va al primer input del form

    $('#nuevocliente').click(function(){
    $('#nuevoclientemodal').modal('show');
    $('#nuevoclientemodal').on('shown.bs.modal', function () {
    $('#nombre').focus();
                }) 
    });


    

    $(document).ready(function() {
            $('#ciudad').select2({
                dropdownParent: $('#nuevoclientemodal')
            });
            
        });

    $(document).ready(function(){
        $('#ciudadupdate').select2({
                dropdownParent: $('#nuevoclientemodalupdate')
            });
    });


//funcion para limitar cantidad de caracteres
        var caja = document.getElementById("ruc"),
        limite = 10;
 
        caja.onkeypress = function(e){
        var cantidadActual = this.value.length;
        if (cantidadActual == limite - 1)
        alertify.alert("Ya alcanzó el límite de caracteres");
        $('#ruc').focus();
        
        if (cantidadActual >= limite)
        e.preventDefault();};

        var caja = document.getElementById("rucupdate"),
        limite = 10;
 
        caja.onkeypress = function(e){
        var cantidadActual = this.value.length;
        if (cantidadActual == limite - 1)
        alertify.alert("Ya alcanzó el límite de caracteres");
        $('#rucupdate').focus();
        
        if (cantidadActual >= limite)
        e.preventDefault();};

//funcion jquery para permitir solo numeros
        jQuery(document).ready(function(){
	    jQuery("#telefono").on('input', function (evt) {
		jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));

	});
});

jQuery(document).ready(function(){
	    jQuery("#telefonoupdate").on('input', function (evt) {
		jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));

	});
});


//



</script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#tablaClientesLoad').load("clientes/table_clientes.php");
            $('#btnGuardar').click(function() {

            if($("#email").val().indexOf('@', 0) == -1 || $("#email").val().indexOf('.', 0) == -1) {
            alertify.alert('El correo electrónico introducido no es correcto.');
            return false;
            
        }

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
                            alertify.success("Registro Añadido");
                          $('#tablaClientesLoad').load("clientes/table_clientes.php");
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
        function agregadato(idcliente) {
            $.ajax({
                type: "POST",
                data: "idcliente=" + idcliente,
                url: "../procesos/clientes/obtenerdatos.php",
                success: function(r) {

                    dato = jQuery.parseJSON(r);

                    $('#idclientes').val(dato['idclientes']);
                    $('#nombreupdate').val(dato['nombre']);
                    $('#apellidoupdate').val(dato['apellido']);
                    $('#rucupdate').val(dato['cedula']);
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

            $('#btnActualizar').click(function() {

                datos = $('#frm_clientesupdate').serialize();
                $.ajax({
                    type: "POST",
                    data: datos,
                    url: "../procesos/clientes/update_cliente.php",
                    success: function(r) {


                        if (r == 1) {
                            alertify.success("Registro Actualizado");
                            $('#tablaClientesLoad').load("clientes/table_clientes.php");


                        } else {
                            alertify.error("Error al Actualizar");
                        }

                    }
                });
            });


        });
    </script>


    <script>
        function eliminacliente(idcliente) {
            alertify.confirm('¿Desea eliminar?', function() {
                $.ajax({
                    type: "POST",
                    data: "idcliente=" + idcliente,
                    url: "../procesos/clientes/eliminarclientes.php",
                    success: function(r) {
                        if (r == 1) {
                            $('#tablaClientesLoad').load("clientes/table_clientes.php");
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