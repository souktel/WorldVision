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
?>
<?php
$group_id = string_wslashes($_POST['group_id']);
if(!is_numeric($group_id)) exit;

$error_found = false;
$error_no = "";

$memberstodel = array();

for($si = 0; $si < sizeof($_POST['memberstodel']); $si++) {
    $memberstodel[] = "'".string_wslashes($_POST['memberstodel'][$si])."'";
}

$dbid = db_connect();

mysql_query("BEGIN",$dbid);

if(!$rs_select = mysql_query("SELECT 1 FROM tbl_alerts_group WHERE group_id = $group_id AND sys_id = $param_session_sys_id AND owner_id = $param_session_user_user_id",$dbid)) {
    $error_found = true;
    $error_no = "1602";
    mysql_query("ROLLBACK",$dbid);
}
else {
    $todo_sub = strtolower(trim($_POST['todo_sub']));
    if($todo_sub == 'delete') {
	if(strtolower($_POST['allselected']) == 'yes_all_selected') {
	    if(!mysql_query("DELETE FROM tbl_alerts_group_members WHERE group_id = $group_id",$dbid)) {
		mysql_query("ROLLBACK",$dbid);
	    }
	    else {
		mysql_query("COMMIT",$dbid);
		$reply_msg = "Group members have been deleted successfully.";
	    }
	}
	else {
	    if(sizeof($memberstodel) > 0) {
		$members2del = trim(join(",",$memberstodel),",");
		if(!mysql_query("DELETE FROM tbl_alerts_group_members WHERE group_id = $group_id AND mobile IN ( $members2del )",$dbid)) {
		    mysql_query("ROLLBACK",$dbid);
		}
		else {
		    mysql_query("COMMIT",$dbid);
		    $reply_msg = "Group members have been deleted successfully.";
		}
	    }
	    else {
		mysql_query("ROLLBACK",$dbid);
	    }
	}
    } else if ($todo_sub == 'move + save') {
	    if(strtolower($_POST['allselected']) == 'yes_all_selected') {
		$cm_group_id = string_wslashes($_POST['cm_group_id']);
		if(!is_numeric($cm_group_id)) exit;
		if(!mysql_query("SELECT 1 FROM tbl_alerts_group WHERE group_id = $cm_group_id AND sys_id = $param_session_sys_id AND owner_id = $param_session_user_user_id",$dbid)) {
		    $error_found = true;
		    $error_no = "1603";
		    mysql_query("ROLLBACK",$dbid);
		}
		else {
		    $rs_copy = mysql_query("SELECT * FROM tbl_alerts_group_members WHERE group_id = $group_id", $dbid);
		    $copy_success = true;
		    while($row_copy = mysql_fetch_array($rs_copy)) {
			$cm_mobile = mysql_escape_string($row_copy[1]);
			$cm_name = mysql_escape_string($row_copy[2]);
			$cm_loc = mysql_escape_string($row_copy[3]);
			$cm_ot1 = mysql_escape_string($row_copy[4]);
			$cm_ot2 = mysql_escape_string($row_copy[5]);
			$copy_success = mysql_query("INSERT INTO tbl_alerts_group_members VALUES($cm_group_id, '$cm_mobile','$cm_name','$cm_loc','$cm_ot1','$cm_ot2')", $dbid);
			if(!$copy_success) {
			    $copy_success = mysql_query("UPDATE tbl_alerts_group_members SET name = '$cm_name', location = '$cm_loc', other_info1 = '$cm_ot1', other_info2 = '$cm_ot2' WHERE group_id = $cm_group_id AND mobile = '$cm_mobile'", $dbid);
			    if(!$copy_success) {
				break;
			    }
			}
		    }
		    if(!$copy_success) {
			mysql_query("ROLLBACK",$dbid);
		    } else {
			mysql_query("COMMIT",$dbid);
			$reply_msg = "Group members have been copied successfully.";
		    }
		}
	    } else {
		$cm_group_id = string_wslashes($_POST['cm_group_id']);
		if(!is_numeric($cm_group_id)) exit;
		if(!mysql_query("SELECT 1 FROM tbl_alerts_group WHERE group_id = $cm_group_id AND sys_id = $param_session_sys_id AND owner_id = $param_session_user_user_id",$dbid)) {
		    $error_found = true;
		    $error_no = "1603";
		    mysql_query("ROLLBACK",$dbid);
		}
		else {
		    if(sizeof($memberstodel) > 0) {
			$members2del = trim(join(",",$memberstodel),",");
			if(mysql_query("DELETE FROM tbl_alerts_group_members WHERE group_id = $cm_group_id AND mobile IN ($members2del)", $dbid)) {
			    $rs_copy = mysql_query("SELECT * FROM tbl_alerts_group_members WHERE group_id = $group_id AND mobile IN ($members2del)", $dbid);
			    $copy_success = true;
			    while($row_copy = mysql_fetch_array($rs_copy)) {
				$cm_mobile = mysql_escape_string($row_copy[1]);
				$cm_name = mysql_escape_string($row_copy[2]);
				$cm_loc = mysql_escape_string($row_copy[3]);
				$cm_ot1 = mysql_escape_string($row_copy[4]);
				$cm_ot2 = mysql_escape_string($row_copy[5]);
				$copy_success = mysql_query("INSERT INTO tbl_alerts_group_members VALUES($cm_group_id, '$cm_mobile','$cm_name','$cm_loc','$cm_ot1','$cm_ot2')", $dbid);
				if(!$copy_success) {
				    break;
				}
			    }
			    if(!$copy_success) {
				mysql_query("ROLLBACK",$dbid);
			    } else {
				mysql_query("COMMIT",$dbid);
				$reply_msg = "Group members have been copied successfully.";
			    }

			} else {
			    mysql_query("ROLLBACK",$dbid);
			}
		    } else {
			$reply_msg = "You didn't select any group member.";
		    }
		}
	    }
	} else if ($todo_sub == 'move + delete') {
		if(strtolower($_POST['allselected']) == 'yes_all_selected') {
		    $cm_group_id = string_wslashes($_POST['cm_group_id']);
		    if(!is_numeric($cm_group_id)) exit;
		    if(!mysql_query("SELECT 1 FROM tbl_alerts_group WHERE group_id = $cm_group_id AND sys_id = $param_session_sys_id AND owner_id = $param_session_user_user_id",$dbid)) {
			$error_found = true;
			$error_no = "1603";
			mysql_query("ROLLBACK",$dbid);
		    }
		    else {
			$rs_copy = mysql_query("SELECT * FROM tbl_alerts_group_members WHERE group_id = $group_id", $dbid);
			$copy_success = true;
			while($row_copy = mysql_fetch_array($rs_copy)) {
			    $cm_mobile = mysql_escape_string($row_copy[1]);
			    $cm_name = mysql_escape_string($row_copy[2]);
			    $cm_loc = mysql_escape_string($row_copy[3]);
			    $cm_ot1 = mysql_escape_string($row_copy[4]);
			    $cm_ot2 = mysql_escape_string($row_copy[5]);
			    $copy_success = mysql_query("INSERT INTO tbl_alerts_group_members VALUES($cm_group_id, '$cm_mobile','$cm_name','$cm_loc','$cm_ot1','$cm_ot2')", $dbid);
			    if(!$copy_success) {
				$copy_success = mysql_query("UPDATE tbl_alerts_group_members SET name = '$cm_name', location = '$cm_loc', other_info1 = '$cm_ot1', other_info2 = '$cm_ot2' WHERE group_id = $cm_group_id AND mobile = '$cm_mobile'", $dbid);
				if(!$copy_success) {
				    break;
				}
			    }
			}
			if(!$copy_success) {
			    mysql_query("ROLLBACK",$dbid);
			} else {
			    if(mysql_query("DELETE FROM tbl_alerts_group_members WHERE group_id = $group_id", $dbid)) {
				mysql_query("COMMIT",$dbid);
				$reply_msg = "Group members have been moved successfully.";
			    } else {
				mysql_query("ROLLBACK",$dbid);
			    }
			}
		    }
		} else {
		    $cm_group_id = string_wslashes($_POST['cm_group_id']);
		    if(!is_numeric($cm_group_id)) exit;
		    if(!mysql_query("SELECT 1 FROM tbl_alerts_group WHERE group_id = $cm_group_id AND sys_id = $param_session_sys_id AND owner_id = $param_session_user_user_id",$dbid)) {
			$error_found = true;
			$error_no = "1603";
			mysql_query("ROLLBACK",$dbid);
		    }
		    else {
			if(sizeof($memberstodel) > 0) {
			    $members2del = trim(join(",",$memberstodel),",");
			    if(mysql_query("DELETE FROM tbl_alerts_group_members WHERE group_id = $cm_group_id AND mobile IN ($members2del)", $dbid)) {
				$rs_copy = mysql_query("SELECT * FROM tbl_alerts_group_members WHERE group_id = $group_id AND mobile IN ($members2del)", $dbid);
				$copy_success = true;
				while($row_copy = mysql_fetch_array($rs_copy)) {
				    $cm_mobile = mysql_escape_string($row_copy[1]);
				    $cm_name = mysql_escape_string($row_copy[2]);
				    $cm_loc = mysql_escape_string($row_copy[3]);
				    $cm_ot1 = mysql_escape_string($row_copy[4]);
				    $cm_ot2 = mysql_escape_string($row_copy[5]);
				    $copy_success = mysql_query("INSERT INTO tbl_alerts_group_members VALUES($cm_group_id, '$cm_mobile','$cm_name','$cm_loc','$cm_ot1','$cm_ot2')", $dbid);
				    if(!$copy_success) {
					break;
				    }
				}
				if(!$copy_success) {
				    mysql_query("ROLLBACK",$dbid);
				} else {
				    if(mysql_query("DELETE FROM tbl_alerts_group_members WHERE group_id = $group_id AND  mobile IN ($members2del)", $dbid)) {
					mysql_query("COMMIT",$dbid);
					$reply_msg = "Group members have been moved successfully.";
				    } else {
					mysql_query("ROLLBACK",$dbid);
				    }
				}

			    } else {
				mysql_query("ROLLBACK",$dbid);
			    }
			} else {
			    $reply_msg = "You didn't select any group member.";
			}
		    }
		}
	    }
}

db_close($dbid);

if ($error_found) {
    header("Location: $param_server"."/templates/html/error.php?en=".$error_no);
}
else {
    header("Location: editm_group.php?gid=$group_id&msg=$reply_msg");
}

?>
