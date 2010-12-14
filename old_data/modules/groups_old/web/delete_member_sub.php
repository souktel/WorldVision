<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($param_session_check != "zZZz4332W") {
    header("Location: index.php");
}

$group_id = string_wslashes($_POST['group_id']);
if(!is_numeric($group_id)) exit;

$member_mobile = string_wslashes($_POST['mob']);
if(trim($member_mobile)=='') exit;


$dbid = db_connect();

mysql_query("BEGIN",$dbid);

if($rs = mysql_query("SELECT 1 FROM tbl_alerts_group WHERE group_id = $group_id AND sys_id = $param_session_sys_id AND owner_id = $param_session_user_user_id", $dbid)) {
    if(!$row = mysql_fetch_array($rs)) {
	exit;
    }
}
else {
    exit;
}

$rs1 = mysql_query("DELETE FROM tbl_alerts_group_members WHERE group_id = $group_id AND mobile = '$member_mobile'",$dbid);
if($rs1) {
    $msg_text = "Member deleted successfully.";
    mysql_query("COMMIT",$dbid);
}

db_close($dbid);


$return_url = $_POST["return_url"];
header("Location: $return_url"."&msg=".$msg_text);
?>