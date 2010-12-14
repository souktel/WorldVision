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

<script language="javascript" type="text/javascript" src="../../../templates/js/prototype.js"></script>
<script language="javascript" type="text/javascript" src="../../../templates/js/datetimepicker.js"></script>

<script language="JavaScript" type="text/javascript">

    Ajax.Responders.register({
        onCreate: showProcessing,
        onComplete: hideProcessing
    });

    function showProcessing() {
        if(Ajax.activeRequestCount > 0) {
	    document.getElementById('inProgress').style.display = 'inline';
	    Form.Element.Methods.disable('sendnormal');
	    Form.Element.Methods.disable('sendsch');
	    Form.Element.Methods.disable('cancel1');
	    Form.Element.Methods.disable('cancel2');
	}
    }

    function hideProcessing () {
        if(Ajax.activeRequestCount <= 0) {
	    document.getElementById('inProgress').style.display = 'none';
	    Form.Element.Methods.enable('sendnormal');
	    Form.Element.Methods.enable('sendsch');
	    Form.Element.Methods.enable('cancel1');
	    Form.Element.Methods.enable('cancel2');
	}
    }

    function process(responseText)
    {
	var response = responseText.responseText.split('@@@');
	document.getElementById('alert_id').value = response[0];
	document.getElementById('responsediv').innerHTML = '<font face="Verdana" size="2"><b>'+response[1]+'</b></font>';
    }

    function saveAlert(alert_type, alert_oper) {
        var url = 'save_alert.php';
        var elements = document.getElementsByName('gid');
        var groups = '';
        var j = 0;
        for (var i = 0; i < elements.length; i++ ) {
            if (elements[i].type == 'checkbox') {
                if (elements[i].checked == true) {
                    j++;
                    groups += elements[i].value + '-';
                }
            }
        }

        if(validateFields(document.skform, rules))
        {
            if(j!=0)
            {
                new Ajax.Request(url, {
                    method: 'post',
                    parameters: {
                        alert_id: document.getElementById('alert_id').value,
                        alert_title: document.getElementById('alert_title').value,
                        alert_text: document.getElementById('alert_text').value,
                        gid: groups,
                        type: alert_type,
                        oper_type: alert_oper,
                        schedule_date: document.getElementById('schedule_date').value,
                        schedule_time: document.getElementById('schedule_time').value,
                        schedule_repeat: document.getElementById('schedule_repeat').value
                    },
		    onSuccess: process
                });
            } else {
                alert('Required : Select One Group At Least.');
            }
        }
    }

    function sendAlert(alert_type, alert_oper) {
        var url = 'save_alert.php';
        var elements = document.getElementsByName('gid');
        var groups = '';
        var j = 0;
        for (var i = 0; i < elements.length; i++ ) {
            if (elements[i].type == 'checkbox') {
                if (elements[i].checked == true) {
                    j++;
                    groups += elements[i].value + '-';
                }
            }
        }

        if(validateFields(document.skform, rules_send))
        {
            if(j!=0)
            {
                new Ajax.Request(url, {
                    method: 'post',
                    parameters: {
			alert_id: document.getElementById('alert_id').value,
                        alert_title: document.getElementById('alert_title').value,
                        alert_text: document.getElementById('alert_text').value,
                        gid: groups,
                        type: alert_type,
                        oper_type: alert_oper
                    },
		    onSuccess: process
                });
            } else {
                alert('Required : Select One Group At Least.');
            }
        }
    }
</script>

<style type="text/css" media="all">

    #scroll_box {
        border: 1px solid #ccc;
        height: 60px;
        width: 655px;
        overflow: auto;
        margin: 1em 0;
        background-color:white;
    }

</style>

<script language="JavaScript" type="text/javascript">
    function textCounter(field) {
        var maxlimit = 480;
        var fsum = document.skform.alert_text.value.length;
        if (fsum > maxlimit)
        {
            fsum = maxlimit;
            field.value = field.value.substring(0, field.value.length-1);
        }
        else
        {
            document.skform.cnt.value = fsum;
        }
    }
</script>

