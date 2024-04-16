<?php
session_start()
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_ID = $_SESSION['user_id'];
    $change_status = "UPDATE FriendRequests SET status = 'accepted' WHERE reciver_id = $user_ID";

    if ($conn->query($change_status) === TRUE) {
        echo '<script>alert("Successful accepted friend request."); window.location.href = "friend.php.php";</script>';
    } else {
        echo '<script>alert("An error occurred while trying to accepting friend request, please try again."); window.location.href = "friend.php.php";</script>';
    }
} else {
    echo "Error accepting friend request: Invalid request method.";
}

?>
