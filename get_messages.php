<?php
session_start();
require_once 'db_connection.php';

function formatDate($date) {
    $now = new DateTime();
    $date = new DateTime($date);
    $diff = $now->diff($date);

    if ($diff->d == 0) {
        if ($diff->h == 0 && $diff->i < 60) {
            return $diff->i . ' minutes ago';
        } else {
            return 'Today at ' . $date->format('H:i');
        }
    } elseif ($diff->d == 1) {
        return 'Yesterday at ' . $date->format('H:i');
    } else {
        return $date->format('M j, Y') . ' at ' . $date->format('H:i');
    }
}

if (isset($_SESSION['user_id']) && isset($_GET['receiver_id'])) {
    $user_id = $_SESSION['user_id'];
    $receiver_id = $_GET['receiver_id'];

    $stmt = $conn->prepare("SELECT m.*, u.username, DATE(m.sent_at) as message_date FROM messages m JOIN users u ON m.sender_id = u.id WHERE (m.sender_id = ? AND m.receiver_id = ?) OR (m.sender_id = ? AND m.receiver_id = ?) ORDER BY m.sent_at ASC");
    $stmt->bind_param("iiii", $user_id, $receiver_id, $receiver_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $current_date = null;
    while ($row = $result->fetch_assoc()) {
        if ($current_date !== $row['message_date']) {
            if ($current_date !== null) {
                echo "</div>"; // Close previous date div
            }
            $current_date = $row['message_date'];
            echo "<div class='message-date'>" . (new DateTime($current_date))->format('F j, Y') . "</div>";
            echo "<div class='message-group'>";
        }
        echo "<div class='message'>";
        echo "<span class='username'><a href='profile.php?" . htmlspecialchars($row['username']) ."'>". htmlspecialchars($row['username']) . " </a>". ":</span> ";
        echo "<span class='message-text'>" . htmlspecialchars($row['message']) . "</span>";
        echo "<span class='timestamp'>" . formatDate($row['sent_at']) . "</span>";
        echo "</div>";
    }
    if ($current_date !== null) {
        echo "</div>"; // Close last date div
    }
}
?>