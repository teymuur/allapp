<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'allapp');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    $gender = $_GET['gender'];
    $birthdate = $_GET['birthdate'];

    // Assuming $username is the logged-in user's username
    $username = $_SESSION['username'];

    if (isset($_GET['birthdate'])) {
        $query = "UPDATE users SET birthdate = ? WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $birthdate, $username);
        $stmt->execute();
    }

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $query = "UPDATE users SET pfp = ? WHERE username = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $target_file, $username);
            $stmt->execute();
        }
    }

    if (isset($_GET['gender'])) {
        $query = "UPDATE users SET gender = ? WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $gender, $username);
        $stmt->execute();
    }

    // Redirect to the profile page or show a success message
    header("Location: profile.php?u=".$username);
    exit();



?>
