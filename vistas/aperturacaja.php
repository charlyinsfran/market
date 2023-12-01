<?php


session_start();

if (isset($_SESSION['usuario'])) {
    if($_SESSION['tipousuario'] != "admin"){

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <script src="../js/funciones.js"></script>
        <link rel="shortcut icon" href="../imagenes/apertura-caja.png">
        <link rel="stylesheet" href="../librerias/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="../librerias/datatables/css/dataTables.bootstrap.css">
        <link rel="stylesheet" href="../librerias/datatables/css/dataTables.bootstrap.min.css">

        <script src="../librerias/DataTables/js/jquery.dataTables.js"></script>
        <script src="../librerias/DataTables/js/dataTables.bootstrap.js"></script>

        <title>Apertura Caja - DCHR_SOFT</title>
        <?php require_once "menu.php";

        ?>
    </head>

    <body>
        <style>
            .montomoneda1 {
                width: 80px;
                color: #9b9b9b;
                position: absolute;
                left: 180px;
                margin-top: -30px;
            }
        </style>
        <div class="col-sm-2">
            <div class="container">
                <div class="row">


                </div>
            </div>

        </div>

        <div class="col-sm-9" style="height: 100px;">

            <div id="tablaapertura" style="align-content:left;">

            </div>

        </div>

        <!-- 	-->

        <div class="modal fade" id="aperturacaja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title" id="myModalLabel">Apertura Caja</h4>
                    </div>
                    <div class="modal-body">


                        <form id="frm_aperturacaja" style="text-align: center;" method="POST" action="../procesos/apertura_cierre_caja/aperturacaja.php">
                            <label style="font-size: 1.2em; font-family: 'Trebuchet MS', sans-serif;">User</label>
                            <input type="text" class="form-control input-sm" value="<?php echo $_SESSION['usuario'] ?>" style="font-size: 1.5em; font-family: 'Trebuchet MS', sans-serif;" readonly id="usuario" name="usuario">
                            <p></p>
                            <label style="font-size: 1.2em; font-family: 'Trebuchet MS', sans-serif;">FECHA / HORA</label>
                            <input type="text" class="form-control input-sm" value="<?php date_default_timezone_set('America/Asuncion');
                                                                                    $fecha = date('Y-m-d H:i:s');
                                                                                    echo $fecha ?>" style="font-size: 1.5em; font-family: 'Trebuchet MS', sans-serif;" readonly id="fecha" name="fecha">
                            <p></p>
                            <label style="font-size: 1.2em; font-family: 'Trebuchet MS', sans-serif; ">Monto</label>
                            <input type="text" class="form-control input-sm" onkeyup="format(this)" onchange="format(this)"
                             style="font-size: 1.3em; font-family: 'Trebuchet MS', sans-serif; height: 35px;" id="montototal" name="montototal">


                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnabrircaja" class="btn btn-primary" data-dismiss="modal">
                            <img src="../imagenes/iconos/checkaperturacaja.svg" alt="x" />
                            <label> Abrir Caja</label></button>


                    </div>
                </div>
            </div>
        </div>



    </body>

    </html>

    <script>
        function format(input) {
            var num = input.value.replace(/\./g, '');
            if (!isNaN(num)) {
                num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g, '$1.');
                num = num.split('').reverse().join('').replace(/^[\.]/, '');
                input.value = num;
            } else {
                alertify.alert('Solo se permiten numeros');
                input.value = input.value.replace(/[^\d\.]*/g, '');
            }
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#aperturacaja").modal("show");
            $("#aperturacaja").on('shown.bs.modal', function(){
                $("#montototal").focus();
            });
            $("#aperturacaja").modal({
                backdrop: 'static'
            });

            $('#btnabrircaja').click(function() {

                $vacios = validarFormVacio('frm_aperturacaja');


                if (vacios > 0) {
                    $('#montototal').focus();
                    alertify.alert("No se permiten campos vacíos");
                    
                    return false;
                }

                datos = $('#frm_aperturacaja').serialize();
                $.ajax({

                    type: "POST",
                    data: datos,
                    url: "../procesos/apertura_cierre_caja/aperturacaja.php",

                    success: function(r) {
                        console.log(r);
                        if (r == 1) {

                            window.location = "inicio.php";

                        } else {
                            alertify.error("Error al agregar o Dato Duplicado");
                        }

                    }
                });
            });
        });
    </script>



<?php
} else {
    header("location:inicio.php");
}

}
?>