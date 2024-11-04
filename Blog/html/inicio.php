<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../html/index.php");
    exit();
}

include('../php/conexao.php');
include('../php/protect.php');
include('../php/navbar.php');



$status_message = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'deleted') {
        $status_message = "Post apagado com sucesso!";
    }
} else if (isset($_GET['error']) && $_GET['error'] == 'unauthorized') {
    $status_message = "Você não tem permissão para realizar esta ação.";
}

$sql = "SELECT p.*, u.nome FROM posts p JOIN usuarios u ON p.user_id = u.id ORDER BY p.created_at DESC";
$result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto blog | Início</title>
    <link rel="stylesheet" href="./css/articles.css">
    <link rel="stylesheet" href="./css/navbar.css">

    <script>
        function toggleEdit(postId) {
            const postContent = document.getElementById(`post-content-${postId}`);
            const editForm = document.getElementById(`edit-form-${postId}`);
            const isEditing = editForm.style.display === 'block';
            postContent.style.display = isEditing ? 'block' : 'none';
            editForm.style.display = isEditing ? 'none' : 'block';
        }

        function toggleMenu(postId) {
            const menu = document.getElementById(`menu-${postId}`);
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
        }

        window.onclick = function(event) {
            if (!event.target.matches('.menu-button')) {
                const dropdowns = document.getElementsByClassName("dropdown-menu");
                for (let i = 0; i < dropdowns.length; i++) {
                    dropdowns[i].style.display = 'none';
                }
            }
        }
    </script>
</head>
<body>

    <header>
        <h1>Posts</h1>

        <?php if (!empty($status_message)): ?>
            <div class="status-message">
                <p><?php echo htmlspecialchars($status_message); ?></p>
            </div>
        <?php endif; ?>
    </header>
    
    <section id="posts">
        <?php while ($post = $result->fetch_assoc()): ?>
            <div class="post-container" id="post-<?php echo $post['id']; ?>">
                <div class="post-header">
                    <h2><?php echo htmlspecialchars($post['title']); ?></h2>
                    <?php if ($_SESSION['id'] == $post['user_id']): ?>
                        <div class="menu-container">
                            <button class="menu-button" onclick="toggleMenu(<?php echo $post['id']; ?>)">&#8942;</button>
                            <div class="dropdown-menu" id="menu-<?php echo $post['id']; ?>" style="display:none;">
                                <button onclick="toggleEdit(<?php echo $post['id']; ?>)">Editar</button>
                                <a href="../php/apagar_post.php?id=<?php echo $post['id']; ?>" onclick="return confirm('Tem certeza que deseja apagar este post?');">Excluir</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div id="post-content-<?php echo $post['id']; ?>">
                    <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                    <?php if (!empty($post['image_url'])): ?>
                        <img src="../<?php echo htmlspecialchars($post['image_url']); ?>" alt="Imagem do post" />
                    <?php endif; ?>
                    <p><small>Postado por <?php echo htmlspecialchars($post['nome']); ?> em <?php echo date('d/m/Y H:i', strtotime($post['created_at'])); ?></small></p>

                    <?php if (!empty($post['edited_at'])): ?>
                        <p><small>Editado em <?php echo date('d/m/Y H:i', strtotime($post['edited_at'])); ?></small></p>
                    <?php endif; ?>
                </div>

                <form method="POST" action="../php/editar_post.php?id=<?php echo $post['id']; ?>" style="display:none;" id="edit-form-<?php echo $post['id']; ?>">
                    <label for="title">Título:</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>

                    <label for="content">Conteúdo:</label>
                    <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea>

                    <button type="submit">Salvar Alterações</button>
                    <button type="button" onclick="toggleEdit(<?php echo $post['id']; ?>)">Cancelar</button>
                </form>
            </div>
            <hr>
        <?php endwhile; ?>
    </section>

    <section id="new-post">
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
</html>
