<?php 
session_start();
include_once("connection.php");
include_once("common_functions.php");
if (!$_SESSION['userid']) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>Meow - User list</title>
</head>
<body>

<h1>List of Users</h1>
<?php
  $users = show_users();
  $sheep = following($_SESSION['userid']);
if (count($users)){
?>
<table border='1' cellspacing='0' cellpadding='5' width='500'>
    <?php
    foreach ($users as $key => $value){
        echo "<tr valign='top'>\n";
        echo "<td>".$key ."</td>\n";
        echo "<td>".$value;
        if (in_array($key,$sheep)){
            echo " <small>
		<a href='tofollow.php?id=$key&do=unfollow'>unfollow</a>
		</small>";
        }else{
            echo " <small>
		<a href='tofollow.php?id=$key&do=follow'>follow</a>
		</small>";
        }
        echo "</td>\n";
        echo "</tr>\n";
    }
    ?>
</table>
<?php
    }else{
?>
<p><b>There are no users in the system!</b></p>
<?php
    }
?>
</body>
</html>