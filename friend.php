<?php 
session_start();
include 'db_connect.php';

$user_ID = $_SESSION['user_id'];
//save sender ID i session

$selectNamesQuery = "SELECT Users.name 
                     FROM Users 
                     INNER JOIN FriendRequests ON Users.user_id = FriendRequests.sender_id 
                     WHERE FriendRequests.status = 'pending'";

$result = $conn->query($selectNamesQuery);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc());
        echo $row['name'];
        echo "<form action='accept_friend.php' method='post'>";
        echo "<button type='submit'>Accept</button>";
        echo "</form>";
        echo "<form action='reject_friend.php' method='post'>";
        echo "<button type='submit'>Reject</button>";
        echo "</form>";
    } else {
    echo "You don't have any pending firend requests.";
    }

?>