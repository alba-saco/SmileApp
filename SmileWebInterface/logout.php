<?php
// The file addAppAdmin.php is adapted from personal written code for the Module "Database and Information Management Systems (19/20)" with the course code COMP0022-PG taught at UCL

session_start();

//logout from account
session_destroy();

//Redirect to login page
header("location: login.php")
?>