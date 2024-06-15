
<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'allapp');
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $gender = $_POST['gender'];
    $profile_picture = $_FILES['profile_picture'];
    $birthdate = $_POST['birthdate'];

    // Assuming $user_id is the logged-in user's ID
    $username = $_SESSION['username'];

    // Update the user's profile with the new data
    $query = "UPDATE users SET gender = $gender, profile_picture = ?, birthdate = $birthdate WHERE username= $username";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$gender, $profile_picture['tmp_name'], $birthdate, $user_id]);

    // Redirect to the profile page or show a success message
    header("Location: profile.php");
    exit();
}
?>
