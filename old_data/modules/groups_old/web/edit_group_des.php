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
$error_found = false;

$group_id = string_wslashes($_GET['gid']);
if(!is_numeric($group_id)) exit;

$dbid = db_connect();

if($rs = mysql_query("SELECT name, group_desc, status, public_group FROM tbl_alerts_group WHERE group_id = $group_id AND sys_id = $param_session_sys_id AND owner_id = $param_session_user_user_id", $dbid))
{
    if($row = mysql_fetch_array($rs))
    {
        $rs_name = $row[0];
        $rs_desc = $row[1];
        $rs_status = $row[2];
        $rs_public_group = $row[3];
        $rs_senders = array();
        $rs_senders_n = array();

        if($rs1 = mysql_query("SELECT su.mobile, su.name FROM tbl_alerts_group_senders gs, tbl_sys_user su WHERE gs.group_id = $group_id AND su.user_id = gs.sender_id", $dbid))
        {
            while($row1 = mysql_fetch_array($rs1))
            {
                $rs_senders[] = $row1[0];
                $rs_senders_n[] = $row1[1];
            }
        }

    }
}
else
{
    exit;
}

db_close($dbid);  

$referrer = $_SERVER['HTTP_REFERER'];

?>

<input type="hidden" value="0" id="theValue1" />
<script type="text/javascript">

    function addSender()
    {
        var ni = document.getElementById('myDiv1');
        var numi = document.getElementById('theValue1');
        var num = (document.getElementById("theValue1").value -1)+ 2;
        numi.value = num;
        var divIdName = "my"+num+"Div1";
        var newdiv = document.createElement('div');
        newdiv.setAttribute("id",divIdName);
        newdiv.innerHTML = "<font face=\"Trebuchet MS\" size=\"2\">Mobile:&nbsp;<input type=\"text\" name=\"senders[]\" size=\"15\">&nbsp;<a href=\"javascript:;\" onclick=\"javascipt:addSender();\">ADD</a>&nbsp;|&nbsp;<a href=\"javascript:;\" onclick=\"removeSender(\'"+divIdName+"\')\">DELETE</a><br><br></font>";
        ni.appendChild(newdiv);
    }

    function removeSender(divNum)
    {
        var d = document.getElementById('myDiv1');
        var olddiv = document.getElementById(divNum);
        d.removeChild(olddiv);
    }

</script>

<script language="JavaScript" type="text/javascript">
    var rules = [];

    //Name
    rules.push("required,name,Required : Name.");
    rules.push("length<=100,name,Name : < 100 chars please.");

</script>

<form name="skform" method="POST" action="<?php echo $file_name."?act=1";?>" onsubmit="return validateFields(this, rules)">
    <input type="hidden" name="group_id" value="<?php echo $group_id;?>">
    <input type="hidden" name="return_url" value="<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td width="96%" colspan="3">
                <font face="Trebuchet MS" style="font-size: 10pt">
		    Fill in the Group Name and Description. This information will be used internally to identify the group, but does not appear publicly.
		</font>
	    </td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Group Name<font color="#FF0000">
            *</font></font></td>
            <td width="49%"><font face="Trebuchet MS" size="2">Group Status<font color="#FF0000">
            *</font></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Verdana" style="font-size: 11pt">
                    <span style="font-size: 11pt"><font face="Trebuchet MS">
            <input name="name" size="35" value="<?php echo $rs_name;?>"/></font></span></font></td>
            <td width="49%"><select name="status">
                    <option value="0" <?php if($rs_status == 0){ echo "SELECTED"; }?>>OFF</option>
                    <option value="1" <?php if($rs_status == 1){ echo "SELECTED"; }?>>ON</option>
            </select></td>
        </tr>
        <?php if($param_session_sys_public == 1 || $param_session_sys_public == '1') {?>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Public Group</font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2">
                <select name="pgrp" style="width:245px;">
                    <option value="0" <?php if($rs_public_group == 0){ echo "SELECTED"; }?>>False</option>
                    <option value="1" <?php if($rs_public_group == 1){ echo "SELECTED"; }?>>True</option>
                </select>
            </td>
        </tr>
        <?php }?>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><font face="Trebuchet MS" size="2">Description</font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2">
            <textarea rows="4" name="description" cols="60"><?php echo $rs_desc;?></textarea></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td colspan="2">
		<font face="Trebuchet MS" size="2">
		    <b>Permission to Mobile numbers</b>
		    <br>Authorize Users to send messages to this group from their mobile phone (optional). Enter a mobile number and click on ADD.
		</font>
	    </td>
        </tr>
        <?php
        for($is = 0; $is < sizeof($rs_senders); $is++)
        {
            $sender = $rs_senders[$is];
            $sender_n = $rs_senders_n[$is];
            ?>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><input type="checkbox" name="senders[]" value="<?php echo $sender;?>" checked /><font face="Trebuchet MS" size="2">&nbsp;<?php echo $sender;?>&nbsp;[<?php echo $sender_n;?>]</font></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <?php
    }
    ?>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2">
		<div id="myDiv1">
		<font face="Trebuchet MS" size="2"><font style="font-size:7pt;">Please note: enter mobile numbers with country code, area code and the number. Do not use spaces or symbols.<br></font>Mobile:&nbsp;<input type="text" name="senders[]" size="15">&nbsp;<a href="javascript:;" onclick="javascipt:addSender();">ADD</a><br><br></font>
		</div>
	    </td>
        </tr>
        <tr>
            <td width="48%" colspan="3">
            <input type="submit" value="Edit Group" name="submit"/>
	    <input type="button" value="Cancel" onclick="javascript:gogo('<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>')">
	    </td>
        </tr>
    </table>
</form>