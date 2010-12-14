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
$dbid1 = db_connect();
$referrer = $_SERVER['HTTP_REFERER'];

?>
<form name="skform" method="POST" action="<?php echo $file_name."?act=1";?>">
    <input type="hidden" name="return_url" value="<?php echo $_GET['ru']==""?$referrer:$_GET['ru'];?>">
    <table border="0" width="100%" cellspacing="3" cellpadding="6" style="border-collapse: collapse">
        <tr>
            <td width="96%" colspan="3">
                <font face="Trebuchet MS" style="font-size: 10pt">
            <span lang="en-us">Please choose which modules to set as default for new users.</span></font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><b><font face="Trebuchet MS" size="2">Default Modules For Individual Users</font></b></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2"><font face="Trebuchet MS" size="2">
                    <?php
                    $rs = mysql_query("SELECT rm.module_id, rmt.name, (SELECT 1 FROM tbl_sys_default_usertype_module dm WHERE dm.sys_id = sm.sys_id AND dm.module_id = sm.module_id AND dm.type_id = 1) FROM tbl_ref_module rm, tbl_sys_module sm, tbl_ref_module_title rmt WHERE sm.module_id = rm.module_id AND sm.module_id <> 5 AND sm.module_id NOT IN(1,2,7,8) AND rmt.module_id = rm.module_id AND rmt.language_id = 1 AND sm.sys_id = $param_session_sys_id", $dbid1);
                    while($row = mysql_fetch_array($rs))
                    {
                        ?>
                    <input type="checkbox" name="av_module_ind[]" value="<?php echo $row[0];?>" <?php echo $row[2]==1?"checked":"";?>>&nbsp;<?php echo $row[1];?><br>
                    <?php
                }
                ?>
            </font></td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%"><b><font face="Trebuchet MS" size="2">Default Modules For Non Individual Users</font></b></td>
            <td width="49%">&nbsp;</td>
        </tr>
        <tr>
            <td width="3%">&nbsp;</td>
            <td width="48%" colspan="2"><font face="Trebuchet MS" size="2">
                    <?php
                    $rs = mysql_query("SELECT rm.module_id, rmt.name, (SELECT 1 FROM tbl_sys_default_usertype_module dm WHERE dm.sys_id = sm.sys_id AND dm.module_id = sm.module_id AND dm.type_id = 2) FROM tbl_ref_module rm, tbl_sys_module sm, tbl_ref_module_title rmt WHERE sm.module_id = rm.module_id AND sm.module_id <> 6 AND sm.module_id NOT IN(1,2,7,8) AND rmt.module_id = rm.module_id AND rmt.language_id = 1 AND sm.sys_id = $param_session_sys_id", $dbid1);
                    while($row = mysql_fetch_array($rs))
                    {
                        ?>
                    <input type="checkbox" name="av_module_nind[]" value="<?php echo $row[0];?>" <?php echo $row[2]==1?"checked":"";?>>&nbsp;<?php echo $row[1];?><br>
                    <?php
                }
                ?>
            </font></td>
        </tr>
        <tr>
            <td width="48%" colspan="3">
		<input type="submit" value="Assign Defaults" name="submit"/>
		<input type="button" value="Cancel" onclick="javascript:gogo('<?php echo 'index.php';?>')">
	    </td>
        </tr>
    </table>
</form>
<?php
db_close($dbid1);
?>