<script language="JavaScript" type="text/javascript">
    var rules = [];

    rules.push("required,alert_title,Required : Title.");
    rules.push("length<=200,alert_title,Title : <= 200 chars please.");

    rules.push("required,alert_text,Required : Alert/Message Text.");
    rules.push("length<=480,alert_text,Alert/Message Text : <= 480 chars please.");

    var rules_send = [];

    rules_send.push("required,alert_text,Required : Alert/Message Text.");
    rules_send.push("length<=480,alert_text,Alert/Message Text : <= 480 chars please.");
</script>

<?php
$error_found = false;

$message_id = string_wslashes($_GET['aid']);
if(!is_numeric($message_id)) exit;

$dbid = db_connect();

$rs = mysql_query("SELECT * FROM tbl_alerts_message WHERE message_id = $message_id AND user_id = $param_session_user_user_id", $dbid);
if($rs) {
    if($row = mysql_fetch_array($rs)) {
	$alert_title = stripslashes($row['title']);
	$alert_text = stripslashes($row['body']);
	$date_created = stripslashes($row['creation_date']);
	$scheduled = stripslashes($row['is_scheduled']);
	if($scheduled=="1") {
	    $schedule_date = stripslashes($row['schedule_date']);
	    $schedule_time = stripslashes($row['schedule_time']);
	    $repeat = stripslashes($row['is_repeat']);
	}
	else {
	    $schedule_date = "";
	    $schedule_time = "";
	}
	$status = stripslashes($row['status']);

    }
    else {
	exit;
    }
}
else {
    exit;
}

?>

<?php

$user_groups = array();

//Groups the user owns
$rs_my_groups = mysql_query("
SELECT DISTINCT ag.group_id, ag.name, ag.reference_code
FROM tbl_sys_user su, tbl_alerts_group ag
WHERE su.sys_id = $param_session_sys_id
AND su.user_id = $param_session_user_user_id
AND ag.owner_id = su.user_id
AND ag.status > 0
ORDER BY ag.addition_date DESC"
    ,$dbid);

$group_count = 0;

if($rs_my_groups) {
    while($row_my_groups = mysql_fetch_array($rs_my_groups)) {
	$user_groups[$group_count][0] = $row_my_groups[0];
	$user_groups[$group_count][1] = $row_my_groups[1];
	$user_groups[$group_count][2] = $row_my_groups[2];
	$group_count++;
    }
}
else {
    exit;
}

$referrer = $_SERVER['HTTP_REFERER'];

$rs_my_groups = mysql_query("
SELECT DISTINCT ag.group_id, ag.name, ag.reference_code
FROM tbl_sys_user su, tbl_alerts_group ag, tbl_alerts_group_senders ags
WHERE su.sys_id = $param_session_sys_id
AND ags.sender_id = $param_session_user_user_id
AND ag.owner_id = su.user_id
AND ag.group_id = ags.group_id
AND ag.status > 0
ORDER BY ag.addition_date DESC"
    ,$dbid);

if($rs_my_groups) {
    while($row_my_groups = mysql_fetch_array($rs_my_groups)) {
	$user_groups[$group_count][0] = $row_my_groups[0];
	$user_groups[$group_count][1] = $row_my_groups[1];
	$user_groups[$group_count][2] = $row_my_groups[2];
	$group_count++;
    }
}
else {
    exit;
}

?>

