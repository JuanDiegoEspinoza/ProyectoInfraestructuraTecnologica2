<?php

	session_start();
	include('SmtpMailConfig.php');
	include('SmtpMail.php');

	$correo = $_SESSION["correo"];
	// Informacion
	@$smtpuser = $_POST['smtpuser'];settype($smtpuser,'string');
	@$smtppass = $_POST['smtppass'];settype($smtppass,'string');
	@$to = $_POST['to'];settype($to,'string');
	@$cc = $_POST['cc'];settype($cc,'string');
	@$bcc = $_POST['bcc'];settype($bcc,'string');
	@$replyto = $_POST['replyto'];settype($replyto,'string'); $replyto = empty($replyto) ? "no-reply@shaio.org" : $replyto;
	@$subject = $_POST['sub'];settype($subject,'string');
	@$body = $_POST['message'];settype($body,'string');
 
	// Enviar
	if($_SERVER["REQUEST_METHOD"] == "POST") {

		// Creando objeto
		$objMail = new SmtpMail (SMTPSERVER, SMTPPORT, $smtpuser, $smtppass, $smtpuser, $to, $cc, $bcc, $subject, $body);

		// Parametros opcionales
		$objMail->SmtpReplyTo=$replyto ;

		// Enviar el e-mail
		$resultado = $objMail->SendMail();
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="stylesheet" href="css/style.css">
<title></title>

<!-- Icon files -->
<link rel="shortcut icon" href="ico/favicon.ico" />
<link rel="icon" href="ico/favicon.ico" />

<!-- Estilos css -->
<style>
body,td,th {
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 11px;
}

body {
	margin-left: 60px;
	margin-top: 10px;
	margin-right: 60px;
	margin-bottom: 60px;
}

</style>


</head>
<body>

<!-- A continuacion se crea el formulario para el envio del correo electronico, este formulario utiliza el
metodo POST para el envio de los datos -->

	<form method="post" class="form" action="menuUsuario.php">
		<table width="100%" align="center" cellspacing="0" border="0" bordercolor="0" cellpadding="0">
			<tr>
				<?php
					echo "AUTENTICADO COMO: ".$_SESSION["correo"];
				 ?>
			 <br>
			 <br>
			 <br>

				<td width="120">Usuario:</td>
			</tr>
			<tr>

		</table>
		<table width="100%" align="center" cellspacing="0" border="0" bordercolor="0" cellpadding="0">

			<p class="email">
				<input type="text" name="smtpuser" value="<?php echo  $_SESSION["correo"]; ?>" style="width:250px;" class="validate[required,custom[email]] feedback-input" id="email" placeholder="Correo" />
			</p>

			<p class="email">
        <input name="to" type="text" value="<?php print($to);?>" style="width:40%;" class="validate[required,custom[email]] feedback-input" id="email" placeholder="Correo" />
      </p>

			<p class="email">
				<input name="cc" type="text" value="<?php print($cc);?>"  style="width:40%;" class="validate[required,custom[email]] feedback-input" id="emailcc" placeholder="Copia del correo" />
			</p>


      <p class="name">
        <input type="text" name="sub" value="<?php print($subject);?>" style="width:40%;" class="validate[required,custom[onlyLetter],length[0,100]] feedback-input" placeholder="Asunto" id="name" />
      </p>


      <p class="text">
        <textarea name="message" class="validate[required,length[6,300]] feedback-input" style="width:40%;" id="comment" placeholder="Cuerpo"><?php print($body);?></textarea>
			</p>
			<tr>
			<div class="submit">
        <td width="120"><input type="submit" value="Enviar" id="button-blue"/></td>
        <div class="ease"></div>
      </div>
			</tr>
		</table>
	</form>
<?php

/* A continuacion se muestra por pantalla el resultado de la solicitus
	 * al servidor ,  primero se muestra se el  mensaje se envio, luego se
	 * muestra  la  solicitud  realizada al  servidor y  por ultimo  si se
	 * presento algun error.
	 */

	if($_SERVER["REQUEST_METHOD"] == "POST") {
		print("<h2>Resultado:</h2>");

		// Se envio o no el mensaje?
		if($resultado==false) {
			print("<pre>No se pudo enviar el mensaje<br/></pre>");
			// De presentarce una falla cual fue
			print('<h2>Falla:</h2>');
			print('<pre>'.htmlspecialchars($objMail->fault,ENT_QUOTES).'</pre>');
		} else {
			print("<pre>Mensaje enviado</pre>");
			// Cual fue la solictud que se realizo al servidor
			print('<h2>Solicitud / Respuesta:</h2>');
			print('<pre>'.htmlspecialchars($objMail->request,ENT_QUOTES).'</pre>');
		}
	}

?>

</body>
</html>
