<?php
session_start();
include('conexao.php');

if (isset($_GET['id']) && isset($_SESSION['id'])) {
    $post_id = $_GET['id'];
    $user_id = $_SESSION['id'];

    $sql = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ii', $post_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();

    if (!$post) {
        echo "Post não encontrado ou você não tem permissão para editá-lo.";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $mysqli->real_escape_string($_POST['title']);
        $content = $mysqli->real_escape_string($_POST['content']);

        $sql_update = "UPDATE posts SET title = ?, content = ?, edited_at = NOW() WHERE id = ? AND user_id = ?";
        $stmt_update = $mysqli->prepare($sql_update);
        $stmt_update->bind_param('ssii', $title, $content, $post_id, $user_id);

        if ($stmt_update->execute()) {
            header("Location: ../html/inicio.php");
            exit();
        } else {
            echo "Erro ao atualizar o post.";
        }
    }
} else {
    echo "ID do post ou usuário não autenticado.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Post</title>
    <link rel="stylesheet" href="../css/editArticle.css"> 
</head>
<body>
    <div class="article-editor-container"> 
        <h2>Editar Post</h2>
        <form method="POST">
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required class="input-title"> 

            <label for="content">Conteúdo:</label>
            <textarea id="content" name="content" required class="textarea-content"><?php echo htmlspecialchars($post['content']); ?></textarea> 

            <button type="submit" class="submit-button">Salvar Alterações</button> 
        </form>
    </div>
</body>
</html>
