<?php

//If user is logged in, get username
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}
//Display a welcome message
echo"<p>Welcome $username</p>";
//Display a logout link
echo"<p> <a href='logout.php'>Logout</a></p>";