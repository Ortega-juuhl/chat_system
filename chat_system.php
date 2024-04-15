<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("You need to login before you can use the chat system."); window.location.href = "login.html";</script>';
    exit; // Stop further execution if user is not logged in
}

$user_id = $_SESSION['user_id'];

// SQL query to fetch all names from Users table where there are rows in FriendRequests table with status 'accepted'
$selectNamesQuery = "SELECT Users.name 
                     FROM Users 
                     INNER JOIN FriendRequests ON Users.user_id = FriendRequests.sender_id 
                     WHERE FriendRequests.status = 'accepted'";

$result = $conn->query($selectNamesQuery);

if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat System</title>
</head>
<body>
    <div class ="navbar">
        <p>Friend requests</p>
        <p>User settings</p>
        <p>Faq</p>
    </div>
    <div class="search-container">
        <form action="search.php" method="post">
            <input type="text" placeholder="Search for people" name="search">
            <input type="submit" value="submit">
        </form>
    </div>
    <div class="friend-container">
        <?php 
            if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc());
                echo $row['name'];
        } else {
            echo "You don't have any friends yet.";
        }
                    
        ?>
    </div>
    <div class="chat-container">
        <!-- Display chat history and send message form here -->
        <div class="chat-history">
            <!-- Display chat history with the selected friend here -->
        </div>
        <form action="send_chat.php" method="post">
            <input type="text" name="message" placeholder="Type your message">
            <input type="submit" value="Send">
        </form>
    </div>
</body>
</html>
