<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "db_connection.php";
$user = $_GET['p']
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile </title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <a href="chat.php"><< Go back home</a>
        <h1>Profile of <?php echo $user?></h1>
    </div>
</body>
</html>


