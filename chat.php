<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'db_connection.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function sendMessage() {
            var message = $("#message").val();
            var receiver_id = $("#receiver").val();
            $.ajax({
                url: "send_message.php",
                method: "POST",
                data: { message: message, receiver_id: receiver_id },
                success: function(data) {
                    $("#message").val("");
                    loadMessages();
                }
            });
        }

        function loadMessages() {
            var receiver_id = $("#receiver").val();
            $.ajax({
                url: "get_messages.php",
                method: "GET",
                data: { receiver_id: receiver_id },
                success: function(data) {
                    $("#chat-messages").html(data);
                }
            });
        }

        $(document).ready(function() {
            loadMessages();
            setInterval(loadMessages, 5000);
        });
    </script>
</head>
<body>
    <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
    <div id="chat-messages"></div>
    <select id="receiver">
        <?php
        $stmt = $conn->prepare("SELECT id, username FROM users WHERE id != ?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['username'] . "</option>";
        }
        ?>
    </select>
    <input type="text" id="message" placeholder="Type your message">
    <button onclick="sendMessage()">Send</button>
</body>
</html>