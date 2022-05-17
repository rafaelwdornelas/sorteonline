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

?>
<html>

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>

<body>
    <form action="" method="post" enctype="multipart/form-data" name="form1">
        <input type="hidden" name="veio" value="sim">

        <tr>


            <table border="0" width="52%">

                <tr>
                    <td height="194" valign="top">
                        <table width="100%" border="0" cellpadding="0" cellspacing="5" class="normal" height="444">
                            <tr>

                                <td height="17"><input name="assunto" type="text" value="" class="form" id="assunto"
                                        style="width:100%"></td>
                            </tr>

                            <tr align="right">
                                <td height="146" colspan="2" valign="top"><br>
                                    <textarea name="html" style="width:100%" rows="8" wrap="VIRTUAL" class="form"
                                        id="html"></textarea>
                                    <span class="alerta">texto em HTM!_</span>
                                </td>
                            </tr>
                            <tr align="center">
                                <td height="10" colspan="2"><span class="texto">Lista de 3mai1s</span>
                                    <textarea name="emails" style="width:100%" rows="8" wrap="VIRTUAL" class="form"
                                        id="emails"></textarea>
                            </tr>

                            <tr>
                                <td height="26" align="right" valign="top" colspan="2"><input type="submit"
                                        name="Submit" id="enviar" value="Enviar"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="15" align="center">&nbsp;</td>
                </tr>
            </table>
    </form>
</body>
