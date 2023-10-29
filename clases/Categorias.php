<?php

class categorias{
    public function agregacategorias($datos){
        $c = new conectar();
        $conexion = $c->conexion();


        $sql = "INSERT INTO categorias(id_usuario,nombreCategoria,fechaCaptura) values ('$datos[0]','$datos[1]','$datos[2]')";

        return mysqli_query($conexion,$sql);


    }


public function actualizarCategorias($datos){
    

		$c = new conectar();
		$conexion=$c->conexion();

		$sql = "UPDATE categorias SET nombreCategoria = '$datos[1]' WHERE id_categoria = '$datos[0]'";

		echo mysqli_query($conexion,$sql);
	
	
}



        
    }
?>