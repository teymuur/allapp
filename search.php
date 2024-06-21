<?php
session_start();
include "nav.php";
if (!isset($_COOKIE['username'])) {
    header("Location: login.php");
    exit();
}
$conn = new mysqli('localhost', 'root', '', 'allapp');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){
    $searchterm = $_POST['search'];
    $sql = "SELECT * FROM users WHERE username LIKE '%$searchterm%'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $username = $row['username'];
            echo $row['username'] . " <a href=\"$username\" >See profile</a>";
        }
    }


}

