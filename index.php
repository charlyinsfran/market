<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="imagenes/login_icono.png">
    <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/alertify.css">
    <link rel="stylesheet" type="text/css" href="librerias/alertifyjs/css/themes/default.css">

    <script src="librerias/jquery-3.2.1.min.js"></script>
    <script src="js/funciones.js"></script>
    <script src="librerias/alertifyjs/alertify.js"></script>
    <title>LOGIN</title>
</head>
<body>

<br><br><br>

<div class="container">
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-5">
            <div class="panel panel-primary" style="width: 350px;">
                <div class="panel panel-heading" style="text-align: center;">DMARKET - DEVOPS</div>
                <div class="panel panel-body" align="center">
                <p><img src="imagenes/devops_logo.jpg" height="230" width="300" style="text-align: center;"></p>

                <form id="frm_login" action="procesos/reglogin/login.php" method="POST">
                <div class="col-sm-12">
                <label style="font-size: 1em; text-align: center;" >Usuario</label>
                <input type="text" class="form-control input-sm" name="usuario" id="usuario" style="font-size: 1em; text-align: center;">
                <p></p>
                <label>Password</label>
                <input type="password" class="form-control input-sm" name="password" id="password" style="font-size: 1em; text-align: center;">
                <p></p>
                </div>
                <div class="col-sm-12" align="center">
                <span class="btn btn-primary btn-md glyphicon glyphicon-log-in" id="entrarSistema" style="text-align: center; font-size: 1em;"> Acceder</span>
                
                </div>

                </form>



                </div>
            </div>



        </div>
        
    </div>
</div>
    
</body>
</html>


<script>
    $(document).ready(function() {
        $('#usuario').focus(); });
    
    
</script>

<script>



    $('#entrarSistema').click(function(){
        vacios = validarFormVacio('frm_login');

        if(vacios>0){
            $('#usuario').focus(); 
        alertify.alert("Debes llenar todos los campos");
        return false;
            }




datos=$('#frm_login').serialize();
$.ajax({
    type:"POST",
    data:datos,
    url:"procesos/reglogin/login.php",
    success:function(r){

        if(r==1){
            window.location = "vistas/aperturacaja.php";
            $('#frm_login')[0].reset();
        }else{
            alertify.error("Datos Incorrectos");
        }

    }
});
});
</script>



    <script type="text/javascript">

window.onkeydown = presionarenter;


function presionarenter(){
  tecla_tab = event.keyCode;
  if(tecla_tab == 13){
    vacios = validarFormVacio('frm_login');
    if(vacios>0){
        alertify.alert("Debes llenar todos los campos");
        return false;
    }
    datos=$('#frm_login').serialize();
    $.ajax({
        type:"POST",
        data:datos,
        url:"procesos/reglogin/login.php",
        success:function(r){

            if(r==1){
                window.location = "vistas/aperturacaja.php";
                $('#frm_login')[0].reset();
            }else{
                alertify.error("Datos Incorrectos");
            }

        }
    });
}
}


</script>