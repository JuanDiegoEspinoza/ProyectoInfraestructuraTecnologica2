function realizarLogin (e)
{
  e.preventDefault();
  var correoUsuario = document.getElementById("correo").value;
  var contrasenaUsuario = document.getElementById("contrasena").value;

  window.location="inicioSesion.php?userName=\""+correoUsuario+"\"&userPassword=\""+contrasenaUsuario+"\"";
  return false;
}




function redireccionarConParametros(){
  var contrasena = getParameterByName('correo');
  var correo = getParameterByName('contrasena');
  alert(contrasena);
  alert(correo);
  window.location="menuUsuario.php?correo="+correo+"contrasena="+contrasena;
 
}


function validarIngresoDatos (e)
{
  e.preventDefault();
  var correoUsuario = document.getElementById("correo").value;
  var contrasenaUsuario = document.getElementById("contrasena").value;

//  window.location="index.php?correo=\""+correoUsuario+"\"&contrasena=\""+contrasenaUsuario+"\"";
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
