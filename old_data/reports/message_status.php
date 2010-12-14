<?php require_once 'html_header.php';?>
<?php
$apath = '../';

function printStatus($status) {
    if($status == "004" || $status == "003" || $status == "008" || $status == "8" || $status == "1") return "Delivered";
    else if($status == "002" || $status == "011" || $status == "4") return "Queued";
	else if($status == "010") return "Expired";
	    else if($status == "001" || $status == "05" || $status == "006" || $status == "007" ||
		    $status == "009" || $status == "012" || $status == "2" || $status == "16") return "Failed";
		else return "Message Sent";
}

$printable = mysql_escape_string($_GET['printable']);

if($printable == "1" || $printable == 1) $printable = true; else $printable = false;

$fclient = mysql_escape_string($_GET['client']);
$sender = mysql_escape_string($_GET['sender']);
$recipient = mysql_escape_string($_GET['recipient']);
$fdate_from = mysql_escape_string($_GET['date_from']);
$fdate_to = mysql_escape_string($_GET['date_to']);
$message_text = mysql_escape_string($_GET['message_text']);
$status = mysql_escape_string($_GET['status']);

if($fclient == "") $fclient = "all";
if($fclient != "all") $client_or_all = " AND s.sys_id = $fclient";
if($sender != "") $sender_st = " AND s.sendby1 LIKE '%$sender%' ";
if($recipient != "") $recipient_st = " AND sr.mobile LIKE '%$recipient%' ";

if(trim($fdate_from) == "" || trim($fdate_to) == "") {
    $fdate_from = '2007-01-01';
    $fdate_to = date("Y-m-d");
}

$message_date_st = " AND DATE_FORMAT(s.time_stamp,'%Y-%m-%d') >= DATE_FORMAT('$fdate_from','%Y-%m-%d') AND DATE_FORMAT(s.time_stamp,'%Y-%m-%d') <= DATE_FORMAT('$fdate_to','%Y-%m-%d')";

if($status != "") $status_st = " AND sr.status IN('004','003','008','8', '1') ";

if($message_text != "") {
    $message_text = trim($message_text);
    $message_text_ar = split(" ", $message_text);
    for($i = 0; $i < sizeof($message_text_ar); $i++) {
	$or_loop .= ($i==0?"":"OR")." s.sms_body LIKE '%".($message_text_ar[$i])."%' ";
    }
    $or_loop = trim($or_loop);
    $message_text_st = " AND (".$or_loop.") ";
}

$query_select_part_all = "DISTINCT s.sendby1, sr.mobile, s.sms_body, ifnull(sr.status,'9999'), s.time_stamp, ifnull(sr.status_time,''), s.language_id, sys.reference_code ";
$query_select_part_count = "COUNT(0) ";

$query = "
SELECT $query_select_part_all 
FROM tbl_sms s, tbl_sms_receivers sr, tbl_sys sys 
WHERE s.sms_id = sr.sms_id AND sys.sys_id = s.sys_id $client_or_all $sender_st $recipient_st $message_date_st $message_text_st $status_st
ORDER BY s.time_stamp DESC, sr.status ASC
    ";

$query_count = "
SELECT $query_select_part_count
FROM tbl_sms s, tbl_sms_receivers sr, tbl_sys sys
WHERE s.sms_id = sr.sms_id AND sys.sys_id = s.sys_id $client_or_all $sender_st $recipient_st $message_date_st $message_text_st $status_st
    ";

$show_results = true;

