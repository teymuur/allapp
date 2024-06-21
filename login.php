<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'allapp');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_GET['login'])) {
    $username = $conn->real_escape_string($_GET['username']);
    $password = $_GET['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            setcookie('username', $user['username'], time() + (86400 * 30), '/');
            setcookie('password', $user['password'], time() + (86400 * 30), '/');
            header("Location: index.php");
            exit;
        } else {
            echo "<div class='error'>Invalid password.</div>";
        }
    } else {
        echo "<div class='error'>No user found.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" required><br>
            <label for="password">Password:</label>
            <input type="password" name="password" required><br>
            <input type="submit" value="Login" name="login">
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>

<?php
$conn->close();
?>
