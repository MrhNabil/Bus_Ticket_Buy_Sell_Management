<?php
session_start();
include 'db.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if username already exists
    $checkUserSql = "SELECT * FROM Users WHERE username='$username'";
    $result = $conn->query($checkUserSql);

    if ($result->num_rows > 0) {
        $error = "Username already taken. Please choose another one.";
    } else {
        $sql = "INSERT INTO Users (username, password) VALUES ('$username', '$password')";

        if ($conn->query($sql) === TRUE) {
            $success = "Registration successful. You can now <a href='login.php'>login</a>.";
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Register</h1>
        <nav>
            <ul>
            <li><a href="login.php">Login</a></li>
            </ul>
    </header>
    <main>
        <form method="post" action="register.php">
            <div>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Register</button>
            <?php
            if ($error) {
                echo "<p style='color:red;'>$error</p>";
            } elseif ($success) {
                echo "<p style='color:green;'>$success</p>";
            }
            ?>
        </form>
    </main>
</body>
</html>
