<?php
session_start();
session_destroy();
echo '<script>alert("Logged out. Your status will now be set to offline."); window.location.href = "login.html";</script>';
?>