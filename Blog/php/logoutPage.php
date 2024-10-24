<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="../css/logout.css">
</head>
<body>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form method="POST">
            <button type="submit" name="logout">Logout</button>
        </form>
    <?php endif; ?>

</body>
</html>

<?php

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
?>
