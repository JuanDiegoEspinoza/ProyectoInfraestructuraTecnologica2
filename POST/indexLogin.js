function realizarLogin (e)
{
  e.preventDefault();
  var correoUsuario = document.getElementById("correo").value;
  var contrasenaUsuario = document.getElementById("contrasena").value;

  window.location="inicioSesion.php?userName=\""+correoUsuario+"\"&userPassword=\""+contrasenaUsuario+"\"";
  return false;
}






function validarIngresoDatos (e)
{
  e.preventDefault();
  var correoUsuario = document.getElementById("correo").value;
  var contrasenaUsuario = document.getElementById("contrasena").value;

  window.location="index.php";
  return false;
}


 


function comprobarDatos (e)
{
  e.preventDefault();
  var correoUsuario = document.getElementById("correo").value;
  var contrasenaUsuario = document.getElementById("contrasena").value;

  window.location="prueba.php?userName=\""+correoUsuario+"\"&userPassword=\""+contrasenaUsuario+"\"";
  return false;
}
