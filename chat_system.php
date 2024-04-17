<?php
session_start();
include 'db_connect.php';

if (isset($_SESSION['user_id'])) {
    // User is logged in, update online status to 'online'
    $user_id = $_SESSION['user_id'];
    $updateStatusQuery = "UPDATE Users SET online_status = 'online' WHERE user_id = $user_id";
    $conn->query($updateStatusQuery);
} else {
    // User is not logged in, update online status to 'offline' for all users
    $updateStatusQuery = "UPDATE Users SET online_status = 'offline'";
    $conn->query($updateStatusQuery);
}

$user_id = $_SESSION['user_id'];

// SQL query to fetch names of friends of the current user
$selectFriendsQuery = "SELECT Users.name 
                       FROM Users 
                       INNER JOIN Friends ON Users.user_id = Friends.friend_id 
                       WHERE Friends.user_id = $user_id AND Users.user_id != $user_id";

$resultSelectFriends = $conn->query($selectFriendsQuery);

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
    <div class="navbar">
        <a href="friend.php">Friend requests</a>
        <?php 
        // Check if there are pending friend requests
        $checkFriendRequest = "SELECT * FROM FriendRequests WHERE receiver_id = $user_id AND status = 'pending'";
        $resultFriendRequestCheck = $conn->query($checkFriendRequest);
        if ($resultFriendRequestCheck->num_rows > 0) {
            echo "<i class='fa-solid fa-bell'></i>";
        }
        ?>
        <a href="user_settings.php">User settings</a>
        <a href="logout.php">Logout</a>
    </div>

    <?php 
    $displayNameQuery = "SELECT username FROM Users WHERE user_id = $user_id";
    $resultDisplayName = $conn->query($displayNameQuery);
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
        if ($resultSelectFriends->num_rows > 0) {
            echo "Friends: <br> <br>";
            while ($row = $resultSelectFriends->fetch_assoc()) {
                echo $row['name'] . "<br>" . "<br>";
            }
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
