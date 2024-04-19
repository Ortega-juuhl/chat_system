<?php 
session_start();
include 'db_connect.php';

$user_id = $_SESSION['user_id'];

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $friend_id = $_POST['friend_id'];
    
    // Select messages between the user and the friend
    $select_messages = "SELECT * FROM Messages 
                        WHERE (sender_id = $user_id AND receiver_id = $friend_id) 
                        OR (sender_id = $friend_id AND receiver_id = $user_id) 
                        ORDER BY timestamp ASC"; // Order by timestamp in ascending order

    $result_select_messages = $conn->query($select_messages);

    if ($result_select_messages->num_rows > 0) {
        while ($row = $result_select_messages->fetch_assoc()) {
            $sender_id = $row['sender_id'];
            $content = $row['content'];
            $timestamp = $row['timestamp'];
            
            // Retrieve sender's username
            $sender_username_query = "SELECT username FROM Users WHERE user_id = $sender_id";
            $result_sender_username = $conn->query($sender_username_query);
            if ($result_sender_username->num_rows > 0) {
                $sender_username = $result_sender_username->fetch_assoc()['username'];
            } else {
                $sender_username = "Unknown"; // Default to "Unknown" if username not found
            }
            
            // Format the timestamp as desired (e.g., using date() function)
            $formatted_timestamp = date("Y-m-d H:i:s", strtotime($timestamp));
            
            echo "<p><strong>$sender_username ($formatted_timestamp):</strong> $content</p>";
        }
    } else {
        echo "No messages found.";
    }
} else {
    echo '<script>alert("Error, could not get friend information"); window.location.href = "friend.php";</script>';
}
?>

<div class="chat-container">
    <div class="chat-history">
        <!-- Display chat history with the selected friend here -->
    </div>
    <form action="send_chat.php" method="post">
        <input type="text" name="message" placeholder="Type your message">
        <input type="submit" value="Send">
    </form>
</div>
