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
        echo "A felhasználónév vagy email már létezik.";
        exit;
    }

    // Jelszó hash
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Mentés
    $stmt = $conn->prepare("INSERT INTO register (felhasznalonev, email, jelszo) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed);
}
?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css">
    <title>Regisztrálva</title>
</head>

<body>
    <div class="container">
        <div class="logo">
            <img src="logo.png" alt="logo">
        </div>
        <h1>Sikeres regisztráció!</h1>
    </div>
</body>

</html>