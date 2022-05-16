<?php
$testa = $_POST['veio'];
if ($testa != "") {
  $message = $_POST['html'];
  $subject = $_POST['assunto'];
  $de = $_POST['de'];
  $to = $_POST['emails'];

  $email = explode("\n", $to);
  $message = stripslashes($message);

  $i = 0;
  $count = 1;
  while ($email[$i]) {
    $ok = "ok";
    $gera = rand(1, 100000);
    $headers  = "MIME-Version: 1.0\n";
    $headers .= "Content-type: text/html; charset=utf-8\r\n";
    $headers .= "X-Mailer: Microsoft Office Outlook, Build 17.551210\n";
    $headers .= "Content-Transfer-encoding: base64\n";
    $headers .= "From: " . $email[$i] . "\n";
    $headers .= "Reply-To: $email[$i]\n";
    $headers .= "Return-Path: $email[$i]\n";
    $headers .= "X-Mailer: iGMail [www.ig.com.br]\n";
    $headers .= "X-Originating-Email: $email[$i]\n";
    $headers .= "X-Sender: $email[$i]\n";
    $headers .= "X-iGspam-global: Unsure, spamicity=0.570081 - pe=5.74e-01 - pf=0.574081 - pg=0.574081\r\n";
    if (mail($email[$i], $subject . " (" . $gera . ")", $rtrim(chunk_split(base64_encode($message))), $headers))
      echo "<font color=gren>* N&#1098;mero: $count <b>" . $email[$i] . "</b> <font color=LightSeaGreen>ENVIADO....!</font><br><hr>";
    else
      echo "<font color=red>* N&#1098;mero: $count <b>" . $email[$i] . "</b> <font color=red>ERRO AO ENVIAR</font><br><hr>";
    $i++;
    $count++;
  }
  $count--;
  if ($ok == "ok")
    echo "[Fim do Envio]";
}