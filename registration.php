<?php
session_start();
include_once("connection.php");
include_once("common_functions.php");

if (isset($_POST['submit'])) { 

  //Make sure fields are filled

  if (!$_POST['username'] | !$_POST['email'] | !$_POST['password'] | !$_POST['password2'] ) {
    echo('You did not fill in all the fields');
    show_reg_form();
    die();
  }

  //Check if username exists
  $_POST['username'] = mysql_real_escape_string($_POST['username']);
  $user_exist = user_exist($_POST['username']);
  if ($user_exist != 0) {
    echo('Sorry, the username '.$_POST['username'].' is already in use.');
    show_reg_form();
    die();
  }


  //Test if passwords match
  if ($_POST['password'] != $_POST['password2']) {
    echo('Your passwords did not match. ');
    show_reg_form();
    die();
  }

  //Test password length
  if (strlen($_POST['password']) < 8){
    echo('Your password is too short.');
    show_reg_form();
    die();
  }


// Encrypt password check for escape sequences

$_POST['password'] = mysql_real_escape_string($_POST['password']);
$_POST['username'] = mysql_real_escape_string($_POST['username']);
$_POST['password'] = md5($_POST['password']);


//Insert new user into database

$insert = "insert into users (username, email, password) values ('".$_POST['username']."','".$_POST['email']."', '".$_POST['password']."')";

$add_member = mysql_query($insert);
$username = $_POST['username'];
session_unset();
$_SESSION['username']= $username;
$_SESSION['userid'] = get_userid($username);
$_SESSION['password'] = $_POST['password'];

header("Location: index.php");
exit;

}
  else{
    show_reg_form();
  }

function show_reg_form(){
?>
<html>

 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

 <table border="0">

 <tr><td>Username:</td><td>

 <input type="text" name="username" maxlength="60">

 </td></tr>

      <tr><td>Email:</td><td>

 <input type="text" name="email" maxlength="60">

 </td></tr>


    <tr><td>Password: (Min: 8 characters)</td><td>

 <input type="password" name="password" maxlength="10">

 </td></tr>

      <tr><td>Confirm Password:</td><td>

 <input type="password" name="password2" maxlength="10">

 </td></tr>

 <tr><th colspan=2><input type="submit" name="submit"
value="Register"></th></tr> </table>

 </form>
</html>



<?php

}

?>