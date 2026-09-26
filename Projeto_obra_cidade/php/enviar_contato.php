<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Caminho para o autoload do Composer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $assunto = $_POST['assunto'];
    $mensagem = $_POST['mensagem'];

    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor SMTP do Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '@gmail.com'; // Substitua pelo seu e-mail
        $mail->Password = 'sua-senha-ou-app-password'; // Senha do Gmail ou App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Remetente e destinatário
        $mail->setFrom($email, $nome);
        $mail->addAddress('seuemail@gmail.com'); // Para onde o e-mail será enviado

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = "Contato pelo site - $assunto";
        $mail->Body    = nl2br("Nome: $nome\nE-mail: $email\nMensagem:\n$mensagem");

        $mail->send();
        header("Location: index.php?msgSucesso=Mensagem enviada com sucesso!");
        exit;
    } catch (Exception $e) {
        header("Location: index.php?msgErro=Erro ao enviar: {$mail->ErrorInfo}");
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
