<?php
// Define qual página carregar. Se não houver parâmetro 'p', carrega a home.
$pagina = isset($_GET['p']) ? $_GET['p'] : 'home';

// Proteção básica: verifica se o arquivo existe antes de incluir
$arquivo = "paginas/{$pagina}.php";
if (!file_exists($arquivo)) {
    $arquivo = "paginas/home.php";
}

include 'header.php'; // Carrega o topo
include $arquivo;    // Carrega o conteúdo dinâmico
include 'footer.php'; // Carrega o rodapé
?>