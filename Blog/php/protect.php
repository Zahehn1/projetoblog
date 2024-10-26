<?php
if (!isset($_SESSION)) {
    session_start();
}

function protect() {
    if (!isset($_SESSION['id'])) {
        header("Location: index.php");
        exit(); 
    }
}
?>
