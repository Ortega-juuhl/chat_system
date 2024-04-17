<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("You need to login before you can use the chat system."); window.location.href = "login.html";</script>';
    exit; // Stop further execution if user is not logged in
} else {
    $friend_user_id = $_POST['friend_user_id'];
    $user_id = $_SESSION['user_id'];

    // Delete the friendship in both directions
    $select_friend = "DELETE FROM Friends WHERE (user_id = $user_id AND friend_id = $friend_user_id) OR (user_id = $friend_user_id AND friend_id = $user_id)";
    
    $result = $conn->query($select_friend);

    if ($result) {
        echo '<script>alert("Successfully removed friend."); window.location.href = "chat_system.php";</script>';
    } else {
        echo '<script>alert("Could not remove friend, please try again later."); window.location.href = "chat_system.php";</script>';
    }
}
?>
