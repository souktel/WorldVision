<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($param_session_check != "zZZz4332W")
{
    header("Location: index.php");
}  
?>
<?php
/*
 * Tamer Qasim
 */

//Validation Data Fields
$errors = array();
$rules = array();

//Error Flag
$error_found = false; //No Errors at first
$error_no = "";

$name = string_wslashes($_POST['name']);
$description = string_wslashes($_POST['description']);
$public_group = string_wslashes($_POST['pgrp']);
if(!is_numeric($public_group) || $public_group == '' || strlen($public_group) == 0) $public_group = 0;
$senders = array();

for($si = 0; $si < sizeof($_POST['senders']); $si++)
{
    $senders[] = string_wslashes($_POST['senders'][$si]);
}

//Name
$rules[] = ("required,name,Required : Name.");
$rules[] = ("length<=100,name,Name : < 100 chars please.");

$errors = validateFields($_POST, $rules);

if (sizeof($errors)==0)
{
    $dbid = db_connect();

    mysql_query("BEGIN",$dbid);

    $rs = mysql_query("INSERT INTO tbl_alerts_group VALUES(group_id, $param_session_sys_id, $param_session_user_user_id, '', '$name', '$description', CURRENT_TIMESTAMP, 1, $public_group)",$dbid);

    if(!$rs)
    {
        $error_found = true;
        $error_no = "1601";
        mysql_query("ROLLBACK",$dbid);
    }
    else
    {
        $current_id = mysql_insert_id($dbid);
        $reference = "G".($current_id+1030);
        $rs1 = mysql_query("UPDATE tbl_alerts_group SET reference_code = '$reference' WHERE group_id = $current_id",$dbid);
        if(!$rs1)
        {
            $error_found = true;
            $error_no = "1602";
            mysql_query("ROLLBACK",$dbid);
        }
        else
        {
            mysql_query("COMMIT",$dbid);
            if(sizeof($senders) > 0)
            {
                $selected_users = join(",",$senders);
                $rs2 = mysql_query("SELECT user_id FROM tbl_sys_user WHERE sys_id = $param_session_sys_id AND mobile IN ($selected_users)", $dbid);
                while($row = mysql_fetch_array($rs2))
                {
                    $sender_id = $row[0];
                    if($sender_id != $param_session_user_user_id) mysql_query("INSERT INTO tbl_alerts_group_senders VALUES($current_id, $sender_id)",$dbid);
                }
            }
        }
    }

    db_close($dbid);

}
else
{
    $error_found = true;
    $error_no = "1501";
}

if ($error_found)
{
    //Failed
    header("Location: $param_server"."/templates/html/error.php?en=".$error_no);
}
else
{
    //Success
    $return_url = $_POST["return_url"];
    header("Location: ".$param_server."/modules/groups/web/index.php");
}

?>
