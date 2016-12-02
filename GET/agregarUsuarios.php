<?php

include 'agregarUsuarios.html';
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
			$query = "INSERT INTO `Usuario` ( `correo` , `contrasena` ) VALUES ('$userPassword', '$userName')";
    //$query = "INSERT INTO Usuario (1, `contrasena` , `correo` ) VALUES (1,".$userPassword.", ".$userName.")";
    if ($con->query($query) === TRUE) {
      echo "Se ha agregado el usuario: ".$userName;
    }
    else {
      echo "Error: " . $sql . "<br>" . $con->error;
    }
}

?>
