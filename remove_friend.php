<?php
session_start();

include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("You need to login before you can use the chat system."); window.location.href = "login.html";</script>';
    exit; // Stop further execution if user is not logged in
}

$user_id = $_SESSION['user_id'];
$friend_id = $_POST['friend_id'];

$remove_friend = "DELETE FROM Friends WHERE (user_id = $user_id AND friend_id = $friend_id) OR (user_id = $friend_id AND friend_id = $user_id)";
$result_remove_friend = $conn->query($remove_friend);

if($result_remove_friend) {
    echo '<script>alert("Removed friend."); window.location.href = "index.php";</script>';
} else {
    echo '<script>alert("Error removing friend, please try again later."); window.location.href = "chat_system.php";</script>';

}
?>