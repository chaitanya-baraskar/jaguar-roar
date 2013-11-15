<?php
session_start();
include_once("connection.php");
include_once("common_functions.php");

if (user_exist($_SESSION['username'])){
  $userid = $_SESSION['userid'];
  $body = substr($_POST['body'],0,360);
  $body = mysql_real_escape_string($body);
  $body .= (string)$_POST['lat'];

  add_post($userid,$body);

  header("Location:index.php");
}
else{
  header("Location:login.php");
}
?>