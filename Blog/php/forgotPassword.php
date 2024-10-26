<?php 
include('conexao.php');
include('protect.php');

$erro = []; 

if (isset($_POST['ok'])) {
    $email = $mysqli->escape_string($_POST['email']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro[] = "E-mail inválido.";
    }

    $sql_code = "SELECT * FROM usuarios WHERE email = '$email'";
    $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);
    $quantidade = $sql_query->num_rows;

    if ($quantidade == 0) {
        $erro[] = "O e-mail informado não existe.";
    }

    if (count($erro) == 0 && $quantidade > 0) {
        $novasenha = substr(md5(time()), 0, 6);
        $nscriptografada = md5($novasenha); 

        if (mail($email, "Sua nova senha", "Sua nova senha temporária é: " . $novasenha)) {
            $sql_code = "UPDATE usuarios SET senha = '$nscriptografada' WHERE email = '$email'";
            $mysqli->query($sql_code) or die($mysqli->error);
            echo "Uma nova senha foi enviada para o seu e-mail.";
        } else {
            $erro[] = "Falha ao enviar o e-mail.";
        }
    }
    if (count($erro) > 0) {
        foreach ($erro as $e) {
            echo "<p>$e</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar senha</title>
</head>
<body>
<form action="" method="POST">
   <input placeholder="Seu E-mail" name="email" type="text" required>
   <input name="ok" value="Enviar" type="submit">
</form>
</body>
</html>
