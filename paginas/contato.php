<?php
// Captura o status da URL (ex: ?p=contato&status=sucesso)
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>
<section style="padding: 60px 10%;">
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="color: var(--navy);">Prepare-se para o Próximo Nível</h1>
        <p>Preencha os dados abaixo e nossa equipe entrará em contato em até 24h.</p>
    </div>
    <?php if ($status == 'erro_vazio'): ?>
    <div class="alert alert-warning">Por favor, preencha todos os campos antes de enviar.</div>
    <?php endif; ?>

    <?php
    // Captura o status da URL
    $status = $_GET['status'] ?? '';

    if ($status == 'sucesso'): ?>
        <div style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #c3e6cb;">
            <strong>Sucesso!</strong> Sua mensagem foi enviada. Em breve entrarei em contato.
        </div>

    <?php elseif ($status == 'erro_captcha'): ?>
        <div style="background-color: #fff3cd; color: #856404; padding: 15px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #ffeeba;">
            <strong>Atenção:</strong> Por favor, confirme que você não é um robô marcando a caixa de seleção.
        </div>

    <?php elseif ($status == 'erro'): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 15px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #f5c6cb;">
            <strong>Erro:</strong> Ocorreu um problema ao enviar o e-mail. Tente novamente mais tarde.
        </div>
    <?php endif; ?>



    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 40px;">
        
        <form action="enviar.php" method="POST" style="background: #f9f9f9; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
            <div style="margin-bottom: 15px;">
                <h3>Entre em contato via e-mail.</h3><br>
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Nome Completo</label>
                <input type="text" name="nome" placeholder="Ex: João Silva" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">E-mail</label>
                <input type="email" name="email" placeholder="seu@email.com" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required>
            </div>
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 5px; font-weight: bold;">Mensagem</label>
                <textarea name="mensagem" rows="4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;" required></textarea>
            </div>
            <button type="submit" class="btn-cta" style="width: 100%; border: none; cursor: pointer;">Enviar</button>
                    <div style="display: none;">
                        <!-- Validção anti-spam (honeypot) -->
                        <label>Se você é humano, deixe este campo vazio:</label>
                        <input type="text" name="validacao" value="">
                    </div>

                         <!-- ReCAPTCHA -->
                <script src="https://www.google.com/recaptcha/api.js" async defer></script>

                <form action="enviar.php" method="POST">
                <div class="g-recaptcha" data-sitekey="6LeQxrcsAAAAAKU7t9BvqiSO0TE9tgc61EmnrDSO"></div>
                 </form>
        </form>
               

        <div style="display: flex; flex-direction: column; justify-content: center;">
            <h3 style="color: var(--red); margin-bottom: 15px;">Onde estamos</h3>
            <p><strong>Endereço:</strong>  Rua Valentim, 88 - Nova Angra</p>
            <p><strong>Horário de Atendimento:</strong> Segunda a Sexta, das 9h às 18h</p>
            <br>
            <p><a href="https://www.instagram.com/thecourseangra/" target="_blank"><img src="imagens/instagram.png" alt="Instagram" style="width: 20px;"></a>
            <a href="https://api.whatsapp.com/send/?phone=5524988164351&text=Ol%C3%A1%2C+tenho+interesse+no+curso+de+ingl%C3%AAs.+Poderia+me+falar+mais+sobre+ele&type=phone_number&app_absent=0" target="_blank" rel="noopener noreferrer"><img src="imagens/whatsapp.png" alt="WhatsApp" style="width: 20px;"></a>
            </p>
            <div style="margin-top: 20px; padding: 20px; border-left: 4px solid var(--navy); background: #eee;">
                <p><em>"O limite da minha linguagem significa o limite do meu mundo."</em></p>
            </div>
        </div>
    </div>
</section>