<?php


session_start();

if(isset($_SESSION['usuario'])){

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagenes/almacenes.png">
    <title>Stock</title>
    <?php require_once "menu.php";?>
    <?php require_once "../clases/Conexion.php";
        $c = new conectar();
        $conexion = $c->conexion();

        $sql = "SELECT id_producto,nombre,cantidad,precio,iva FROM productos";

        $result = mysqli_query($conexion, $sql);






        ?>
</head>
<body>


<div class="col-sm-2">
            <div class="container">
                <div class="row">
                    <br>
                    <br>

                

                </div>
            </div>

        </div>

        <div class="col-sm-9">

            <div id="tablaStockLoad" style="align-content:left;">

            </div>

        </div>

        <div class="modal fade" id="agregastock" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Nuevo Stock</h4>
                    </div>
                    <div class="modal-body">


                        <form id="frm_stock">
                           	<input type="text" id="idproducto" name="idproducto" hidden>
                            <input type="text" id="cantidad" name="cantidad" hidden>
                            <label>Producto</label>
                            <select class="form-control input-sm" name="producto" id="producto" disabled>
                                <option value="A">Seleccione Producto:</option>
                                <?php while ($view = mysqli_fetch_row($result)) : ?>
                                    <option value="<?php echo $view[0] ?>"><?php echo $view[0].' '.$view[1]; ?></option>
                                    <?php endwhile; ?>
                            </select>
                            <label>Stock Nuevo</label>
                            <input type="text" class="form-control input-sm" id="stocknuevo" name="stocknuevo" 
                            minlength="1" maxlength="4" required =""  placeholder="Ingrese solo numeros hasta 4 digitos. Ej: 1 - 9999">
                        
                        </form>



                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn_nuevostock" class="btn btn-primary" data-dismiss="modal">Guardar</button>
                        <a href="stock.php"> <span class="btn btn-danger">Cancelar</span></a>

                    </div>
                </div>
            </div>
        </div>




    
</body>
</html>

<script>


        function agregadatoproducto(idproducto) {
            $.ajax({
                type: "POST",
                data: "idproducto=" + idproducto,
                url: "../procesos/productos/obtenerdatosstock.php",
                success: function(r) {

                    dato = jQuery.parseJSON(r);

                    $('#idproducto').val(dato['id_producto']);
                    $('#producto').val(dato['id_producto']);
                    $('#cantidad').val(dato['cantidad']);
                    

                }
            });
        }
    </script>

	

<script type="text/javascript">
        $(document).ready(function() {
            $('#tablaStockLoad').load("productos/table_stock.php");
            $('#btn_nuevostock').click(function() {

                $vacios = validarFormVacio('frm_stock');


                if (vacios > 0) {
                    alertify.alert("No se permiten campos vacíos");
                    return false;
                }

                datos = $('#frm_stock').serialize();
                $.ajax({

                    type: "POST",
                    data: datos,
                    url: "../procesos/productos/actualizarstock.php",
                    success: function(r) {
                        //console.log(r);

                        if (r == 1) {
                            alertify.success("Registro Añadido");
                            $('#tablaStockLoad').load("productos/table_stock.php");
                            $('#frm_stock')[0].reset();

                        } else {
                            alertify.error("Error al agregar o Dato Duplicado");
                        }

                    }
                });
            });
        });
    </script>

<?php
}else{
    header("location:../index.php");

}
?>