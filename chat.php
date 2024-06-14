<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'allapp');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$sender_id_query = "SELECT id FROM users WHERE username='$username'";
$sender_id_result = $conn->query($sender_id_query);
$sender_id = $sender_id_result->fetch_assoc()['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send'])) {
    $receiver_username = $conn->real_escape_string($_POST['receiver_username']);
    $message = $conn->real_escape_string($_POST['message']);

    $receiver_id_query = "SELECT id FROM users WHERE username='$receiver_username'";
    $receiver_id_result = $conn->query($receiver_id_query);

    if ($receiver_id_result->num_rows > 0) {
        $receiver_id = $receiver_id_result->fetch_assoc()['id'];

        $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ('$sender_id', '$receiver_id', '$message')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Message sent!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "No user found with that username.";
    }
}

$messages_query = "SELECT m.message, u.username AS sender_username, m.timestamp 
                   FROM messages m 
                   JOIN users u ON m.sender_id = u.id 
                   WHERE (m.sender_id = '$sender_id') 
                     
                   ORDER BY m.timestamp DESC";
$messages_result = $conn->query($messages_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<?php include "nav.php"?>
    <div class="container">
         
        <h2>Send a Message</h2>
        <form method="post" action="">
            <label for="receiver_username">Receiver Username:</label>
            <input type="text" name="receiver_username" required><br>
            <label for="message">Message:</label>
            <textarea name="message" required></textarea><br>
            <button type="submit" name="send">Send</button>
        </form>
        
        <h2>Message Log</h2>
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
        <?php elseif(isset($receiver_username)): ?>
            <p>No messages with <?php echo htmlspecialchars($receiver_username); ?>.</p>
        <?php endif; ?>
        <a href="inbox.php">Go to Inbox</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
