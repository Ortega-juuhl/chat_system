<?php
session_start();

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Users (name, username, password) VALUES ('$name', '$username', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Registration successful. You can now login."); window.location.href = "login.html";</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Error: Request method";
}
?>
