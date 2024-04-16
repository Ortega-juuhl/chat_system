<?php
session_start();
include 'db_connect.php';

if (isset($_SESSION['user_id'])) {
    // User is logged in, update online status to 'online'
    $user_id = $_SESSION['user_id'];
    $updateStatusQuery = "UPDATE Users SET online_status = 'online' WHERE user_id = $user_id";
    $conn->query($updateStatusQuery);
} else {
    // User is not logged in, update online status to 'offline'
    $updateStatusQuery = "UPDATE Users SET online_status = 'offline'";
    $conn->query($updateStatusQuery);
}

$user_id = $_SESSION['user_id'];

// SQL query to fetch all names from Users table where there are rows in FriendRequests table with status 'accepted'
$selectNamesQuery = "SELECT Users.name 
                     FROM Users 
                     INNER JOIN FriendRequests ON Users.user_id = FriendRequests.sender_id 
                     WHERE FriendRequests.status = 'accepted'";

$checkFriendRequest = "SELECT Users.user_id 
                       FROM Users 
                       INNER JOIN FriendRequests ON Users.user_id = FriendRequests.receiver_id 
                       WHERE FriendRequests.status = 'pending'";

$resultSelectFriend = $conn->query($selectNamesQuery);
$resultFriendRequestCheck = $conn->query($checkFriendRequest);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat System</title>
    <script src="https://kit.fontawesome.com/9e81387435.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class ="navbar">
        <a href="friend.php">Friend requests</a>
        <?php if ($resultFriendRequestCheck->num_rows > 0) {
        echo "<i class='fa-solid fa-bell'></i>";
         }
        ?>
        <a href="user_settings.php">user settings</a>
        <a href="logout.php">Logout</a>
    </div>

    <?php 
    $displayName = "SELECT username FROM users WHERE user_id = $user_id";
    $resultDisplayName = $conn->query($displayName);
    $row = $resultDisplayName->fetch_assoc();
    $username = $row['username'];
    echo "Welcome back, $username!";
    ?>

    <div class="search-container">
        <form action="search.php" method="post">
            <input type="text" placeholder="Search for people" name="search">
            <input type="submit" value="submit">
        </form>
    </div>
    <div class="friend-container">
        <?php 
            if ($resultSelectFriend->num_rows > 0) {
                echo "Friends: <br> <br>";
            while ($row = $resultSelectFriend->fetch_assoc()) {
                echo $row['name'] . "<br>" . "<br>";
            };
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
