<?php

function add_post($userid, $body, $lat, $lng){
   if (!$userid | !$body){
     $_SESSION['message']="Empty Message";
     return;
   }
   $body = mysql_real_escape_string($body);
   $sqlquery = "insert into roars (users_id, body, timestamp, lat, lng) values ($userid, '$body' ,now(), $lat, $lng)";
   $result = mysql_query($sqlquery);
   if (!$result){
     die(mysql_error());
   }
   $_SESSION['message'] = "Your post has been added!";
   $msg_id = mysql_insert_id();
   $hashes = array();
   $body = strtolower($body);
   $words = explode(" ", $body);
    foreach($words as $word){
        if (ord($word) == ord("#") and strlen($word) > 1){
            array_push($hashes, substr($word, 1) );

        }
    }
    foreach($hashes as $hash){
        $sqlquery = "insert into hashtags (hashtag, roars_id) values ('$hash', $msg_id)";
        $result = mysql_query($sqlquery);
        if (!$result){
            die(mysql_error());
        }
    }
}


function show_posts($userid,$limit=0){
    $roars = array();

    $user_string = implode(',', $userid);

    $added =  " and id in ($user_string)";

    if ($limit > 0){
        $added = "limit $limit";
    }else{
        $added = '';
    }

    $sqlquery = "select roars.users_id, roars.body, roars.timestamp, roars.id, users.username from roars, users
		where roars.users_id in ($user_string) and roars.users_id = users.id
		order by roars.timestamp desc $added ";

    $result = mysql_query($sqlquery);

    while($data = mysql_fetch_object($result)){
        $roars[] = array( 	'timestamp' => $data->timestamp,
            'username' => $data->username,
            'body' => substr(stripslashes(nl2br($data->body)),0,360),
            'msg_id'=> $data->id,
        );
    }
    return $roars;

}

function search_posts($tags,$limit=0){
    $roars = array();

    $tag_string = implode("','", $tags);

    //$added =  " and hashtags.hashtag in ('$tag_string')";

    if ($limit > 0){
        $added = "limit $limit";
    }else{
        $added = '';
    }

    $sqlquery = "select roars.users_id, roars.body, roars.timestamp, roars.id, users.username, hashtags.hashtag, hashtags.roars_id from roars, users, hashtags
		where hashtags.hashtag in ('$tag_string') and hashtags.roars_id = roars.id and roars.users_id = users.id
		order by roars.timestamp desc $added ";
    $result = mysql_query($sqlquery);

    while($data = mysql_fetch_object($result)){
        $roars[] = array( 	'timestamp' => $data->timestamp,
            'username' => $data->username,
            'body' => substr(stripslashes(nl2br($data->body)),0,360),
            'msg_id'=> $data->id,
        );
    }
    return $roars;

}

function delete_roar($msg_id){

    $sqlquery = "delete from roars where roars.id = '$msg_id'";
    $test = mysql_query($sqlquery);
    if (!$test){
        die(mysql_error());
    }
    $sqlquery = "delete from hashtags where hashtags.roars_id = '$msg_id'";
    $test = mysql_query($sqlquery);
    if (!$test){
        die(mysql_error());
    }
}

function following($userid){
    $sheep = array();
    $sqlquery = "select distinct users_id from sheep
			where sheep_id = '$userid'";
    $result = mysql_query($sqlquery);
    while($data = mysql_fetch_object($result)){
        array_push($sheep, $data->users_id);
    }
    return $sheep;
}

function check_sheep_count($sheep, $herder){
    $sqlquery = "select count(*) from sheep
			where users_id='$herder' and sheep_id='$sheep'";
    $result = mysql_query($sqlquery);
    $row = mysql_fetch_row($result);
    return $row[0];

}

//Follow another user
function become_sheep($my_userID,$their_userID){
    $count = check_sheep_count($my_userID,$their_userID);

    if ($count == 0){
        $sqlquery = "insert into sheep (users_id, sheep_id)
				values ($their_userID,$my_userID)";
        $result = mysql_query($sqlquery);
    }
}

