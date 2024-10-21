<?php 
session_start();
include('conexao.php');

$email_input = ''; // Variável para manter o valor do e-mail

if (isset($_POST['email']) || isset($_POST['senha'])) {
    if (strlen($_POST['email']) == 0) {
        echo "Preencha seu E-mail";
    } else if (strlen($_POST['senha']) == 0) {
        echo "Preencha sua senha";
    } else {
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);
        
        $sql_code = "SELECT * FROM usuarios WHERE EMAIL = '$email' AND SENHA = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
        $quantidade = $sql_query->num_rows;

        if ($quantidade == 1) {
            $usuario = $sql_query->fetch_assoc();

            if (!isset($_SESSION)) {
                session_start();
            }

            $_SESSION['id'] = $usuario['id'];
            $_SESSION['name'] = $usuario['nome'];

            header("Location: ../html/inicio.html");
            exit();
        } else {
            echo "Falha ao logar! E-mail ou senha incorretos";
            $email_input = $_POST['email']; // Armazenar o e-mail digitado
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Projeto blog | Login</title>
</head>
<body>
    <main>
        <section>
            <legend>Realize o seu login.
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
                </form>
            </legend>
        </section>
    </main>
</body>
</html>
