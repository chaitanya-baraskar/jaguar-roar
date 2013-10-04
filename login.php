<?php
session_start();
include_once("connection.php");
include_once("common_functions.php");

session_unset();

show_login();
//has form been submitted
if (isset($_POST['login'])) { 

  if(!$_POST['username'] | !$_POST['password']) {
    die('Fill in the fields...');
  }

  $user_exist = user_exist($_POST['username']);

  if ($user_exist == 0) {
    die('That user does not exist in our database. <a href=registration.php>Click Here to Register</a>');
  }
  
  if (check_password($_POST['username'], $_POST['password'])==0){
    die("Bad Password!");
  }
  else 
  {
    //user logged in, set session variables

    $_SESSION['username'] = mysql_real_escape_string($_POST['username']);
    $_SESSION['userid'] = get_userid($_SESSION['username']);
    $_SESSION['password'] = md5(mysql_real_escape_string($_POST['password']));
  
     //continue 

      header("Location: index.php"); 

   } 

 

} 

function show_login(){
?>
<html>

 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

 <table border="0">

 <tr><td>Username:</td><td>

 <input type="text" name="username" maxlength="60">

 </td></tr>


    <tr><td>Password:</td><td>

 <input type="password" name="password" maxlength="30">

 </td></tr>


 <tr><th colspan=3><input type="submit" name="login"
value="Login"></th></tr> </table>

 </form>
</html>


<?php
}
?>