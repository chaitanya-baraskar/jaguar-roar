<?php
session_start();
include_once('connection.php');
include_once('common_functions.php');

if (!$_SESSION['userid']) {
    header("Location: login.php");
    exit;
}

if(isset($_POST['delete'])){
    $my_name = get_username($_SESSION['userid']);
    if( strcmp ( $my_name , $_POST['username'] )==0){
        delete_roar($_POST[msg_id]);
        $_SESSION['message']='Deleted post!';
    }
    else{
        $_SESSION['message']="You can't delete this post!";
    }
}
?>



<!doctype html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Itty Bitty Kitty</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="css/custom.css">
    <script src="js/jquery-2.0.3.min.js"></script>
    <script src="js/bootstrap.js"></script>

</head>

<body>
<?php show_navbar(); ?>
<div id="imagecover" style='overflow:auto; z-index:1'>
<?php
if (isset($_SESSION['message'])) {
    echo "<center><br><br><br><span style='color:white;'><b>" . $_SESSION['message'] . "</span></center>";
    unset($_SESSION['message']);
}
?>
<div class="container" id="stuff" align="center" style='background-color : transparent;overflow:auto; z-index:2'>
    <form method='post' action='add.php'>
        <br>
        <textarea class="form-control has-warning" name='body' rows="5" maxlength='360' placeholder="Your Status"
                  style='resize: none;'></textarea><br>

        <p><div  align="right">
            <button type="submit" name="roar" class="btn btn-warning btn-md">Roar</button>
        </div>
        </p>
    </form>
    <br><br>
    <?php

    $users = show_users($_SESSION['userid']);

    if (count($users)){
        $myusers = array_keys($users);
    }else{
        $myusers = array();
    }
    $myusers[] = $_SESSION['userid'];
    $roars = show_posts($myusers,0);
    if (count($roars)){
    ?>
    <?php
    foreach ($roars as $key => $list) {
        echo "<div class='panel panel-warning'>\n";
        echo "<div class='panel-heading' style='padding-bottom: 0; padding-top:0'>\n";
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
    ?>
    <br><br><br>
</div>
</div>
<?php
} else {
    ?>
    <div class="panel panel-default">
        <div class="panel-body">
<span style='color:black;'><strong>There's nothing posted!</strong>
        </div>
    </div>
<?php
}

?>
</body>
</html>

