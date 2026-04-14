<?php
// 1. Importação dos arquivos
require 'lib/Exception.php';
require 'lib/PHPMailer.php';
require 'lib/SMTP.php';
require_once 'config.php'; // Para usar as constantes definidas

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

 // Recebe e limpa os dados
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $mensagem = trim($_POST['mensagem']);


     if (!empty($_POST['validacao'])) {
    header("Location: index.php?p=contato&status=sucesso");
    exit();
    }

    // Validação do reCAPTCHA
   // 1. Defina as chaves e a resposta
        $recaptcha_secret = "RECAPTCHA_SECRET"; // Sua chave secreta do reCAPTCHA
        $recaptcha_response = $_POST['g-recaptcha-response'];

        // 2. Prepare os dados para o POST (é mais seguro que mandar pela URL)
        $data = [
            'secret'   => $recaptcha_secret,
            'response' => $recaptcha_response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];

        // 3. Configure a requisição POST
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        // 4. Faz apenas UMA chamada ao servidor do Google
        $context  = stream_context_create($options);
        $verifyUrl = "https://www.google.com/recaptcha/api/siteverify";
        $verifyResponse = file_get_contents($verifyUrl, false, $context);

        // 5. Decodifica a resposta
        $captcha_success = json_decode($verifyResponse);

        // 6. Validação final
        if (!$captcha_success || $captcha_success->success == false) {
            // Se falhar ou se o usuário esqueceu de marcar a caixa
            header("Location: index.php?p=contato&status=erro_captcha");
            exit();
        }
    // Verifica se os campos estão realmente preenchidos
    if (empty($nome) || empty($email) || empty($mensagem)) {
        // Se algum estiver vazio, redireciona de volta com erro
        header("Location: index.php?p=contato&status=erro_campos_vazios");
        exit();
    }

    // Verifica se o e-mail é válido (formato nome@dominio.com)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: index.php?p=contato&status=email_invalido");
        exit();
    }
    // Verificação de Honeypot
   
    


    $mail = new PHPMailer(true);

    try {
        // 2. Configurações de Servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'SMTP_USER'; // Seu e-mail
        $mail->Password   = 'SMTP_PASS'; // Sua senha ou App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // 3. Destinatários
        $mail->setFrom('seu-email@gmail.com', 'The Course - Site');
        $mail->addAddress('viniciuspinheirotecnologia@gmail.com'); // Onde você quer receber os leads

        // 4. Conteúdo
     // ... após as configurações de SMTP ...

$mail->isHTML(true);
$mail->CharSet = 'UTF-8';
$mail->Subject = 'Novo Lead: Interesse em Aulas - ' . $nome;

// Montando o corpo do e-mail com HTML e CSS Inline
$mail->Body = "
    <div style='background-color: #f4f4f4; padding: 20px; font-family: sans-serif;'>
        <div style='max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);'>
            
            <div style='background-color: #002b5c; padding: 20px; text-align: center;'>
                <h1 style='color: #ffffff; margin: 0; font-size: 24px;'>The Course</h1>
                <p style='color: #d1d1d1; margin: 5px 0 0 0;'>Novo contato via formulário do site</p>
            </div>

            <div style='padding: 30px; color: #333333; line-height: 1.6;'>
                <h2 style='color: #002b5c; border-bottom: 2px solid #f4f4f4; padding-bottom: 10px;'>Dados do Interessado</h2>
                
                <p style='margin: 10px 0;'><strong>Nome:</strong> <span style='color: #555;'>{$nome}</span></p>
                <p style='margin: 10px 0;'><strong>E-mail:</strong> <a href='mailto:{$email}' style='color: #007bff; text-decoration: none;'>{$email}</a></p>
                
                <div style='margin-top: 20px; padding: 15px; background-color: #f9f9f9; border-left: 4px solid #002b5c;'>
                    <strong style='display: block; margin-bottom: 5px;'>Mensagem:</strong>
                    <span style='font-style: italic;'>\"{$mensagem}\"</span>
                </div>
            </div>

            <div style='background-color: #eeeeee; padding: 15px; text-align: center; font-size: 12px; color: #777777;'>
                Este e-mail foi gerado automaticamente pelo site The Course.<br>
                &copy; " . date('Y') . " The Course - Todos os direitos reservados.
            </div>
        </div>
    </div>
";

// Texto alternativo para leitores de e-mail antigos (sem HTML)
$mail->AltBody = "Novo contato de: $nome\nE-mail: $email\n\nMensagem:\n$mensagem";

$mail->send();
        // 5. Redirecionamento com sucesso
        header("Location: index.php?p=contato&status=sucesso");
        exit();

    } catch (Exception $e) {
        // Em caso de erro, você pode logar: $mail->ErrorInfo
        header("Location: index.php?p=contato&status=erro");
        exit();
    }
}