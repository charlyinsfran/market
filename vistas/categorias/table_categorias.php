<?php

require_once "../../clases/Conexion.php";


$c = new conectar();
$conexion = $c->conexion();

$sql = "SELECT id_categoria,nombreCategoria,fechaCaptura from categorias  ORDER BY id_categoria";

$result = mysqli_query($conexion, $sql);

?>

<label style="font-size: 2em; text-align:center">Categorias de Productos</label>
<p></p>





<table class="table table-hover table-condensed table-bordered" id="tabladinamica">
    
    <thead>
    <tr style="font-weight: bold; background-color: #86e9f8; text-align: center;">
        <td>Codigo</td>
        <td>Descripcion</td>
        <td>Editar</td>
        <td>Borrar</td>
    </tr>
    </thead>
    <tbody>


    <?php


    while ($ver = mysqli_fetch_row($result)) :
    ?>

        <tr style="font-size: 13;">
            <td style="width: 20px; text-align:center"><?php echo utf8_encode($ver[0]); ?></td>
            <td style="text-align: center;"><?php echo strtoupper($ver[1]); ?></td>

            <td style="width: 20px; text-align:center">
                <span class="btn btn-warning btn-sm">
                    <span class="glyphicon glyphicon-pencil" 
                    data-toggle="modal" data-target="#actualizaCategorias" 
                    onclick="agregaDato('<?php echo $ver[0] ?>','<?php echo utf8_encode($ver[1]) ?>')"></span>
                </span>

            </td>
            <td style="width: 20px; text-align:center">
            <span class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-remove" onclick="eliminaCategoria('<?php echo $ver[0] ?>')"></span>
            </span>

            </td>
        </tr>


    <?php endwhile; ?>
    </tbody>


</table>


<script type="text/javascript">
    $(document).ready(function(){
   $('#tabladinamica').DataTable({

    dom: 'Bfrtip',
    buttons: [
            {
                extend:    'copyHtml5',
                className: 'btn btn-success',
                titleAttr: 'Copiar'
            },
            {
                extend:    'excelHtml5',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                titleAttr: 'PDF'
            }
        ],
       "language": {
        "decimal": ",",
        "thousands": ".",
        "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "infoPostFix": "",
        "search": "Buscar:",
        searchPlaceholder: "BUSCAR POR CODIGO Ó DESCRIPCION",
        "infoFiltered": "(filtrado de un total de _MAX_ registros)",
        "loadingRecords": "Cargando...",
        "lengthMenu": "Mostrar _MENU_ registros",
        "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    }
            
        });


    });
</script>