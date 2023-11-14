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
	$_SESSION['tipousuario'] = self::traetipousuario($datos);



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

public function traetipousuario($datos){
	$c = new conectar();
	$conexion=$c->conexion();
	$pass = sha1($datos[1]);

	$sql = "Select r.detalle from usuarios u join roles r on u.id_rol = r.idroles where u.usuario = '$datos[0]' and u.password = '$pass'";

	$result = mysqli_query($conexion,$sql);

	return mysqli_fetch_row($result)[0]; 
}


public function new_usuario($datos){
	$c = new conectar();
	$conexion=$c->conexion();

	$fecha = date('Y-m-d');


$sql = "INSERT into usuarios(nombre,apellido,email,direccion,telefono,usuario,password,fechaCaptura,id_rol) 
values ('$datos[0]',
		'$datos[1]',
		'$datos[2]',
		'$datos[3]',
		'$datos[4]',
		'$datos[5]',
		'$datos[6]',
		'$datos[7]',
		'$datos[8]')";

return mysqli_query($conexion,$sql);
}




public function obtenerdatos($ide){
	$c = new conectar();
	$conexion = $c->conexion();
	$sql = "SELECT id_usuario,nombre,apellido,email,direccion,telefono,usuario,id_rol from usuarios  
	WHERE id_usuario = '$ide'";
	$result = mysqli_query($conexion,$sql);

	$ver = mysqli_fetch_row($result);

	$datos = array("id_usuario"=>$ver[0],"nombre"=>$ver[1],"apellido"=>$ver[2],"email"=>$ver[3],
	"direccion"=>$ver[4],"telefono"=>$ver[5],"usuario"=>$ver[6],"id_rol"=>$ver[7]);


	return $datos;
}

public function actualizarusuarios($datos){

	$c = new conectar();
	$conexion = $c->conexion();
	$sql = "UPDATE usuarios SET nombre = '$datos[1]',
								apellido = '$datos[2]',
									email = '$datos[3]',
									direccion = '$datos[4]',
									telefono = '$datos[5]',
									usuario = '$datos[6]',
									id_rol = '$datos[7]'
									 where id_usuario = '$datos[0]'";
   return mysqli_query($conexion,$sql);

}


public function eliminausuario($id){
	$c = new conectar();
	$conexion=$c->conexion();
	$sql = "DELETE FROM usuarios where id_usuario = '$id'";
	return mysqli_query($conexion,$sql);

	
}

	}
	

	



 ?>