<style>
    /* Container Principal da Política */
.container-politica {
    max-width: 900px;
    margin: 40px auto;
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0, 35, 102, 0.15);
    border: 1px solid #d1d9e6;
    overflow: hidden;
    font-family: Arial, sans-serif;
    color: #333;
}

/* Cabeçalho - Estilo Marinha e Vermelho */
.cabecalho-politica {
    background-color: #002366; /* Azul Marinho */
    color: #ffffff;
    padding: 40px 20px;
    text-align: center;
    position: relative;
}

.detalhe-bandeira {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 6px;
    background: linear-gradient(to right, #C8102E 50%, #ffffff 50%); /* Vermelho e Branco */
}

.cabecalho-politica h1 {
    margin: 0;
    font-size: 2rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.cabecalho-politica p {
    font-size: 0.9rem;
    margin-top: 10px;
    opacity: 0.9;
}

/* Seções Internas */
.secao-politica {
    padding: 25px 40px;
    border-bottom: 1px solid #eef2f7;
}

.secao-politica h2 {
    color: #002366;
    font-size: 1.3rem;
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.secao-politica h2 span {
    margin-right: 12px;
}

.secao-politica p {
    line-height: 1.7;
    margin-bottom: 10px;
}

/* Lista de Itens */
.lista-uso {
    padding-left: 20px;
}

.lista-uso li {
    margin-bottom: 8px;
    color: #444;
}

/* Grade de Direitos LGPD */
.grade-direitos {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-top: 20px;
}

.item-direito {
    flex: 1;
    min-width: 200px;
    background: #f4f7fa;
    padding: 15px;
    border-left: 4px solid #C8102E; /* Vermelho Union Jack */
    font-size: 0.85rem;
}

/* Rodapé */
.rodape-politica {
    background: #f8f9fc;
    padding: 20px;
    text-align: center;
    font-size: 0.85rem;
}

.rodape-politica a {
    color: #C8102E;
    text-decoration: none;
    font-weight: bold;
}

.rodape-politica a:hover {
    text-decoration: underline;
}

/* Ajustes para Celular */
@media (max-width: 600px) {
    .container-politica { margin: 20px 10px; }
    .secao-politica { padding: 20px; }
    .cabecalho-politica h1 { font-size: 1.5rem; }
}
</style>
<div class="container-politica">
    <header class="cabecalho-politica">
        <div class="detalhe-bandeira"></div>
        <h1>Política de Privacidade</h1>
        <p>Última atualização: 15 de abril de 2026</p>
    </header>

    <section class="secao-politica">
        <h2><span>🛡️</span> 1. Compromisso com a Privacidade</h2>
        <p>No <strong>The Course</strong>, valorizamos a sua confiança. Este documento explica como coletamos, usamos e protegemos suas informações pessoais ao interagir com nossa plataforma de ensino.</p>
    </section>

    <section class="secao-politica">
        <h2><span>📧</span> 2. Informações Coletadas</h2>
        <p>Quando você entra em contato pelo nosso site, coletamos seu <strong>Nome</strong> e <strong>E-mail</strong>. Esses dados são usados estritamente para:</p>
        <ul class="lista-uso">
            <li>Responder suas dúvidas específicas sobre os cursos.</li>
            <li>Fornecer suporte técnico sobre a plataforma.</li>
            <li>Enviar informações solicitadas sobre nossos programas de inglês.</li>
        </ul>
    </section>

    <section class="secao-politica">
        <h2><span>⚖️</span> 3. Seus Direitos (LGPD)</h2>
        <p>Em conformidade com a Lei Geral de Proteção de Dados (LGPD), você possui os seguintes direitos:</p>
        <div class="grade-direitos">
            <div class="item-direito"><strong>Acesso:</strong> Solicitar uma cópia dos seus dados.</div>
            <div class="item-direito"><strong>Exclusão:</strong> Pedir a remoção total das suas informações.</div>
            <div class="item-direito"><strong>Correção:</strong> Atualizar dados que estejam incorretos.</div>
        </div>
    </section>

    <section class="secao-politica">
        <h2><span>🔒</span> 4. Segurança dos Dados</h2>
        <p>Suas informações são transmitidas via criptografia <strong>HTTPS (SSL)</strong>. Nós não vendemos, trocamos ou transferimos seus dados para terceiros sob nenhuma circunstância.</p>
    </section>

    <footer class="rodape-politica">
    </footer>
</div>