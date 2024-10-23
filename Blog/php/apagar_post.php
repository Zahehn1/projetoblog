<?php
session_start();
include('conexao.php');

if (isset($_GET['id']) && isset($_SESSION['id'])) {
    $post_id = $_GET['id'];
    $user_id = $_SESSION['id'];

    $sql = "DELETE FROM posts WHERE id = ? AND user_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ii', $post_id, $user_id);

    if ($stmt->execute()) {
        header("Location: ../html/inicio.php");
        exit();
    } else {
        echo "Erro ao apagar o post.";
    }
} else {
    echo "ID do post ou usuário não autenticado.";
}