//unfollow another user
function im_not_a_sheep($my_userID,$their_userID){
    $count = check_sheep_count($my_userID,$their_userID);

    if ($count != 0){
        $sqlquery = "delete from sheep
				where users_id='$their_userID' and sheep_id='$my_userID'
				limit 1";

        $result = mysql_query($sqlquery);
    }
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

function show_users($user_id=0){
    $added = "";
    if ($user_id > 0){
        $follow = array();
        $follow_sqlquery = "select sheep.users_id from sheep
				where sheep_id = $user_id";
        $follow_result = mysql_query($follow_sqlquery);

        while($f = mysql_fetch_object($follow_result)){
            array_push($follow, $f->users_id);
        }
        if (count($follow)){
            $id_string = implode(',', $follow);
            $added =  " and id in ($id_string)";


        }else{
            return array();
        }
    }
    $users = array();
    $sqlquery = "select id, username from users
		where status='active'
		$added order by username";

    $result = mysql_query($sqlquery);

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

function show_navbar(){
    echo "<!--navbar begin-->\n";
    echo "<nav class='navbar navbar-inverse navbar-fixed-top' role='navigation'>\n";
    echo "   <a href='index.php' class='navbar-brand'>".$_SESSION['username']." </a>\n";
    echo "  <button class='navbar-toggle' data-toggle='collapse' data-target='.navHeaderCollapse' >\n";
    echo "    <span class='sr-only'>Toggle navigation</span>\n";
    echo "    <span class='icon-bar'></span>\n";
    echo "    <span class='icon-bar'></span>\n";
    echo "    <span class='icon-bar'></span>\n";
    echo "  </button>\n";
    echo "  <div class='collapse navbar-collapse navHeaderCollapse' style='overflow:hidden;'>\n";
    echo "    <ul class='nav navbar-nav'>\n";
    echo "      <li class='active'><a href='index.php'>Home</a></li>\n";
    echo "      <li><a href='userlist.php'>Follow</a></li>\n";
    echo "     </ul>\n";
    echo "    <ul class='nav navbar-nav navbar-right'>\n";
    echo "<li style='padding-top: 5px'><form class='navbar-form' method='post' action='search.php' id='search' name='search'>\n";
    echo "<input name='q' type='text' size='40' placeholder='Search' />\n";
    echo "</form></li>\n";
    echo "      <li><a href='#'></a></li>\n";
    echo "      <li><a href='#'></a></li>\n";
    echo "      <li style='padding-top: 3px'><button type='button' class='btn btn-danger navbar-btn btn-sm' onclick='location.href=\"login.php\"'>Logout</button></li>\n";
    echo "      <li><a href='#'></a></li>\n";
    echo "    </ul>\n";
    echo "  </div>\n";
    echo "</nav>\n";
    echo "<!--navbar end-->\n";
}

function display_roars($roars){
    foreach ($roars as $key => $list) {
        echo "<div class='panel panel-warning'>\n";
        echo "<div class='panel-heading' style='padding-bottom: 0; padding-top:0;'>\n";
        echo "<table class='table table-condensed panel-title' style='text-align: center;border-collapse: collapse;'>\n";
        echo "<tr class='warning' style='border:none'>\n";
        echo "<td style='text-align: left;  border:none;'>\n";
        echo "<strong>" . $list['username'] . "</strong>\n";
        echo "</td>\n";
        echo "<td style='text-align: left; border:none'>\n";
        echo "</td>\n";
        echo "<td style='text-align: right; border:none;'>\n";
        echo "" . $list['timestamp'] . "\n";
        echo "</td>\n";
        echo "<td style='text-align: right; width:10%; border:none;'>\n";
        echo "<form class='form-horizontal' role='form' action='".$_SERVER['PHP_SELF']."' method='post'>\n";
        echo "<input type='hidden' name='msg_id' value='".$list['msg_id']."'>\n";
        echo "<input type='hidden' name='username' value='".$list['username']."'>\n";
        echo "<button type='submit' name='delete' class='close'>&times;</button>\n";
        echo "</form>";
        echo "</td>\n";
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";
        echo "<div class='panel-body' style='text-align: left'>\n";
        echo "" . $list['body'] . "<br/>\n";
        echo "</div>\n";
        echo "</div>\n";
    }

}

?>