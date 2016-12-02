
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type">
<meta charset="utf-8">
<link rel="stylesheet" href="css/style.css">
<title>HOLA </title>

</head>
<body>

  <input type="email" class="form-control" align="center" placeholder = "Correo Electrónico" style="width:300px;height:15px" name="correo" id="correo">
  <input type="password" align="center" placeholder = "Contraseña" class="form-control" style="width:300px;height:15px" name="contrasena" id="contrasena">

<button name ="hola" value ="hola" onclick="comprobarDatos(event)">HOLA<button>
<?php

if (isset($SESSION["correo"]) and isset($SESSION["contrasena"])){
  echo "exc";
}
else{

  echo "<h1>mal</h1>";
}
?>

<script src="indexLogin.js"></script>

</body>
</html>
 
