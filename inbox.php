<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'allapp');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_COOKIE['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_COOKIE['username'];
$user_id_query = "SELECT id FROM users WHERE username='$username'";
$user_id_result = $conn->query($user_id_query);
$user_id = $user_id_result->fetch_assoc()['id'];

$messages_query = "SELECT m.message, u.username AS sender_username, m.timestamp 
                   FROM messages m 
                   JOIN users u ON m.sender_id = u.id 
                   WHERE m.receiver_id = '$user_id' 
                   ORDER BY m.timestamp DESC";

$messages_result = $conn->query($messages_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inbox</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php include "nav.php"?>
    <div class="container">
    
        <h2>Inbox</h2>
       
        <?php if ($messages_result->num_rows > 0): ?>
            <ul>
                <?php while($row = $messages_result->fetch_assoc()): ?>
                    <li>
                        <strong><?php echo $row['sender_username']; ?>:</strong>
                        <?php echo $row['message']; ?>
                        <br>
                        <small><?php echo $row['timestamp']; ?></small>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No messages.</p>
        <?php endif; ?>
        <a href="chat.php">Send a Message</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
