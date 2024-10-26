<?php 
session_start();
include('conexao.php');


$email_input = ''; 
$error_message = '';

if (isset($_POST['email']) || isset($_POST['senha'])) {
    if (strlen($_POST['email']) == 0) {
        $error_message = "Preencha seu E-mail";
    } else if (strlen($_POST['senha']) == 0) {
        $error_message = "Preencha sua senha";
    } else {
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);
        
        $sql_code = "SELECT * FROM usuarios WHERE EMAIL = '$email' AND SENHA = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        $quantidade = $sql_query->num_rows;

        if ($quantidade == 1) {
            $usuario = $sql_query->fetch_assoc();

            // Verifica se a sessão já foi iniciada
            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['name'] = $usuario['nome'];
            header("Location: ../html/inicio.php");
            exit();
        } else {
            $error_message = "Falha ao logar! E-mail ou senha incorretos";
            $email_input = $_POST['email']; 
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../html/css/login.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <title>Projeto blog | Login</title>
</head>
<body>
    <main>
        <section>
            <h2>Faça seu login</h2>
            <div class="error-message" style="display: <?php echo !empty($error_message) ? 'block' : 'none'; ?>;">
                <?php echo $error_message; ?>
            </div>
            <form method="POST" action="">
                <div class="input-container">
                    <input id="email" name="email" type="email" placeholder=" " required value="<?php echo htmlspecialchars($email_input); ?>">
                    <label for="email">Digite seu e-mail</label>
                </div>

                <div class="input-container">
                    <input id="password" name="senha" type="password" placeholder=" " required>
                    <label for="password">Digite sua senha</label>
                </div>
                <button type="submit">Fazer login</button>
                <div class="forgot-password">
                    <a href="../html/esqueceu_senha.html">Esqueceu a senha?</a>
                </div>
                <div class="register-link">
                    <a href="register.php">Cadastre-se aqui</a>
                </div>
            </form>
        </section>
    </main>
    <script src="../JS/navbar.js"></script>
</body>
</html>
