<?php
session_start();
include_once("connection.php");
include_once("common_functions.php");

$id = $_GET['id'];
$do = $_GET['do'];

switch ($do){
    case "follow":
        become_sheep($_SESSION['userid'],$id);
        $msg = "You have become a sheep!";
        break;

    case "unfollow":
        im_not_a_sheep($_SESSION['userid'],$id);
        $msg = "Independence, hear me roar!";
        break;
}
$_SESSION['message'] = $msg;
header("Location:index.php");
?>