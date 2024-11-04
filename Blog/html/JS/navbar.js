// navbar de navegação
const navbar = `
<div class="navbar">
    <nav>
        <a href="../php/index.php">Início</a>
        <a href="./Templates/envioartigos.html">Artigos</a>
        <a href="../aboutus.html">Sobre nós</a>

        <!-- Verificação do login -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="../php/logout.php" id="logout">Logout</a>
        <?php endif; ?>
    </nav>
</div>`;

document.getElementById("navbar").innerHTML = navbar;
