<?php 
include('conexao.php'); 


$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $mysqli->query($sql);

while ($post = $result->fetch_assoc()) {
    echo "<article>";
    echo "<h2>{$post['titulo']}</h2>";
    echo "<p>{$post['conteudo']}</p>";
    if ($post['imagem']) {
        echo "<img src='../uploads/{$post['imagem']}' alt='Imagem do post'>";
    }
    echo "<p>Postado por: {$post['usuario_id']} em {$post['created_at']}</p>"; 
    echo "</article>";
}

