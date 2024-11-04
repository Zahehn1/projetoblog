<div class="navbar">
    <nav>
        <a href="../php/index.php">Início</a>
        <a href="../html/envioartigos.html">Artigos</a> 
        <a href="../html/aboutus.html">Sobre nós</a> 
        <?php if (isset($_SESSION['id'])): ?>
            <a href="../php/logout.php" id="logout">Logout</a>
        <?php else: ?>
            <a href="../php/index.php">Login</a>
        <?php endif; ?>
    </nav>
</div>
