<?php

// 1. Importação dos arquivos
require 'lib/Exception.php';
require 'lib/PHPMailer.php';
require 'lib/SMTP.php';
require_once 'config.php'; // Para usar as constantes definidas

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (!isset($_POST['privacyCheck'])) {
    die("Você precisa aceitar a política de privacidade.");
}

 // Recebe e limpa os dados
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $mensagem = trim($_POST['mensagem']);


     if (!empty($_POST['validacao'])) {
    header("Location: index.php?p=contato&status=sucesso");
    exit();
    }

    // Validação do reCAPTCHA
       // 1. Recupere o token (você já viu que ele existe!)
    $token = $_POST['g-recaptcha-response'] ?? '';

    // 2. Sua CHAVE SECRETA (Confirme se é a 'Secret Key' no painel do Google)
    $secret = RECAPTCHA_SECRET; // Use a constante definida no config.php

    // 3. Preparando a chamada via POST de forma simplificada
    $dados = [
        'secret'   => $secret,
        'response' => $token,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $opcoes = [
        'http' => [
            'method'  => 'POST',
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($dados)
        ]
    ];

    $contexto = stream_context_create($opcoes);
    $resultado = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $contexto);
    $respostaFinal = json_decode($resultado);

    // 4. Teste definitivo
    if ($respostaFinal && $respostaFinal->success) {
        // SUCESSO! Prossiga com o envio do e-mail
    } else {
        // Se caiu aqui, dê um var_dump($respostaFinal) para ver o erro exato do Google
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
        $mail->Username   = SMTP_USER; // Seu e-mail
        $mail->Password   = SMTP_PASS; // Sua senha ou App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // 3. Destinatários
        $mail->setFrom(SMTP_USER, 'The Course - Site');
        $mail->addAddress(SMTP_USER);
        $mail->addReplyTo($email, $nome);

        // 4. Conteúdo
     // ... após as configurações de SMTP ...

$mail->isHTML(true);
$mail->CharSet = 'UTF-8';
$mail->Subject = 'Novo Lead: Interesse em Aulas - ' . $nome;
// No e-mail que vai para VOCÊ:
$mail->addReplyTo($email, $nome); // Se você clicar em "Responder", vai para o aluno

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

if($mail->send()) {
        // 5. Redirecionamento com sucesso
    $mail->clearAddresses(); // LIMPA O SEU E-MAIL DOS DESTINATÁRIOS
    $mail->addAddress($email, $nome); // ADICIONA O E-MAIL DO ALUNO
    
    $mail->Subject = 'Recebemos sua mensagem! - The Course';
    $mail->Body = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;'>
                <div style='background-color: #002b5c; color: #ffffff; padding: 20px; text-align: center;'>
                    <h1 style='margin: 0; font-size: 24px;'>The Course</h1>
                </div>
                <div style='padding: 30px; color: #333333; line-height: 1.6;'>
                    <p style='font-size: 18px;'>Olá, <strong>{$nome}</strong>!</p>
                    <p>Obrigado por entrar em contato com o <strong>The Course</strong>.</p>
                    <p>Nossa equipe já recebeu sua mensagem e estamos analisando sua solicitação. Faremos o possível para retornar em até <strong>24 horas úteis</strong>.</p>
                    <div style='background-color: #f9f9f9; border-left: 4px solid #002b5c; padding: 15px; margin: 20px 0;'>
                        <p style='margin: 0; font-style: italic; color: #666;'>
                            \"A educação é a arma mais poderosa que você pode usar para mudar o mundo.\"
                        </p>
                    </div>
                    <p style='margin-top: 30px;'>Atenciosamente,<br>
                    <strong>Equipe de Suporte | The Course</strong></p>
                </div>
                <div style='background-color: #f4f4f4; color: #888888; padding: 15px; text-align: center; font-size: 12px;'>
                    <p style='margin: 0;'>© " . date('Y') . " The Course. Este é um e-mail automático.</p>
                </div>
            </div>";
    
    $mail->AltBody = "Olá, $nome!\n\nObrigado por entrar em contato com o The Course. Nossa equipe já recebeu sua mensagem e estamos analisando sua solicitação. Faremos o possível para retornar em até 24 horas úteis.\n\nAtenciosamente,\nEquipe de Suporte | The Course";
    // Tenta enviar a resposta para o aluno
    $mail->send(); 

    // --- FIM DO BLOCO DE RESPOSTA AUTOMÁTICA ---

    // Redireciona para sucesso após os dois envios
   header("Location: index.php?p=contato&status=sucesso");
        exit();
    }

    } catch (Exception $e) {
    // Em caso de erro técnico no PHPMailer
    header("Location: index.php?p=contato&status=erro");
    exit();
    }
}