<?php
include('conexao.php'); 

$sql = "SELECT posts.*, usuarios.nome FROM posts JOIN usuarios ON posts.user_id = usuarios.id ORDER BY created_at DESC";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<article>';
        echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
        echo '<p>' . htmlspecialchars($row['content']) . '</p>';
        if ($row['image_url']) {
            echo '<img src="' . htmlspecialchars($row['image_url']) . '" alt="Post Image">';
        }
        echo '<p>Postado por ' . htmlspecialchars($row['nome']) . ' em ' . $row['created_at'] . '</p>';
        echo '</article>';
    }
} else {
    echo '<p>Nenhum post encontrado.</p>';
}
?>
