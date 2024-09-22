<?php

if($_SERVER["REQUEST_METHOD"]="POST"){
    $username = htmlspecialchars($_POST["username"]);
    $pwd = htmlspecialchars($_POST["pwd"]);
    $email = htmlspecialchars($_POST["email"]);
    $birthdate = htmlspecialchars($_POST["birthdate"]);

    try {
        require_once "dbh-inc.php";

        $checkQuery = "SELECT COUNT(*) FROM users WHERE email = ?";
        $checkStmt = $pdo->prepare($checkQuery);
        $checkStmt->execute([$email]);
        $emailCount = $checkStmt->fetchColumn();

        if ($emailCount > 0) {
            // Email already exists
            die("Error: Email already exists in the database.");
        }

        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, pwd, email, birthdate) VALUES (?, ?, ?, ?);";

        $stmt = $pdo->prepare($query);

        $stmt->execute([$username, $hashedPwd, $email, $birthdate]);

        $pdo = null;
        $stmt = null;

        header("Location: ../index.php?signup=success");
        exit();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
else {
    header("Location: ../database.php");
    exit();
}