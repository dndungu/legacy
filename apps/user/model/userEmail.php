<?php
function userEmail($to, $subject, $body){
	try {
		$from = array('noreply@isys.co.ke' => 'Website Engine');
		$base = str_replace('/html', '', getcwd());
		require("$base/libs/Swift-4.0.6/lib/swift_required.php");
		$mailer = Swift_Mailer::newInstance(Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')->setUsername('dnjuguna@gmail.com')->setPassword('gerejisisi'));
		$message = Swift_Message::newInstance($subject)->setFrom($from)->setTo($to)->setBody($body);
		$sent = $mailer->send($message);
		return true;
	} catch (Exception $e) {
		error_log($e->getMessage());
		return false;
	} 
}
?>