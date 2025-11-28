<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Ellenőrizzük, létezik-e már
    $stmt = $conn->prepare("SELECT id FROM register WHERE felhasznalonev = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Der Benutzername oder die E-Mail-Adresse existiert bereits.";
        exit;
    }

    // Jelszó hash
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Mentés
    $stmt = $conn->prepare("INSERT INTO register (felhasznalonev, email, jelszo) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed);

    if ($stmt->execute()) {
        echo "Erfolgreiche Registrierung!";
    } else {
        echo "Es ist ein Fehler aufgetreten!";
    }
}
?>