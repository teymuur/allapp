<?php
session_start();
require_once 'db_connection.php';

if (isset($_SESSION['user_id']) && isset($_GET['receiver_id'])) {
    $user_id = $_SESSION['user_id'];
    $receiver_id = $_GET['receiver_id'];

    $stmt = $conn->prepare("SELECT m.*, u.username FROM messages m JOIN users u ON m.sender_id = u.id WHERE (m.sender_id = ? AND m.receiver_id = ?) OR (m.sender_id = ? AND m.receiver_id = ?) ORDER BY m.sent_at ASC");
    $stmt->bind_param("iiii", $user_id, $receiver_id, $receiver_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        echo "<p><strong>" . $row['username'] . ":</strong> " . $row['message'] . "</p>";
    }
}