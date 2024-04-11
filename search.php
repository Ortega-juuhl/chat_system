<?php
include 'db_connect.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST["search"];

    $getUserID = "SELECT * FROM Users WHERE username = '$search'";

    $result = $conn->query($getUserID);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $searchUserID = $row['user_id'];
        $_SESSION['friend_request_user_id'] = $row['user_id'];

        echo "Username:" . $row['username'] . "<br>";
        echo "Status:" . $row['online_status'];

        echo "<form action='add_friend.php' method='post'>";
        echo "<input type='hidden' name='searchUserID' value='$searchUserID'>";
        echo "<button type='submit'>Add</button>";
        echo "</form>";
    } else {
        echo "No user found with username '$search'.";
    }
}
?>
