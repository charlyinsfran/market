<?php

require_once "../../clases/Conexion.php";


$c = new conectar();
$conexion = $c->conexion();

$sql = "SELECT u.id_usuario,u.nombre,u.apellido,u.email,u.direccion,u.telefono,u.usuario,u.password,r.detalle from usuarios u 
JOIN roles r on u.id_rol = r.idroles ORDER BY id_usuario";

$result = mysqli_query($conexion, $sql);

?>

<label style="font-size: 2em; text-align:center">Categorias de Productos</label>
<p></p>





<table class="table table-hover table-condensed table-bordered" id="tabladinamica">
    
    <thead>
    <tr style="font-weight: bold; background-color: #86e9f8; text-align: center;">
        <td style="text-align: center;">Codigo</td>
        <td>Nombre</td>
        <td>Email</td>
        <td>Direccion</td>
        <td>Telefono</td>
        <td>Usuario</td>
        <td>Tipo de Usuario</td>
        <td>Editar</td>
        <td>Borrar</td>
    </tr>
    </thead>
    <tbody>


    <?php


    while ($ver = mysqli_fetch_row($result)) :

        
    ?>

        <tr style="font-size: 13;">
            <td style="width: 20px; text-align:center"><?php echo $ver[0]; ?></td>
            <td style="text-align: center;"><?php echo $ver[1].' '.$ver[2]; ?></td>
            <td style="text-align: center;"><?php echo $ver[3]; ?></td>
            <td style="text-align: center;"><?php echo $ver[4]; ?></td>
            <td style="text-align: center;"><?php echo $ver[5]; ?></td>
            <td style="text-align: center;"><?php echo strtoupper($ver[6]); ?></td>
            <td style="text-align: center;"><?php echo strtoupper($ver[8]); ?></td>

            <td style="width: 20px; text-align:center">
                <span class="btn btn-warning btn-sm">
                    <span class="glyphicon glyphicon-pencil" 
                    data-toggle="modal" data-target="#update_usuario" 
                    onclick="agregadato('<?php echo $ver[0] ?>')"></span>
                </span>

            </td>
            <td style="width: 20px; text-align:center">
            <span class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-remove" onclick="eliminausuario('<?php echo $ver[0] ?>')"></span>
            </span>

            </td>
        </tr>


    <?php endwhile; ?>
    </tbody>


</table>


<script type="text/javascript">
    $(document).ready(function(){
   $('#tabladinamica').DataTable({

       "language": {
        "decimal": ",",
        "thousands": ".",
        "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "infoPostFix": "",
        "search": "Buscar:",
        searchPlaceholder: "Buscar por codigo o nombre",
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