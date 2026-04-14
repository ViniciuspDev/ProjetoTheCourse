<footer>
        <div style="margin-bottom: 10px;">
            
            <img  onclick="window.location.href='index.php'" src="imagens/logo_footer.png" alt="The Course" style="cursor: pointer; height: 50px;">
        </div>
        <p>&copy; <?php echo date('Y'); ?> <strong>The Course</strong> - English School.</p>
        <p><small>Aprenda o inglês da vida real, sem fronteiras.</small></p>
    </footer>

    <script>
    const menuToggle = document.getElementById('mobile-menu');
    const navMenu = document.getElementById('nav-menu');

    if (menuToggle && navMenu) {
        menuToggle.onclick = function() {
            navMenu.classList.toggle('active');
            menuToggle.classList.toggle('is-active'); // Adiciona a animação do X
        };
    }
</script>
</body>

</html>