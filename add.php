<?php
session_start();
include_once("connection.php");
include_once("common_functions.php");

if (user_exist($_SESSION['username'])){
  $userid = $_SESSION['userid'];
  $body = substr($_POST['body'],0,360);

  if (add_post($userid,$body)){
    $_SESSION['message'] = "Your post has been added!";
  }
  header("Location:index.php");
}
else{
  header("Location:login.php");
}
?>