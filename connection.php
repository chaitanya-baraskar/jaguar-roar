<?php

$SERVER = 'localhost';
$USER = 'Panthera';
$PASS = 'OMITTED FOR GITHUB';
$DB_NAME = 'jungle';
   

if (!($connect = mysql_connect( $SERVER, $USER, $PASS))){
  echo  "<h2>Error connecting to database.</h2><br/>";
  exit;
}

mysql_select_db( $DB_NAME );

?>