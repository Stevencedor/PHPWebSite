<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    try {
        require_once "dbh-inc.php";

        $query = "SELECT id, pwd FROM users WHERE email = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$email]);

        if ($user = $stmt->fetch()) {
            if (password_verify($pwd, $user['pwd'])) {
                $_SESSION['user_id'] = $user['id'];
                header("Location: ../database.php");
                exit();
            }
        }
        header("Location: ../index.php?error=invalid_credentials");
        exit();
    } catch (PDOException $e) {
        die("Query fallida: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    exit();
}