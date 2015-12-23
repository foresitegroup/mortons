<?php global $jellythemes; ?>
<?php
if(isset($_POST['email'])){
		$mailTo = $_POST['emailto'];
		$subject = "mail from web";
		$body = "New message from web
<br><br>
FROM: ".$_POST['email']."<br>
NAME: ".$_POST['name']."<br>
COMMENTS: ".$_POST['message']."<br>";
		$headers = "To: Solido <".$mailTo.">\r\n";
		$headers .= "Content-Type: text/html";
		//envio destinatario
		$mail_success =  mail($mailTo, utf8_decode($subject), utf8_decode($body), $headers);
}
?>