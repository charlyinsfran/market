<?php


session_start();

if (isset($_SESSION['usuario'])) {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <script src="../js/funciones.js"></script>
        <title>Categorias</title>
        <?php require_once "menu.php";
        /*date_default_timezone_set('America/Asuncion');
                $date = date("d-m-Y h:i:s");


                echo $date;*/
        ?>
    </head>

    <body>
        <div class="col-sm-2">
            <div class="container">
                <div class="row">
                    <br>
                    <br>

                    <span class="btn btn-primary glyphicon glyphicon-plus" style="width: 190px; height: 44px;" data-toggle="modal" data-target="#nuevaCategoria">Agregar Nuevo</span>

                </div>
            </div>

        </div>

        <div class="col-sm-9">

            <div id="tablaCategoriaLoad" style="align-content:left;">

            </div>

        </div>

        <!-- MODAL PARA AGREGAR NUEVA CATEGORIA	-->

        <div class="modal fade" id="nuevaCategoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Nueva Categoria</h4>
                    </div>
                    <div class="modal-body">


                        <form id="frm_categorias">
                            <!--	<input type="text" id="idcategoria" name="idcategoria" hidden="">-->
                            <label>Descripcion</label>
                            <input type="text" class="form-control input-sm" id="categoria" name="categoria">
                        </form>



                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnAgregaCategoria" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                        <a href="categorias.php"> <span class="btn btn-danger">Cancelar</span></a>

                    </div>
                </div>
            </div>
        </div>

        <!-- *************************************************************************
**************************************************************************
********************************
MODAL PARA ACTUALIZAR CATEGORIAS                                     -->

        <div class="modal fade" id="actualizaCategorias" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Actualiza Ciudades</h4>
                    </div>
                    <div class="modal-body">
                        <form id="frm_CategoriasUpdates">
                            <input type="text" hidden="" id="idcategoriaold" name="idcategoriaold">
                            <label>Ciudad</label>
                            <input type="text" id="categoriaupdate" name="categoriaupdate" class="form-control input-sm">
                            <p></p>
                        </form>


                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnActualizaCategoria" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                        <a href="categorias.php"><span class="btn btn-danger">Cancelar</span></a>

                    </div>
                </div>
            </div>
        </div>


    </body>

    </html>



    <script type="text/javascript">
        $(document).ready(function() {
            $('#tablaCategoriaLoad').load("categorias/table_categorias.php");
            $('#btnAgregaCategoria').click(function() {

                $vacios = validarFormVacio('frm_categorias');


                if (vacios > 0) {
                    alertify.alert("No se permiten campos vacíos");
                    return false;
                }

                datos = $('#frm_categorias').serialize();
                $.ajax({

                    type: "POST",
                    data: datos,
                    url: "../procesos/categorias/agregacategorias.php",
                    success: function(r) {

                        if (r == 1) {
                            alertify.success("Registro Añadido");
                            $('#tablaCategoriaLoad').load("categorias/table_categorias.php");
                            $('#frm_categorias')[0].reset();

                        } else {
                            alertify.error("Error al agregar o Dato Duplicado");
                        }

                    }
                });
            });
        });
    </script>



    <script>
        function agregaDato(idcategoria, descripcion) {
            $('#idcategoriaold').val(idcategoria);
            $('#categoriaupdate').val(descripcion);

        }
        
    </script>

<SCript>
    $(document).ready(function() {

$('#btnActualizaCategoria').click(function() {

    datos = $('#frm_CategoriasUpdates').serialize();
    $.ajax({
        type: "POST",
        data: datos,
        url: "../procesos/categorias/actualizacategorias.php",
        success: function(r) {


            if (r == 1) {
                alertify.success("Registro Actualizado");
                $('#tablaCategoriaLoad').load("categorias/table_categorias.php");
              

            } else {
                alertify.error("Error al Actualizar");
            }

        }
    });
});


});
</SCript>





<?php
} else {
    header("location:../index.php");
}
?>