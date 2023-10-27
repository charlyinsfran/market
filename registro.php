<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="imagenes/registrodeusuarios.png">
    <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
    <script src="librerias/jquery-3.2.1.min.js"></script>
    <script src="js/funciones.js"></script>
    <title>Registro de Usuarios</title>
</head>
<body>
    <div class="container">
        <div class="row">

        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <div class="panel panel-success">
                    <div class="panel panel-heading"style="text-align: center;">CREAR USUARIO NUEVO</div>
                    <div class="panel panel-body">
                        <form id="frm_registrousuarios">    
                    
                        <label>Nombre</label>
                        <input type="text" class="form-control input-sm" name="nombre" id="nombre">
                        <label>Apellido</label>
                        <input type="text" class="form-control input-sm" name="apellido" id="apellido">
                        <label>Email</label>
                        <input type="text" class="form-control input-sm" name="email" id="email">
                        <label>Direccion</label>
                        <input type="text" class="form-control input-sm" name="direccion" id="direccion">
                        <label>Telefono/Celular</label>
                        <input type="text" class="form-control input-sm" name="telefono" id="telefono">
                        <label>Usuario</label>
                        <input type="text" class="form-control input-sm" name="usuario" id="usuario">
                        <label>Password</label>
                        <input type="text" class="form-control input-sm" name="pass" id="pass">
                        <p></p>
                        <span class="btn btn-info" id="registro"><strong>Guardar</strong></span>
                        <a class="btn btn-warning" href="index.php">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-4"></div>
        </div>


        </div>
    </div>
    
    
</body>
</html>

<script type="text/javascript">
$(document).ready(function(){


$('#registro').click(function(){

   vacios = validarFormVacio('frm_registrousuarios');

   if(vacios>0){
    alert("Debes llenar todos los campos");
    return false;
   }

		datos=$('#frm_registrousuarios').serialize();
		$.ajax({
			type:"POST",
			data:datos,
			url:"procesos/reglogin/registrarusuarios.php",
			success:function(r){

                if(r==1){
                    alert("Guardado con exito");
                    $('#frm_registrousuarios')[0].reset();
                    $('#nombre').focus();
                }else{
                    alert("Error al guardar");
                }

			}
		});
	});
});

  </script> 

