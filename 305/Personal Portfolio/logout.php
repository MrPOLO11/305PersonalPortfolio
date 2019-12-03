<?php

//Start the session
session_start();

//unset oen session variable
unset($_SESSION['username']);
//clear all session variables
$_SESSION = array();
//Destroy the session
session_destroy();

//Redirect to login page
header('location: login.php');