<?php
  include 'index.html';
  $db_name = 'BD_Usuarios';
  $mysql_user = 'jdes';
  $mysql_pass = '0966';
  $server_name = 'localhost';

  $correo= $_POST["correo"];
  $contrasena = $_POST["contrasena"];

  //connection
  $con = mysqli_connect($server_name,$mysql_user,$mysql_pass,$db_name);

  if(!$con)
  {
  	echo "Connection error..".mysqli_connect_error();
  }
  else
  {
  		$query = "SELECT * FROM Usuario WHERE correo = '".$correo."' AND contrasena = '".$contrasena."'";
  		$result = mysqli_query($con,$query);
  		while($row = mysqli_fetch_assoc($result)){
        $correo2 = $row['correo'];
        $contrasena2 = $row['contrasena'];
 
        if ( $correo2==$correo and  $contrasena2==$contrasena){
          echo '<script type="text/javascript">
                window.location="menuUsuario.php";
                </script>';
        }
        echo "No se ha podido iniciar sesion";
  		}
    }
?>
