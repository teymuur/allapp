<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'allapp');
$_username = $_GET['username'];
 if(!$_GET['username']){
    $_username= $_SESSION['username'];
 }
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION['username'];
$user_id_query = "SELECT id FROM users WHERE username='$username'";
if($username != $_username){
    echo 1;
    echo "<style>#log: {display: None}</style>";
}
$user_id_result = $conn->query($user_id_query);
$user_id = $user_id_result->fetch_assoc()['id'];

$messages_query = "SELECT m.message, u.username AS receiver_username, m.timestamp 
                   FROM messages m 
                   JOIN users u ON receiver_id = u.id 
                   WHERE m.sender_id = '$user_id' 
                   ORDER BY m.timestamp DESC";

$messages_result = $conn->query($messages_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Profile: <?php echo $_SESSION['username']?></title>
</head>
<?php include 'nav.php';?>
<body>
    <div class="container">

    
    </div>

<div class="log">
<h2 >Message Log</h2>
        <?php if ($messages_result->num_rows > 0): ?>
            <ul>
                <?php while($row = $messages_result->fetch_assoc()): ?>
                    <li>
                        <strong>to <?php echo $row['receiver_username']; ?>:</strong>
                        <?php echo $row['message']; ?>
                        <br>
                        <small><?php echo $row['timestamp']; ?></small>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php elseif(isset($receiver_username)): ?>
            <p>No messages with <?php echo htmlspecialchars($receiver_username); ?>.</p>
        <?php endif; ?>
</div>
</body>
</html>