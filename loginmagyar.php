<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Lekérdezés
    $stmt = $conn->prepare("SELECT id, jelszo FROM register WHERE felhasznalonev = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo "Hibás felhasználónév vagy jelszó!";
        exit;
    }

    $stmt->bind_result($id, $hashedPassword);
    $stmt->fetch();

    // Jelszó ellenőrzés
    if (password_verify($password, $hashedPassword)) {
        $_SESSION["user_id"] = $id;
        $_SESSION["username"] = $username;

        echo "Sikeres bejelentkezés!";
        header("Location: bejelentkezvemagyar.html");
    } else {
        echo "Hibás felhasználónév vagy jelszó!";
        header("Location: hibasmagyar.html");
    }
}
?>
