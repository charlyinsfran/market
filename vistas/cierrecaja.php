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
        <link rel="shortcut icon" href="../imagenes/cierre-caja.png">
        <link rel="stylesheet" href="../librerias/bootstrap/css/bootstrap.css">
        <link rel="stylesheet" href="../librerias/datatables/css/dataTables.bootstrap.css">
        <link rel="stylesheet" href="../librerias/datatables/css/dataTables.bootstrap.min.css">

        <script src="../librerias/DataTables/js/jquery.dataTables.js"></script>
        <script src="../librerias/DataTables/js/dataTables.bootstrap.js"></script>

        <title>Cierre Caja</title>
        <?php require_once "menu.php";
         require_once "../clases/Conexion.php";
         $c = new conectar();
         $conexion = $c->conexion();
 
         $sql = "SELECT idcontrol_caja,aperturamonto,fec_hora_apertura from control_caja order by idcontrol_caja desc limit 1";
         $result = mysqli_query($conexion, $sql);
         $vista =  mysqli_fetch_row($result);
         $apertura = $vista[1];
         $horaapertura = $vista[2];
         $codigo = $vista[0];

        
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

        <!-- MODAL PARA AGREGAR NUEVA CATEGORIA	-->

        <div class="modal fade" id="cierrecaja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title" id="myModalLabel">Cierre Caja</h4>
                    </div>
                    <div class="modal-body">


                        <form id="frm_cierre" style="text-align: center;" method="POST" action="../procesos/apertura_cierre_caja/cierrecaja.php">
                            
                        <input type="text" value="<?php echo $codigo; ?>" hidden id="codigo" name="codigo">
                        <label style="font-size: 1.1em; font-family: 'Trebuchet MS', sans-serif;">User</label>
                            <input type="text" class="form-control input-sm" value="<?php echo $_SESSION['usuario'] ?>" style="font-size: 1.2em; text-align:center; font-family: 'Trebuchet MS', sans-serif;" readonly id="usuario" name="usuario">
                            <p></p>
                            <label style="font-size: 1.2em; font-family: 'Trebuchet MS', sans-serif;">Fecha-Hora Apertura</label>
                            <input type="text" class="form-control input-sm" value="<?php echo $horaapertura; ?>" 
                            style="font-size: 1.2em; font-family: 'Trebuchet MS', sans-serif; text-align:center;" readonly id="fecha" name="fecha">
                            <p></p>
                            <label style="font-size: 1.2em; font-family: 'Trebuchet MS', sans-serif; ">Monto Apertura</label>
                            <input type="text" class="form-control input-sm" style="font-size: 1.3em; font-family: 'Trebuchet MS', sans-serif; height: 35px; text-align:center;"
                             id="montoapertura" name="montoapertura" readonly value="<?php echo $apertura;?>">

                             <label style="font-size: 1.2em; font-family: 'Trebuchet MS', sans-serif; ">Monto</label>
                            <input type="text" class="form-control input-sm" onkeyup="" 
                            onchange="" style=" text-align:center; font-size: 1.3em; font-family: 'Trebuchet MS', sans-serif; height: 35px;"
                             id="montocierre" name="montocierre">

                             <label style="font-size: 1.2em; font-family: 'Trebuchet MS', sans-serif;">Fecha-Hora</label>
                            <input type="text" class="form-control input-sm" value="<?php date_default_timezone_set('America/Asuncion');
                                                                                    $fecha = date('Y-m-d H:i:s');
                                                                                    echo $fecha ?>" 
                            style="font-size: 1.2em; font-family: 'Trebuchet MS', sans-serif; text-align:center;" 
                            name="fechacierre" id="fechacierre" readonly>

                            <label style="font-size: 1.2em; font-family: 'Trebuchet MS', sans-serif;">Diferencia</label>
                            <input type="text" class="form-control input-sm" 
                            style="font-size: 1.2em; font-family: 'Trebuchet MS', sans-serif; text-align:center; background-color: #4ad16f;" 
                            name="diferencia" id="diferencia" readonly>

                            <p></p>




                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btncerrarcaja" class="btn" data-dismiss="modal" style="background-color: #ff4b03;">
                            <img src="../imagenes/iconos/cerrarcaja.svg" alt="x" />
                            <label style="font-size: 15px; color: white;" > Cerrar Caja</label></button>


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

    <script>

        //funcion que realiza la resta del monto de la apertura con el cierre, en tiempo real
        $('#montocierre').keyup(function () {
        var valorinicial = document.getElementById('montoapertura').value;
        var valor_restar = 0;
        $('#montocierre').each(function () {
          if ($(this).val() > 0) {
            valor_restar += $(this).val();
          }
        });
            
        $('#diferencia').val((valor_restar) - (valorinicial*1000));
              
    });
    </script>

    <script type="text/javascript">

        $(document).ready(function() {

            $("#cierrecaja").modal("show");
            $("#cierrecaja").on('shown.bs.modal', function(){
                $("#montocierre").focus();
            });
            
            $("#cierrecaja").modal({
                backdrop: 'static'
            });

            $('#btncerrarcaja').click(function() {

                $vacios = validarFormVacio('frm_cierre');


                if (vacios > 0) {
                    alertify.alert("No se permiten campos vacíos");
                    return false;
                }

                datos = $('#frm_cierre').serialize();
                $.ajax({

                    type: "POST",
                    data: datos,
                    url: "../procesos/apertura_cierre_caja/cierrecaja.php",

                    success: function(r) {
                        console.log(r);
                        if (r == 1) {

                            window.location = "../procesos/salir.php";

                        } else {
                            alertify.error("Error al agregar o Dato Duplicado");
                            window.location = "cerrarcaja.php";

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