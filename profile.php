<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once "db_connection.php";
function formatDate($date) {
    $joinDate = new DateTime($date);
    $currentDate = new DateTime();
    $interval = $currentDate->diff($joinDate);

    $parts = [];
    if ($interval->y > 0) {
        $parts[] = $interval->y . ' year' . ($interval->y > 1 ? 's' : '');
    }
    if ($interval->m > 0) {
        $parts[] = $interval->m . ' month' . ($interval->m > 1 ? 's' : '');
    }
    if ($interval->d > 0) {
        $parts[] = $interval->d . ' day' . ($interval->d > 1 ? 's' : '');
    }elseif ($interval->h > 0) {
        $parts[] = $interval->d . ' hours' . ($interval->d > 1 ? 's' : '');
    }

    return implode(', ', $parts);
}

$username = $_GET['p'];
 $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
 $stmt->bind_param("s", $username);
 $stmt->execute();
 $result = $stmt->get_result();

 if ($user = $result->fetch_assoc()) {
    
 } else {
     $error = "User does not exist";
 }
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
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <a href="chat.php"><< Go back home</a>
        <h1>Profile of <?php echo $user['username']?></h1>
        <p>Email: <?php echo $user['email']?></p>
        <p>Member for <?echo formatDate($user['created_at']) ?></p>
    </div>
</body>
</html>


