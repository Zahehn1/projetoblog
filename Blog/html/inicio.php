<?php
session_start();
include('../php/conexao.php');

$sql = "SELECT p.*, u.nome FROM posts p JOIN usuarios u ON p.user_id = u.id ORDER BY p.created_at DESC";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto blog | Início</title>
    <link rel="stylesheet" href="../css/articles.css">
</head>
<body>

    <header>
        <nav id="navbar">
        </nav>
        <h1>Posts</h1>
    </header>
    
    <article>
        <?php while ($post = $result->fetch_assoc()): ?>
            <h2><?php echo htmlspecialchars($post['title']); ?></h2>
            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            <?php if (!empty($post['image_url'])): ?>
                <img src="../<?php echo htmlspecialchars($post['image_url']); ?>" alt="Imagem do post" />
            <?php endif; ?>
            <p><small>Postado por <?php echo htmlspecialchars($post['nome']); ?> em <?php echo date('d/m/Y H:i', strtotime($post['created_at'])); ?></small></p>
            <hr>
        <?php endwhile; ?>
    </article>

    <section>
        <h2>Faça uma nova postagem</h2>
        <form method="POST" action="../php/upload_post.php" enctype="multipart/form-data">
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" required>

            <label for="content">Conteúdo:</label>
            <textarea id="content" name="content" required></textarea>

            <label for="image">Imagem/GIF:</label>
            <input type="file" id="image" name="image" accept="image/*">

            <button type="submit">Postar</button>
        </form>
    </section>

</body>
<script src="navbar.js"></script>
</html>
