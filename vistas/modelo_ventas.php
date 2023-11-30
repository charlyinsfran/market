<?php
//error_reporting (0); 
session_start();

$operacion = $_REQUEST['operacion'];
echo "<pre>";
print_r($_REQUEST);
echo "<pre>";

switch ($operacion){
    case 'buscar': buscar_cliente();
            break;
            
    case 'CANCELAR': vaciar_cliente();
            break;

    
}


function buscar_cliente(){
    include "../clases/conection.php";
    if(empty($_REQUEST['cicliente'])){
        //header("location:compras.php?aviso=2");
    }
    else{
    $cicliente = $_REQUEST['cicliente'];
    $clientes = $bd->query("SELECT * FROM clientes where nombre like '%$cicliente%'")->fetch(PDO::FETCH_OBJ);
    $_SESSION['clientes'] = $clientes;
    
    header("location:ventas.php");
}

}



function vaciar_cliente(){
    unset($_SESSION['clientes']);
    header("location:ventas.php");
}

?>