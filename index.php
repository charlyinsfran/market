<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="imagenes/login_icono.png">
    <link rel="stylesheet" type="text/css" href="librerias/bootstrap/css/bootstrap.css">
    <script src="librerias/jquery-3.2.1.min.js"></script>
    <script src="js/funciones.js"></script>
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
                <div class="panel panel-body">
                <p><img src="imagenes/devops_logo.jpg" height="230" width="300" style="text-align: center;"></p>

                <form id="frm_login" action="procesos/reglogin/login.php" method="post">

                <label >Usuario</label>
                <input type="text" class="form-control input-sm" name="usuario" id="usuario">
                <label>Password</label>
                <input type="password" class="form-control input-sm" name="password" id="password">
                <p></p>
                
                <span class="btn btn-primary btn-md" id="entrarSistema" style="text-align: center;"> Acceder</span>
                <a href="registro.php" class="btn btn-danger btn-md">Registro</a>


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
        alert("Debes llenar todos los campos");
        return false;
            }




datos=$('#frm_login').serialize();
$.ajax({
    type:"POST",
    data:datos,
    url:"procesos/reglogin/login.php",
    success:function(r){

        if(r==1){
            window.location = "vistas/inicio.php";
            $('#frm_login')[0].reset();
        }else{
            alert("datos incorrectos");
        }

    }
});
});
</script>