?>
<?php if(!$printable) {?>
<form name="skform" method="GET" action="message_status.php">
    <input type="hidden" name="act" value="1">
    <input type="hidden" name="title" value="2">
    <table border="0" width="550" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
	<tr>
	    <td width="3%">&nbsp;</td>
	    <td width="48%">Choose Client Name</td>
	    <td width="49%">&nbsp;</td>
	</tr>
	<tr>
	    <td width="3%">&nbsp;</td>
	    <td colspan="2">
		<select name="client">
		    <option value="all">All Clients</option>
			<?php
			$query_client = "SELECT sys_id, prefix, name FROM tbl_sys ORDER BY sys_id DESC";
			$rs_client = mysql_query($query_client,$dbid);
			?>
			<?php while($row_client = mysql_fetch_array($rs_client)) {?>
			    <?php
			    $rs_client_id = $row_client[0];
			    $rs_client_prefix = $row_client[1];
			    $rs_client_name = $row_client[2];
			    echo "<option value=\"$rs_client_id\" ".($fclient==$rs_client_id?"selected":"").">$rs_client_name [$rs_client_prefix]</option>";
			    ?>
			<?php }?>
		</select>
	    </td>
	</tr>
	<tr>
	    <td width="3%">&nbsp;</td>
	    <td width="48%">Sender</td>
	    <td width="49%">Recipient</td>
	</tr>
	<tr>
	    <td width="3%">&nbsp;</td>
	    <td width="48%"><input type="text" name="sender" size="30" value="<?php echo stripslashes($sender);?>"></td>
	    <td width="49%"><input type="text" name="recipient" size="30" value="<?php echo stripslashes($recipient);?>"></td>
	</tr>
	<tr>
	    <td width="3%">&nbsp;</td>
	    <td width="48%">Date From</td>
	    <td width="49%">Date To</td>
	</tr>
	<tr>
	    <td width="3%">&nbsp;</td>
	    <td width="48%"><input type="text" value="<?php echo stripslashes($fdate_from);?>" name="date_from" value="0" maxlength="10" size="30"><br><font size="2" color="RED">e.g. 2009-03-25</font></td>
	    <td width="49%"><input type="text" value="<?php echo stripslashes($fdate_to);?>" name="date_to" value="0" maxlength="10" size="30"><br><font size="2" color="RED">e.g. 2009-03-25</font></td>
	</tr>
	<tr>
	    <td width="3%">&nbsp;</td>
	    <td width="48%"><font face="Trebuchet MS" size="2">Message Text</font></td>
	    <td width="49%">&nbsp;</td>
	</tr>
	<tr>
	    <td width="3%">&nbsp;</td>
	    <td width="48%"><input type="text" name="message_text" size="30" value="<?php echo stripslashes($message_text);?>"></td>
	    <td width="49%">&nbsp;</td>
	</tr>
	<tr>
	    <td width="3%">&nbsp;</td>
	    <td width="49%">
		<input type="checkbox" name="status" value="1" <?php echo $status!=""?"checked":""; ?>>&nbsp;Delivered Only&nbsp;<input type="checkbox" name="printable" value="1">&nbsp;Printable View
	    </td>
	</tr>
	<tr>
	    <td width="48%" colspan="3">
		<input type="submit" value="Filter Sent Messages" name="submit"/>
	    </td>
	</tr>
    </table>
</form>
<?php }?>

<table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
    <?php if(!$printable) {?>
    <tr>
	<td colspan="7"><hr size="0" noshade></td>
    </tr>
    <?php }?>
    <tr>
	<td width="60"><b><u>Prefix</u></b></td>
	<td width="120"><b><u>Sender</u></b></td>
	<td width="120"><b><u>Recipient</u></b></td>
	<td width="150"><b><u>Message Date</u></b></td>
	<td width="100"><b><u>Status</u></b></td>
	<td width="150"><b><u>Delivery Date</u></b></td>
	<td><b><u>Message Text</u></b></td>
    </tr>
    <?php if($show_results) {?>
	<?php
	$pageNum = 1;
	if(isset($_GET['page'])) {
	    if(is_numeric($_GET['page'])) $pageNum = $_GET['page'];
	}

	$rowsPerPage = 50;

	$offset = ($pageNum - 1) * $rowsPerPage;

	$numrows_rs = mysql_query($query_count,$dbid);
	$numrows_row = mysql_fetch_array($numrows_rs);
	$numrows = $numrows_row[0];

	$rs = mysql_query($query." LIMIT $offset,$rowsPerPage",$dbid);
	?>
	<?php while($row = mysql_fetch_array($rs)) {?>
	    <?php
	    $rs_sender = stripslashes($row[0]);
	    $rs_recipient = stripslashes($row[1]);
	    $rs_message_text = stripslashes($row[2]);
	    $rs_status = stripslashes($row[3]);
	    $rs_time_stamp = stripslashes($row[4]);
	    $rs_status_time = stripslashes($row[5]);
	    $rs_langauge = stripslashes($row[6]);
	    $rs_prefix = stripslashes($row[7]);
	    ?>
    <tr>
	<td width="60"><?php echo $rs_prefix;?></td>
	<td width="120"><?php echo $rs_sender;?></td>
	<td width="120"><?php echo $rs_recipient;?></td>
	<td width="150"><?php echo $rs_time_stamp;?></td>
	<td width="100"><?php echo printStatus($rs_status);?></td>
	<td width="150"><?php echo $rs_status_time==""?"Waiting":$rs_status_time;?></td>
	<td align="left" <?php if(!isEnglish($rs_message_text)){?>dir="rtl"<?php }?>><font face="Trebuchet MS" size="2"><?php echo $rs_message_text;?></font></td>
    </tr>
	<?php }?>
    <tr>
	<td colspan="7"><hr size="0" noshade></td>
    </tr>
    <?php } else {
	echo $query;
    }?>
</table>
<?php 
if($show_results) {
    require_once($apath."config/functions/show_pages_func.php");
}
?>
<?php require_once 'html_footer.php';?>