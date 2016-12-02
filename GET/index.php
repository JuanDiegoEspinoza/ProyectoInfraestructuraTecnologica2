<?php

session_start();
include 'index.html';


  $db_name = 'BD_Usuarios';
  $mysql_user = 'jdes';
  $mysql_pass = '0966';
  $server_name = 'localhost';

  $correo= $_GET["correo"];
  $contrasena = $_GET["contrasena"];

  $_SESSION["correo"] = $correo;
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
        $_SESSION["correo"] = $row['correo'];
        $correo2 = $row['correo'];
        $contrasena2 = $row['contrasena'];

        echo $correo2;
        echo $correo;
        echo $contrasena2;
        echo $contrasena;

        if ( $correo2==$correo and  $contrasena2==$contrasena){
          echo '<script languaje="JavaScript">
                var correo="'.$correo2.'";
                var contra="'.$contrasena2.'";
                var direccion = "menuUsuario.php?correo="+correo+"&contrasena="+contra;

                window.location = direccion;
                </script>';
          return;
        }
        echo "mal";
  		}
    }


?>
<script src="indexLogin.js"></script>
