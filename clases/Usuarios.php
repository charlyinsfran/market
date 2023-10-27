<?php 

class usuarios{
	public function registrarUsuario($datos){
		$c = new conectar();
		$conexion=$c->conexion();
	
		$fecha = date('Y-m-d');


	$sql = "INSERT into usuarios(nombre,apellido,email,direccion,telefono,usuario,password,fechaCaptura) 
	values ('$datos[0]',
			'$datos[1]',
			'$datos[2]',
			'$datos[3]',
			'$datos[4]',
			'$datos[5]',
			'$datos[6]',
			$fecha)";

	return mysqli_query($conexion,$sql);
}




public function loginUser($datos){

	$c = new conectar();
	$conexion=$c->conexion();
	$pass = sha1($datos[1]);

	$_SESSION['usuario'] = $datos[0];
	$_SESSION['iduser'] = self::traeID($datos);



	$sql = "Select * from usuarios where usuario = '$datos[0]' and password = '$pass'";

$result = mysqli_query($conexion,$sql);

if(mysqli_num_rows($result) > 0){
	return 1;
}else{
	return 0;
}

}



public function traeID($datos){
	$c = new conectar();
	$conexion=$c->conexion();
	$pass = sha1($datos[1]);

	$sql = "Select id_usuario from usuarios where usuario = '$datos[0]' and password = '$pass'";

	$result = mysqli_query($conexion,$sql);

	return mysqli_fetch_row($result)[0]; 
		


}

	}
	

	



 ?>