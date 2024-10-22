<?php
session_start();
include('conexao.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $mysqli->real_escape_string($_POST['title']);
    $content = $mysqli->real_escape_string($_POST['content']);
    $user_id = $_SESSION['id']; 
    $image_url = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = '../uploads/';
        $upload_file = $upload_dir . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_file)) {
            $image_url = 'uploads/' . basename($_FILES['image']['name']); 
        } else {
            echo "Erro ao fazer upload da imagem.";
        }
    }

    $sql = "INSERT INTO posts (user_id, title, content, image_url) VALUES ('$user_id', '$title', '$content', '$image_url')";
    if ($mysqli->query($sql)) {
        header("Location: ../html/inicio.php"); 
        exit();
    } else {
        echo "Erro ao inserir post: " . $mysqli->error;
    }
}

