<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$msgid = trim($_POST['msgid']);
$newid = trim($_POST['newid']);
$to = trim($_POST['to']);

if($msgid != "" && $newid != "" && $to != "")
{
    $apath = "../../";

    require_once($apath."config/parameters/params_db.php");
    require_once($apath."config/database/db_mysql.php");

    $dbid = db_connect();

    $mobile = array();
    $mobiles = split(',', $to);

    for($im=0; $im < sizeof($mobiles); $im++)
    {
        $mobile = $mobiles[$im];
        $statement = "INSERT INTO tbl_sms_javna VALUES('$mobile', '$msgid', '$newid')";
        mysql_query($statement, $dbid);
    }

    db_close($dbid);
}

?>
