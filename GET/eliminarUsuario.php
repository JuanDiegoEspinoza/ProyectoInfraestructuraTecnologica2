<?php

include 'eliminarUsuario.html';
$db_name = "BD_Usuarios";
$mysql_user = "jdes";
$mysql_pass = "0966";
$server_name = "localhost";


//connection
$con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

$userName = $_GET["email"];
$userPassword = $_GET["contrasena"];

 

if(!$con)
{
	echo "Connection error..".mysqli_connect_error();
}
else
{
		// sql to delete a record
	$sql = "DELETE FROM Usuario WHERE correo='".$userName."'and contrasena='".$userPassword."'";

	if ($con->query($sql) === TRUE) {
		echo '<script languaje="JavaScript">
					alert("El usuario: ha sido eliminado");
					</script>';
		return;
	} else {
		echo '<script languaje="JavaScript">
					alert("No se ha podido eliminar el usuario");
					</script>';
		echo "Error deleting record: " . $con->error;
	}

	$con->close();
}

?>
