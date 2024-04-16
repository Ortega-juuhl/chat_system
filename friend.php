<?php 
session_start();
include 'db_connect.php';

$user_ID = $_SESSION['user_id'];

$selectNamesQuery = "SELECT Users.name, FriendRequests.request_id 
                     FROM Users 
                     INNER JOIN FriendRequests ON Users.user_id = FriendRequests.sender_id 
                     WHERE FriendRequests.status = 'pending'";

$result = $conn->query($selectNamesQuery);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $request_id = $row['request_id'];
        echo $row['name'];
        echo "<form action='accept_friend.php' method='post'>";
        echo "<input type='hidden' name='request_id' value='$request_id'>";
        echo "<button type='submit'>Accept</button>";
        echo "</form>";
        echo "<form action='reject_friend.php' method='post'>";
        echo "<button type='submit'>Reject</button>";
        echo "</form>";
    }
} else {
    echo "You don't have any pending friend requests.";
}
?>
