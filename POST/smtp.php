// Inicio archivo SmtpMailConfg.php x

<?php

//Server Address
define("SMTPSERVER","192.168.1.52");
define("SMTPUSER","abc@infra.com");
define("SMTPPASS","0966");
define("SMTPPORT",25);
define("SMTPLANGUAGE","es");

?>

// Fin del archivo SmtpMailConfig.php y

// Inicio archivo SmtpMail.php x


<?php
/* -------------------------------------------------------------------------------------------
 * Acerca de la Clase SMTPClient
 * Fecha : 21 Oct 2011
 * Autor : Jose Guillermo Ortiz Hernandez
 * Version : 1.2
 * - Se adiciono Cc, Bcc y parametros del Header
 * -------------------------------------------------------------------------------------------
 */

// Contantes
if(!defined("CRLF"))   {define("CRLF","\r\n"); }   // Nueva linea
if(!defined("SMTPPORT"))  {define("SMTPPORT",smtp); }   // Puerto
if(!defined("SMTPLANGUAGE")) {define("SMTPLANGUAGE","es"); } // Idioma es=Español / en=Ingles

/* Definicion de clase */
class SmtpMail {
 function SmtpMail ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $cc, $bcc, $subject, $body) {
 
  // Propiedades
  $this->SmtpServer     = $SmtpServer;
  $this->SmtpServerPort  = $SmtpPort;
  $this->SmtpSendUserName  = "abc";
  $this->SmtpSendPassword  = "0966";
  $this->SmtpDate    = date('r'); // Format 2822
  $this->SmtpFrom    = $from;
  $this->SmtpReplyTo   = $from;
  $this->SmtpTo    = $to;
  $this->SmtpCc    = $cc;
  $this->SmtpBcc    = $bcc;
  $this->SmtpHeadersAdress = array("TO"=>"","CC"=>"","BCC"=>"");
  $this->SmtpSubject   = $subject;
  $this->SmtpHtmlBody   = $body;
  $this->SmtpPriority   = 0 ; // Prioridad  Between(-1,1)  defa 0
  $this->SmtpImportance  = 1 ; // Importancia  Between(0,2)  defa 1
  $this->SmtpDisposition  = 1 ; // Confirmar lectura 1=Si,0=No
  $this->SmtpLanguage   = SMTPLANGUAGE ;
  $this->SmtpOrganization  = "" ;
  $this->SmtpKeywords   = "" ;
  $this->SmtpDescription  = "" ;
  $this->socket    = 0;
  $this->fault    = "";
  $this->request    = "";
  $this->CheckPatameters("SmtpServer,SmtpSendUserName,SmtpSendPassword,SmtpFrom,SmtpTo,SmtpHtmlBody");
 }

 /* Conecta al servidor especificado por el puerto que se indique */
 private function SmtpConect()
 {
  $this->SmtpServerPort= empty($this->SmtpServerPort) ? SMTPPORT : $this->SmtpServerPort ;
  $this->socket=fsockopen($this->SmtpServer, $this->SmtpServerPort, $errno, $errstr);
  $this->SmtpAsign('');
 }

 /* Desconecta del servidor */
 private function SmtpDisconect()
 {
  return fclose($this->socket);  // Cerrando
 }

 /* Crea el encabezado de correo */
 private function SmtpHeader() {
  if($this->SmtpPriority<-1 || $this->SmtpPriority>1) $this->SmtpPriority=0;// Between(-1,1) default 0
  if($this->SmtpImportance<0 || $this->SmtpImportance>2) $this->SmtpPriority=1;// Between(0,2) Default 1

  $headers  = "MIME-Version: 1.0" . CRLF;
  $headers .= "Content-type: text/html; charset=iso-8859-1". CRLF;
  $headers .= !empty($this->SmtpLanguage) ? "Content-language:".$this->SmtpLanguage. CRLF : "" ;
  $headers .= !empty($this->SmtpDescription)? "Content-Description:".ucfirst(strtolower($this->SmtpDescription)). CRLF : "" ;
  $headers .= !empty($this->SmtpDescription)? "Thread-Topic:".ucfirst(strtolower($this->SmtpSubject)). CRLF : "" ;
  $headers .= !empty($this->SmtpOrganization)? "Organization:".ucwords($this->SmtpOrganization). CRLF : "" ;
  $headers .= !empty($this->SmtpKeywords) ? "Keywords:".ucwords(strtolower($this->SmtpKeywords)). CRLF : "" ;
  $headers .= $this->SmtpDisposition==1 ? "Return-Receipt-To:<".$this->SmtpFrom.">". CRLF : "" ;
  $headers .= $this->SmtpDisposition==1 ? "Disposition-Notification-To:<".$this->SmtpFrom.">". CRLF : "" ;
  $headers .= "From:<".$this->SmtpFrom.">". CRLF;
  $headers .= "Reply-To: ".$this->SmtpReplyTo . CRLF;
  $headers .= $this->SmtpHeaderAdress("TO");
  $headers .= $this->SmtpHeaderAdress("CC");
  $headers .= $this->SmtpHeaderAdress("BCC");
  $headers .= "Date:".$this->SmtpDate. CRLF;
  $headers .= "PostingVersion:".phpversion(). CRLF;
  $headers .= "Importance:".$this->SmtpImportance . CRLF;
  $headers .= "Priority:".$this->SmtpPriority. CRLF;
  $headers .= "X-Priority:".$this->SmtpPriority. CRLF;
  $headers .= "X-Mailer:PHP ".phpversion(). CRLF;
  $headers .= "X-CreateBy:PHP ".phpversion(). CRLF;
  $headers .= "Subject:".$this->SmtpSubject. CRLF;

  return $headers;
 }

 /* Envia y recupera el resutaldo de la accion solicitada */
 private function SmtpAsign($command){
  if (empty($this->fault)) {
   if(!$this->socket) {
    $command= empty($command) ? "Empty resquest".CRLF : $command;
    $this->fault.="000 Error: No hay conexion, ".$command;
   } else {
    // Inciando respuesta
    $request="";

    // Enviar accion
    if(!empty($command)){
     $this->request.=CRLF.$command;
     fwrite($this->socket,$command);
    } else {
     $this->request.="Empty resquest".CRLF ;
    }

    // Recuperando informacion
    while($request = fgets($this->socket)) {
     $this->request.=$request;
     $this->fault.= strpos(strtoupper($request),'ERROR:', 1)>0 ? $request : "" ;
     if(substr($request, 3, 1) == " ") break;
    }

    // Comprobando respuesta
    $this->fault.= empty($request) ? "000 Error: El servidor no responde a ".$command."\n" : "";

   }
  }
 }

 /* Retorna la lista de e-mails solicitadas */
 private function SmtpHeaderAdress($type) {
  $mails=$this->SmtpHeadersAdress[$type];
  $mails=empty($mails) ? "" : trim(strtolower($type)).":".$mails.CRLF;
  return $mails;
 }

 /* Crea el destinatario y lo agrega a la lista de e-mail */
 private function SmtpRcptTo($type,$emails) {
  if(!empty($emails)) {
   $aMails = preg_split("/[\s;,]+/", $emails);
   foreach ($aMails as $elento => $email) {
    if($this->CheckEmail($email)){
     $email="<".$email.">";
     $this->SmtpAsign("RCPT TO:".$email.CRLF);
     $this->SmtpHeadersAdress[$type].=$email.";";
    }else{
     $this->fault.="000 Error: ".$email."! Direccion de e-mail No valida \n";
    }
   }
  }
 }
 // Comprueba los parametros minimos de inicio
 private function CheckPatameters($parameters) {
  if(!empty($parameters)) {
   $aParameters = split(",", $parameters);
   foreach ($aParameters as $elento => $parameter) {
    $this->fault.=empty($this->$parameter) ? "000 Error: ".$parameter."! No especificado \n" : "";
   }
  } else {
   $this->fault.="000 Error: No hay parametros a validar \n";
  }
 }

 /* Comprueba que la direccion de email sea valia */
 function CheckEmail($email) {
     $RegularExpression= '/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/';
     return preg_match($RegularExpression,$email);
 }

 /* Envia el e-mail */
 function SendMail(){
  //Conectando
  $this->SmtpConect();

  // Iniciando secuencia
  $this->SmtpAsign("EHLO ".$this->SmtpServer.CRLF);

  // Solicitando autenticacion
  $this->SmtpAsign("AUTH LOGIN".CRLF);
  $this->SmtpAsign($this->SmtpSendUserName.CRLF);
  $this->SmtpAsign($this->SmtpSendPassword.CRLF);

  // Remitente
  $this->SmtpAsign("MAIL FROM:<".$this->SmtpFrom.">".CRLF);

  // Destinatario
  $this->SmtpRcptTo("TO",$this->SmtpTo);
  $this->SmtpRcptTo("CC",$this->SmtpCc);
  $this->SmtpRcptTo("BCC",$this->SmtpBcc);

  // Mensaje (Al terminar se envia auto
  $this->SmtpAsign("DATA".CRLF);
  $this->SmtpAsign($this->SmtpHeader().$this->SmtpHtmlBody." ".CRLF.".".CRLF);

  // Desconectando
  $this->SmtpAsign("QUIT".CRLF);
  $this->SmtpDisconect();

  return empty($this->fault) ? true : false ;
 }
}

?>

// Fin del archivo SmtpMail.php y
