<?php
session_start();
if (isset($_SESSION['usuario'])) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <script src="../js/funciones.js"></script>
        <link rel="shortcut icon" href="../imagenes/categorizacion.png">
        <link rel="stylesheet" href="../librerias/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="../librerias/datatables/css/dataTables.bootstrap.css">
        <link rel="stylesheet" href="../librerias/datatables/css/dataTables.bootstrap.min.css">

        <script src="../librerias/DataTables/js/jquery.dataTables.js"></script>
        <script src="../librerias/DataTables/js/dataTables.bootstrap.js"></script>

        <title>Anular Venta</title>

        <?php require_once "menu.php";
        ?>
    </head>

    <body>


        <!-- MODAL -->

        <div class="modal fade" id="anularventa" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document" style="width: 500px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Anular Venta</h4>
                    </div>
                    <div class="modal-body">


                        <form id="frm_anulacion">

                            <label>Nro de Factura</label>
                            <input type="text" class="form-control input-sm" id="nrofactura" name="nrofactura" style="width: 80%; font-size: 1.2em;" placeholder="ultimos digitos del ticket">
                            <p></p>
                            <label>Codigo de Anulacion</label>
                            <input type="password" class="form-control input-sm" id="codanulacion" name="codanulacion" style="width: 70%; font-size: 1.2em;">
                        </form>



                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnAnular" class="btn btn-primary" data-dismiss="modal">Procesar</button>
                        <a href="anularventa.php"><span class="btn btn-danger">Cancelar</span></a>
                        <a href="ventas.php"> <span class="btn btn-success">Nueva Venta</span></a>

                    </div>
                </div>
            </div>
        </div>



    </body>

    </html>



    <script>
        $(document).ready(function() {
            $("#anularventa").modal("show");
            $("#anularventa").on('shown.bs.modal', function() {
                $("#nrofactura").focus();
            });
            $("#anularventa").modal({
                backdrop: 'static'
            });

            $('#btnAnular').click(function() {

                alertify.confirm('¿Desea Anular esta venta?', function() {

                    $vacios = validarFormVacio('frm_anulacion');


                    if (vacios > 0) {
                        
                        alertify.alert("Nro de Factura necesario");
                        return false;
                    }

                    datos = $('#frm_anulacion').serialize();
                    $.ajax({

                        type: "POST",
                        data: datos,
                        url: "../procesos/anulaciones/cancel_venta.php",

                        success: function(r) {
                            if (r == 1) {
                                
                                alertify.success("Venta Anulada");
                                window.location = "anularventa.php";
                            } else {
                                alertify.confirm("Codigo de Anulacion incorrecto",
                                    function() {
                                     window.location = "anularventa.php";
                                    });
                            }

                        }
                    });

                }, function() {
                    alertify.error('Cancel')
                    window.location.reload();
                });

            });



        });
    </script>

<?php
} else {
    header("location:../index.php");
}
?>