// navbar.js

const navbarHTML = `
    <div class="navbar">
        <nav>
            <a href="../php/index.php">Início</a>
            <a href="../Templates/envioartigos.html">Artigos</a>
            <a href="../aboutus.html">Sobre nós</a>
            ${sessionStorage.getItem("userLoggedIn") ? '<a href="../php/logout.php">Logout</a>' : '<a href="../php/index.php">Login</a>'}
        </nav>
    </div>
`;

document.addEventListener("DOMContentLoaded", () => {
    const navbarContainer = document.getElementById("navbar");
    if (navbarContainer) {
        navbarContainer.innerHTML = navbarHTML;
    }
});
