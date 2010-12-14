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

//Validation Data Fields
$errors = array();
$rules = array();

$name = string_wslashes($_POST['name']);
$mobile = string_wslashes($_POST['mobile']);
$location = string_wslashes($_POST['location']);
$other_info1 = string_wslashes($_POST['info1']);
$other_info2 = string_wslashes($_POST['info2']);

$rules[] = ("digits_only,mobile,Mobile : Digits only please.");
$rules[] = ("required,mobile,Required : Mobile.");
$rules[] = ("length<=20,mobile,Mobile : < 20 digits please.");

$rules[] = ("length<=160,name,Name : < 160 chars please.");
$rules[] = ("length<=200,location,Location : < 200 chars please.");
$rules[] = ("length<=200,info1,Info #1 : < 200 chars please.");
$rules[] = ("length<=200,info2,Info #2 : < 200 chars please.");

$errors = validateFields($_POST, $rules);

if (sizeof($errors)==0) {
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

    $rs1 = mysql_query("UPDATE tbl_alerts_group_members SET name = '$name', mobile = '$mobile', location = '$location', other_info1 = '$other_info1', other_info2 = '$other_info2' WHERE group_id = $group_id AND mobile = '$member_mobile'",$dbid);
    if(!$rs1) {
	$msg_text = "Duplicate Mobile Number $mobile, please contact Souktel Support Team for more information.";
	mysql_query("ROLLBACK",$dbid);
    } else {
	$msg_text = "Member information updated successfully.";
	mysql_query("COMMIT",$dbid);
    }

    db_close($dbid);
}
else {
    $msg_text = 'Date enery error, please try again.';
}

$return_url = $_POST["return_url"];
header("Location: $return_url"."&msg=".$msg_text);
?>