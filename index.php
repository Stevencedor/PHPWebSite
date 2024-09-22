<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Salle DB - User Authentication</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 1rem;
            box-sizing: border-box;
        }

        h1, h3 {
            text-align: center;
            color: #333;
            margin-bottom: 1rem;
        }

        .auth-options {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
        }

        .auth-option {
            flex: 1;
            padding: 1rem;
            text-align: center;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .auth-option:hover {
            background-color: #0056b3;
        }

        form {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 0.5rem 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            box-sizing: border-box;
            transition: border 0.3s ease;
        }

        input:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 1rem;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2rem;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        @media (max-width: 600px) {
            .container {
                padding: 1rem;
            }

            input, button {
                font-size: 1rem;
            }

            table {
                font-size: 0.8rem;
            }

            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to La Salle DB</h1>
        
        <div class="auth-options">
            <a href="#" class="auth-option" onclick="showForm('login')">Login</a>
            <a href="#" class="auth-option" onclick="showForm('signup')">Sign Up</a>
        </div>

        <form id="loginForm" action="includes/login.php" method="post" style="display: none;">
            <h3>Login</h3>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="pwd" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <form id="signupForm" action="includes/fromhandler.php" method="post" style="display: none;">
            <h3>Sign Up</h3>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="pwd" placeholder="Password" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="date" name="birthdate" placeholder="Birth Date" required>
            <button type="submit">Sign Up</button>
        </form>

        <?php
        session_start();
        if (isset($_SESSION['user_id'])) {
            echo "<h3>User Data</h3>";
            echo "<table>
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Birth Date</th>
                            <th>Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>";
            
            try {
                require_once "includes/dbh-inc.php";

                $query = "SELECT username, email, birthdate, created_at FROM users ORDER BY created_at DESC";
                $stmt = $pdo->prepare($query);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['birthdate']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                    echo "</tr>";
                }

                $pdo = null;
                $stmt = null;
            } catch (PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }

            echo "</tbody></table>";
        }
        ?>
    </div>

    <script>
        function showForm(formType) {
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('signupForm').style.display = 'none';
            document.getElementById(formType + 'Form').style.display = 'flex';
        }
    </script>
</body>
</html>