<?php


$db_name = "BD_Usuarios";
$mysql_user = "admi";
$mysql_pass = "0966"
$server_name = "localhost";


//connection
$con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

if(!$con)
{
	echo "Connection error..".mysqli_connect_error();


}
else
{
    $query = 'SELECT count(1) FROM Usuario WHERE Usuario.correo ='+$userName+'AND Usuario.contrasena ='+$userPassword;
	$result = mysqli_query($con,$query);
		if($result==1){
			$_SESSION['correo']=$userName;
			echo '<script type="text/javascript">
					alert("menuUsuario.php");
				</script>';
		}
		else{  

      echo '<script type="text/javascript">
					alert("Comprueba sus datos ingresados");
				</script>';
		}
	}

?>