<form name="skform" onsubmit="return false;" action="#" method="POST">
    <input type="hidden" id="alert_id" value="<?php echo $_GET['aid'];?>">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2">
                <img src="../../../images/ajax-loader.gif" id ="inProgress" style="display: none" />
                <div id="responsediv"></div>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2"><b>Title</b></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2"><input id="alert_title" name="alert_title" size="50" value="<?php echo $alert_title;?>"/></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2"><b>Alert/Message Text</b></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2">
                <textarea style="width: 655px;" rows="6" id="alert_text" name="alert_text" cols="60" onkeyup="textCounter(document.skform.alert_text);" onkeydown="textCounter(document.skform.alert_text);"><?php echo $alert_text;?></textarea>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2" align="justify">
                <font face="Trebuchet MS" style="font-size:8pt;">
                    <input type="text" name="cnt" value="<?php echo strlen($alert_text)?>" readonly="true" size="3">&nbsp;English SMS messages allow for 160 characters. Arabic SMS messages allow for 70 characters. Please Note: Additional content will be sent in a second SMS and will be subject to additional charges.
                </font>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2">
                <font face="Trebuchet MS" size="2"><b>Alert Groups</b>
                    <div id="scroll_box">
                        <font face="Trebuchet MS" size="2">
			    <?php
			    $current_groups = array();
			    $rs_groups = mysql_query("SELECT g.group_id FROM tbl_alerts_message msg, tbl_alerts_message_groups mg, tbl_alerts_group g WHERE msg.message_id = mg.message_id AND mg.group_id = g.group_id AND msg.user_id = $param_session_user_user_id AND msg.message_id = $message_id", $dbid);
			    while($row_groups = mysql_fetch_array($rs_groups)) {
				$current_groups[] = $row_groups['group_id'];
			    }?>
			    <?php for($gri = 0; $gri < $group_count; $gri++) { ?>
                            <input type="checkbox" align="middle" name="gid" value="<?php echo $user_groups[$gri][0];?>"<?php echo (in_array($user_groups[$gri][0], $current_groups)?" checked":"");?>><?php echo stripslashes($user_groups[$gri][1])." (".$user_groups[$gri][2].")";?><br>
			    <?php }?>
                        </font>
                    </div>
                </font>
            </td>
        </tr>
        <tr>
            <td width="48%" colspan="3">
                <input type="button" value="Send Now" id="sendnormal" style="width:100px;" onclick="javascript:sendAlert('normal', 'SEND_SAVED')"/>
		<input type="button" value="Cancel" id="cancel1" onclick="javascript:gogo('<?php echo $_SERVER['HTTP_REFERER'];?>')">
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2"><b>Scheduled Alerts</b></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2"><font face="Trebuchet MS" style="font-size:8pt;">To send a scheduled message on a specific date and time, choose the date and set the time for your messgae and click on Send Schedule message button or press on Save& Schedule later to save your message and update it later</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2">
		<?php
		$date_split = split('-', $schedule_date);
		$schedule_date = $date_split[2].'-'.$date_split[1].'-'.$date_split[0];
		$schedule_date = trim($schedule_date, "-");
		?>
		<font face="Trebuchet MS" style="font-size:8pt;">
		    Date:&nbsp;<input name="schedule_date" type="Text" id="schedule_date" maxlength="25" value="<?php echo $schedule_date?>" style="width:100px;" readonly="true" onclick="javascript:NewCal('schedule_date','ddmmyyyy',false,24)">&nbsp;<a href="javascript:NewCal('schedule_date','ddmmyyyy',false,24)"><img src="../../../images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
		    &nbsp;Time:&nbsp;<select name="schedule_time"  id="schedule_time" style="width:70px;">
			<option value="0"></option>
			<?php
			$st_id = 1;
			for($hi = 0; $hi <= 23; $hi++) {
			    $hour = $hi<=9?"0".$hi:$hi;
			    for($mi = 0; $mi <= 45; $mi+=15) {
				$minute = $mi<=9?"0".$mi:$mi;
				echo "<option value=\"$st_id\" ".($schedule_time==$st_id?"SELECTED":"").">$hour:$minute</option>";
				$st_id++;
			    }
			}
			?>
		    </select>
		    &nbsp;Repeat:&nbsp;<select name="repeat" id="schedule_repeat" style="width:100px;">
			<option value="0" <?php echo $repeat==0?" SELECTED":"";?>>No Repeat</option>
			<option value="1" <?php echo $repeat==1?" SELECTED":"";?>>Daily</option>
			<option value="2" <?php echo $repeat==2?" SELECTED":"";?>>Weekly</option>
			<option value="3" <?php echo $repeat==3?" SELECTED":"";?>>Monthly</option>
			<option value="4" <?php echo $repeat==4?" SELECTED":"";?>>Yearly</option>
		    </select>
		</font>
            </td>
        </tr>
        <tr>
            <td width="48%" colspan="3">
                <input type="button" value="Schedule" id="sendsch" style="width:100px;" onclick="javascript:saveAlert('scheduled', 'SCHEDULE_SAVED')"/>
		<input type="button" value="Cancel" id="cancel2" onclick="javascript:gogo('<?php echo $_SERVER['HTTP_REFERER'];?>')">
            </td>
        </tr>
    </table>
</form>
<?php
db_close($dbid);

$referrer = $_SERVER['HTTP_REFERER'];

?>