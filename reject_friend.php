<?php
session_start()
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_ID = $_SESSION['user_id'];
    $change_status = "UPDATE FriendRequests SET status = 'rejected' WHERE reciver_id = $user_ID";

    if ($conn->query($change_status) === TRUE) {
        echo '<script>alert("Successfully rejected friend request."); window.location.href = "friend.php.php";</script>';
    } else {
        echo '<script>alert("An error occurred while trying to reject the friend request, please try again later."); window.location.href = "friend.php.php";</script>';
    }
} else {
    echo "Error accepting friend request: Invalid request method.";
}
?>
