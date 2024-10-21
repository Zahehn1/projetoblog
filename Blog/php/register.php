<?php 
session_start();
include('conexao.php');

$email_input = '';
$senha_input = '';
$nome_input = '';
$error_message = '';

if (isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['nome'])) {
    if (strlen($_POST['nome']) == 0) {
        $error_message = "Preencha seu nome";
    } else if (strlen($_POST['email']) == 0) {
        $error_message = "Preencha seu E-mail";
    } else if (strlen($_POST['senha']) == 0) {
        $error_message = "Preencha sua senha";
    } else {
        $nome = $mysqli->real_escape_string($_POST['nome']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM usuarios WHERE EMAIL = '$email'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

        if ($sql_query->num_rows > 0) {
            $error_message = "E-mail já cadastrado!";
        } else {
            $sql_code = "INSERT INTO usuarios (NOME, EMAIL, SENHA) VALUES ('$nome', '$email', '$senha')";
            if ($mysqli->query($sql_code)) {
                $success_message = "Cadastro realizado com sucesso!";
                header("Location: index.php");
                exit();
            } else {
                $error_message = "Erro ao cadastrar: " . $mysqli->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../html/css/register.css">
    <title>Projeto blog | Cadastro</title>
</head>
<body>
    <main>
        <section>
            <h2>Faça seu cadastro</h2>
            <div class="error-message">
                <?php if (!empty($error_message)) { echo $error_message; } ?>
                <?php if (!empty($success_message)) { echo $success_message; } ?>
            </div>
            <form method="POST" action="">
                <div class="input-container">
                    <input id="nome" name="nome" type="text" placeholder=" " required value="<?php echo htmlspecialchars($nome_input); ?>">
                    <label for="nome">Digite seu nome</label>
                </div>

                <div class="input-container">
                    <input id="email" name="email" type="email" placeholder=" " required value="<?php echo htmlspecialchars($email_input); ?>">
                    <label for="email">Digite seu e-mail</label>
                </div>
                
                <div class="input-container">
                    <input id="password" name="senha" type="password" placeholder=" " required value="<?php echo htmlspecialchars($senha_input); ?>">
                    <label for="password">Digite sua senha</label>
                </div>
                <button type="submit">Cadastrar</button>
                <div class="login-link">
                    <a href="index.php">Já possui uma conta? Faça login</a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
