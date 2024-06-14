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
    
</body>
</html>