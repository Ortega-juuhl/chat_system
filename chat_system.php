<?php
    session_start();
    include 'db_connect.php';

    if(isset($_SESSION['user_id'])) {
    } else {
        echo '<script>alert("You need to login before you can use the chat system."); window.location.href = "login.html";</script>';
    }

    $user_id = $_SESSION['user_id'];

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat System</title>
</head>
<body>
    <div class="search-container">
        <form action="search.php" method="post">
            <input type="text" placeholder="Search for people" name="search">
            <input type="submit" value="submit">
        </form>
    </div>
    <div class="friend-container">
        <!-- Display list of friends here -->
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
