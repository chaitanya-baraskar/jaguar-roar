<?php 
session_start();
include_once('connection.php');
include_once('common_functions.php');

if (!$_SESSION['userid']){
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>Meow</title>
</head>
<body>

<?php
  if (isset($_SESSION['message'])){
    echo "<b>". $_SESSION['message']."</b>";
    unset($_SESSION['message']);
  }
?>
<form method='post' action='add.php'>
<p>Your status:</p>
<textarea name='body' rows='6' cols='60' wrap=VIRTUAL></textarea>
<p><input type='submit' value='submit'/></p>
</form>

<?php
  $roars = show_posts($_SESSION['userid']);

if (count($roars)){
?>
<table border='1' cellspacing='0' cellpadding='5' width='500'>
<?php
    foreach ($roarss as $key => $list){
    echo "<tr valign='top'>\n";
    echo "<td>".$list['username'] ."</td>\n";
    echo "<td>".$list['body'] ."<br/>\n";
    echo "<small>".$list['timestamp'] ."</small></td>\n";
    echo "</tr>\n";
  }
?>
</table>
 <a href=login.php>Logout</a>
<?php
    }else{
?>
<p><b>There's nothing posted!</b></p>
<?php
}
?>


</body>
</html>