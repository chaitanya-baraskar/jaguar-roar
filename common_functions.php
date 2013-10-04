<?php

function add_post($userid,$body){
  if (!$userid | !$body){
    $_SESSION['message']="Empty Message";
    return;
  }

  $sql = "insert into roars (user_id, body, timestamp) values ($userid, '". mysql_real_escape_string($body). "',now())";
  $result = mysql_query($sql);
  if (!$result)
    die(mysql_error());
}

function show_posts($userid){
  $posts = array();

  $sql = "select body, timestamp from roars where user_id = '$userid' order by timestamp desc";
  $result = mysql_query($sql);
  
  while($data = mysql_fetch_object($result)){
    $posts[] = array( 'timestamp' => $data->timestamp, 
		      'username' => get_username($userid), 
		      'body' => $data->body
		      );
  }
  return $posts;
}

function get_username($userid){
  $sql = "select username from users where id = '$userid'";
  $result = mysql_query($sql);
  $username = mysql_fetch_object($result);
  return $username->username;
}

function get_userid($username){
  $sql = "select id from users where username = '$username'";
  $result = mysql_query($sql);
  $id = mysql_fetch_object($result);
  return $id->id;
}

function show_users(){
  $users = array();
  $sql = "select id, username from users where status='active' order by username";
  $result = mysql_query($sql);

  while ($data = mysql_fetch_object($result)){
    $users[$data->id] = $data->username;
  }
  return $users;
}

function user_exist($username){
  $username = mysql_real_escape_string($username);
  $query = mysql_query("SELECT username FROM users WHERE username = '$username'")
    or die(mysql_error());
  $result = mysql_num_rows($query);
  return $result;
}

function check_password($username, $password){
  if (!$username | !$password)
    die("Empty username or password");
  $username = mysql_real_escape_string($username);
  $password = mysql_real_escape_string($password);
  $password = md5($password);
   $query = mysql_query("SELECT * FROM users WHERE username = '$username'")
    or die(mysql_error());
  $result = mysql_fetch_array($query) or die(mysql_error());
 
  if ($password != $result['password']){
    //passwords do not match
    return 0;
  }
  else{
    //passwords must match
    return 1;
  }
}

?>