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
$group_id = string_wslashes($_GET['gid']);
$msg = string_wslashes($_GET['msg']);
if(!is_numeric($group_id)) exit;
$referrer = $_SERVER['HTTP_REFERER']; 
?>
<form name="skform" method="POST" action="<?php echo $file_name."?act=1";?>">
    <input type="hidden" name="group_id" value="<?php echo $group_id;?>">
    <input type="hidden" name="return_url" value="<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td width="96%" colspan="3">
                <font face="Trebuchet MS" style="font-size: 10pt" color="RED">
		    <span lang="en-us">Are you sure you want to delete this group <?php echo $msg;?>.</span></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2">
		<input type="submit" value="Yes(Delete Group)" name="submit"/>
		<input type="button" value="Cancel" onclick="javascript:gogo('<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>')">
	    </td>
        </tr>
    </table>
</form>
