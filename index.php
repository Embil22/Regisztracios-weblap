<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: bejelentkezve.html");
    exit;
}

echo "Szia, " . $_SESSION["username"] . "!";
?>
