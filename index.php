<?php
session_start();

if (!isset($_COOKIE['username'])) {
    header("Location: login.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php include "nav.php"?>
    <div class="container">
        <h2><?php echo "Welcome, " . $_COOKIE['username'] . "!";?></h2>
        <p>You have successfully logged in!</p>
     
        <a href="chat.php"><button>Chat</button></a>
        <a href="inbox.php"><button>Inbox</button></a>
        <a href="logout.inc.php"><button>Logout</button></a>

    </div>
</body>
</html>
