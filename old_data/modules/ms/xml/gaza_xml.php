<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

/* 
 * Gaza XML
 */
header("Content-type: text/xml");
require_once("../../../config/parameters/params_db.php");
require_once("../../../config/database/db_mysql.php");
$dbid = db_connect();

//Rule 1
//LIMIT PAGING INTERVAL
$limit1 = $_GET['int1'];
$limit2 = $_GET['int2'];
$limit_stm = "";

if(is_numeric($limit1) && is_numeric($limit2) && $limit1 >= 0 && $limit2 >= 0) $limit_stm = " LIMIT $limit1, $limit2";

//Rule 2
//Message Id Greater THAN
$gtid = $_GET['gtid'];
$gt_stm = "";
if(is_numeric($gtid) && $gtid >= 0) $gt_stm = " AND id > $gtid "; 

//Rule 3
//Exact Message Id
$mid = $_GET['mid'];
$mid_stm = "";
if(is_numeric($mid) && $mid >= 0) $mid_stm = " AND id = $mid ";

//Rule 4
//Push Download
if(strtolower($_GET['dnl'])=="true")header("Content-Disposition: attachment; filename=gaza_results.xml"); 

$rs = @mysql_query("SELECT id, mobile, text, convert_tz(msg_time,'-05:00','+03:00') AS msgt FROM tbl_mini_survey WHERE sys_id = 12 $gt_stm $mid_stm ORDER BY id DESC".$limit_stm,$dbid);
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
echo "<gaza>";
while($row = @mysql_fetch_array($rs))
{
    $rs_id = $row['id'];
    $rs_mobile = $row['mobile'];
    $rs_text = stripslashes($row['text']);
    $rs_time = $row['msgt'];
    ?>
<participation id="<?php echo $rs_id;?>">
    <mobile><?php echo $rs_mobile;?></mobile>
    <time><?php echo $rs_time;?></time>
    <message><?php echo htmlspecialchars($rs_text);?></message>
</participation>
<?php
}
echo "</gaza>";
?>
