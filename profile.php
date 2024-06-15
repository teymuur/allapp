<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'allapp');

 if(!isset($_GET['u'])){
    $_username= $_COOKIE['username'];
 }else{
    $_username = $_GET['u'];
 }
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!isset($_COOKIE['username'])) {
    header("Location: login.php");
    exit();
}
$username = $_COOKIE['username'];
$user_id_query = "SELECT id FROM users WHERE username='$username'";
$myprofile = $username == $_username;

$user_id_result = $conn->query($user_id_query);
$user_id = $user_id_result->fetch_assoc()['id'];

$user_exists_query = "SELECT * FROM users WHERE username='$_username'";
$user_exists_result = $conn->query($user_exists_query);
if ($user_exists_result->num_rows > 0) {
    $row = $user_exists_result->fetch_assoc();
    $email = $row['email'];
    $pfp = $row['pfp'];
} else{
    echo "<div class='error'>User doesnt exist.</div";
}
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
    <title>Profile: <?php echo $_COOKIE['username']?></title>
</head>
<?php include 'nav.php';?>
<body>
    <div class="container">
    <img src="<?php echo $pfp ?>" alt="profile" >
    <h2>@<?php echo $_username?></h2>
    <h4>Email:  <?php echo $email ?></h4>
    <?php if($myprofile) :?>
        <h3>Update Profile</h3>
        <form method="post" action="updateprofile.inc.php">
        Udate Profile Picture: <input type="file" name="profile_picture" alt="">
        Update Birthday <input type="date" name="birthdate" id="">
        Update Gender  <select name="gender" id="gender">
        <option value="Prefer not to say">Prefer not to say</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Non-binary">Non-binary</option>
        <option value="Other">Other</option>

    </select>
    <input type="submit" >
        </form>
    <?php else:?>
        Gender: <?php echo $row['gender'];?><br>
        Birthday: <?php if(isset($row['birthdate'])){echo $row['birthdate'];} else{echo "not defined";}; ?>
        
    <?php endif;?>
    </div>

<div class="log">
<?php if ($myprofile): ?>
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

        <?php endif;?>
</div>

<script>
var temp = <?php echo $row['gender'];?>;
var mySelect = document.getElementById('gender');

for(var i, j = 0; i = mySelect.options[j]; j++) {
    if(i.value == temp) {
        mySelect.selectedIndex = j;
        break;
    }
}
</script>
</body>
</html>