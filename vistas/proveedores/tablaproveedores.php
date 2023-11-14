<?php

require_once "../../clases/Conexion.php";


$c = new conectar();
$conexion = $c->conexion();

$sql = "SELECT p.idproveedores,p.razon_social,p.ruc,p.direccion,c.detalle,p.email,p.telefono 
FROM proveedores p join ciudad c on p.id_ciudad = c.idciudad";

$result = mysqli_query($conexion, $sql);
?>

<label style="text-align: center;">Proveedores</label>
<p></p>

<table class="table table-hover table-condensed table-bordered" id="tabladinamica">
<thead>
<tr style="font-weight: bold; background-color: #f1f8f9; text-align: center;">
        <td>Codigo</td>
        <td>Razon Social</td>
        <td>RUC</td>
        <td>Direccion</td>
        <td>Ciudad</td>
        <td>Email</td>
        <td>Telefono</td>
        <td>Editar</td>
        <td>Borrar</td>
    </tr>
</thead>
<tbody>
    <?php while ($ver = mysqli_fetch_row($result)) :
?>


    <tr style="font-size: 13; text-align:center">
   
            <td><?php echo utf8_encode($ver[0]); ?></td>
            <td><?php echo utf8_encode($ver[1]); ?></td>
            <td><?php echo utf8_encode($ver[2]); ?></td>
            <td><?php echo utf8_encode($ver[3]); ?></td>
            <td><?php echo $ver[4]; ?></td>
            <td><?php echo utf8_encode($ver[5]); ?></td>
            <td><?php echo utf8_encode($ver[6]); ?></td>
            
           
            
            <td>
                <span class="btn btn-warning btn-sm">
                    <span class="glyphicon glyphicon-pencil" 
                    data-toggle="modal" data-target="#actualizaproveedor" onclick="agregadatoproveedor('<?php echo $ver[0]; ?>')"></span>
                </span>

            </td>
            <td>
            <span class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-remove" onclick="eliminaProveedor('<?php echo $ver[0] ?>')"></span>
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