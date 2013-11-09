<?php
session_start();
include_once('connection.php');
include_once('common_functions.php');

if (!$_SESSION['userid']) {
    header("Location: login.php");
    exit;
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
<div id="imagecover" style='overflow:auto; z-index:1'>
<?php
if (isset($_SESSION['message'])) {
    echo "<center><span style='color:white;'><b>" . $_SESSION['message'] . "</b></span></center>";
    unset($_SESSION['message']);
}
?>
<div class="container" id="stuff" align="center" style='background-color : transparent;overflow:auto; z-index:2'>
    <form method='post' action='add.php'>
        <br><br><br>
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
        echo "</tr>\n";
        echo "</table>\n";
        echo "</div>\n";
        echo "<div class='panel-body' style='text-align: left'>\n";
        echo "" . $list['body'] . "<br/>\n";
        echo "</div>\n";
        echo "</div>\n";
    }
    ?>
    <button type="button" name="new" class="btn btn-danger btn-xs" onclick="location.href='login.php';">Logout</button>
    <br><br><br>
</div>
</div>
<?php
} else {
    ?>
    <p><b>There's nothing posted!</b></p>
<?php
}
?>


</body>
</html>