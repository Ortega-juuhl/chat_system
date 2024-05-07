<?php
session_start();
include 'db_connect.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];

    $send_message = "INSERT INTO Messages (sender_id, reciver_id, content) VALUES ($user_id, $, $message )"
}
?>wadawdad