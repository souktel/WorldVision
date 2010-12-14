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
	    Form.Element.Methods.disable('savenormal');
	    Form.Element.Methods.disable('sendsch');
	    Form.Element.Methods.disable('cancel1');
	    Form.Element.Methods.disable('cancel2');
	}
    }

    function hideProcessing () {
        if(Ajax.activeRequestCount <= 0) {
	    document.getElementById('inProgress').style.display = 'none';
	    Form.Element.Methods.enable('sendnormal');
	    Form.Element.Methods.enable('savenormal');
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

$user_groups = array();

$dbid = db_connect();

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

db_close($dbid);

?>

<form name="skform" onsubmit="return false;" action="#" method="POST">
    <input type="hidden" name="return_url" value="<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>">
    <input type="hidden" id="alert_id" value="">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
	<?php if($group_count > 0) {?>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2">
                <img src="../../../images/ajax-loader.gif" id ="inProgress" style="display: none" />
                <div id="responsediv" style="font-family:Verdana; font-size:10px;"></div>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2"><b>Title</b></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2"><input id="alert_title" name="alert_title" size="50" /></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2"><b>Alert/Message Text</b>&nbsp;<font color="#FF0000">*</font></font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2">
                <textarea style="width: 655px;" rows="6" id="alert_text" name="alert_text" cols="60" onkeyup="textCounter(document.skform.alert_text);" onkeydown="textCounter(document.skform.alert_text);"></textarea>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2" align="justify">
                <font face="Trebuchet MS" style="font-size:8pt;">
                    <input type="text" name="cnt" value="0" readonly="true" size="3">&nbsp;English SMS messages allow for 160 characters. Arabic SMS messages allow for 70 characters. Please Note: Additional content will be sent in a second SMS and will be subject to additional charges.
                </font>
            </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2">
                <font face="Trebuchet MS" size="2"><b>Choose Groups</b></font>
                <div id="scroll_box">
                    <font face="Trebuchet MS" size="2">
			    <?php for($gri = 0; $gri < $group_count; $gri++) { ?>
                        <input type="checkbox" align="middle" name="gid" value="<?php echo $user_groups[$gri][0];?>"><?php echo stripslashes($user_groups[$gri][1])." (".$user_groups[$gri][2].")";?><br>
			    <?php } ?>
                    </font>
                </div>
            </td>
        </tr>
        <tr>
            <td width="48%" colspan="3">
                <input type="button" value="Send Now" id="sendnormal" style="width:100px;" onclick="javascript:sendAlert('normal', 'SEND_NEW')"/>
                <input type="button" value="Save" id="savenormal" style="width:100px;" onclick="javascript:saveAlert('normal', 'SAVE')"/>
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
            <td colspan="2"><font face="Trebuchet MS" style="font-size:8pt;">To send a message at a specific date and time: Choose the date and the time, and either click on Schedule or Save & Send Later (to save your message and update it later).</font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2">
		<font face="Trebuchet MS" style="font-size:8pt;">
		    Date:&nbsp;<input name="schedule_date" type="Text" id="schedule_date" maxlength="25"  style="width:100px;" readonly="true" onclick="javascript:NewCal('schedule_date','ddmmyyyy',false,24)">&nbsp;<a href="javascript:NewCal('schedule_date','ddmmyyyy',false,24)"><img src="../../../images/cal.gif" width="16" height="16" border="0" alt="Pick a date"></a>
		    &nbsp;Time:&nbsp;<select name="schedule_time"  id="schedule_time" style="width:70px;">
			<option value="0"></option>
			    <?php
			    $st_id = 1;
			    for($hi = 0; $hi <= 23; $hi++) {
				$hour = $hi<=9?"0".$hi:$hi;
				for($mi = 0; $mi <= 45; $mi+=15) {
				    $minute = $mi<=9?"0".$mi:$mi;
				    echo "<option value=\"$st_id\">$hour:$minute</option>";
				    $st_id++;
				}
			    }
			    ?>
		    </select>
		    &nbsp;Repeat:&nbsp;<select name="repeat" id="schedule_repeat" style="width:100px;">
			<option value="0">No Repeat</option>
			<option value="1">Daily</option>
			<option value="2">Weekly</option>
			<option value="3">Monthly</option>
			<option value="4">Yearly</option>
		    </select>
		</font>
            </td>
        </tr>
        <tr>
            <td width="48%" colspan="3">
                <input type="button" value="Schedule" id="sendsch" style="width:100px;" onclick="javascript:saveAlert('scheduled', 'SCHEDULE_NEW')"/>
		<input type="button" value="Cancel" id="cancel2" onclick="javascript:gogo('<?php echo $_SERVER['HTTP_REFERER'];?>')">
            </td>
        </tr>
	<?php } else {?>
        <tr>
            <td width="96%" colspan="3">
                <font style="font-size: 10pt" face="Trebuchet MS" color="#FF0000">
                    You do not have any group to send sms message to.
                </font>
            </td>
        </tr>
	<?php }?>
    </table>
</form>