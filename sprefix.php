<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$system_found = false;
$prefix_systems = array();
$systems_cnt = 0;

$query_sprefix = "SELECT prefix , url FROM tbl_sys where status = 1 ORDER BY sys_id";
$rs_sprefix = mysql_query($query_sprefix,db_connect());

while($row_prefix = mysql_fetch_array($rs_sprefix)) {

    $prefix_systems[$systems_cnt][0] = strtoupper($row_prefix[0]); //Prefix
    $prefix_systems[$systems_cnt][1] = strtolower($row_prefix[1]); //URLwithout WWW, or IP Address
    $systems_cnt++;
}

for($i=0; $i<sizeof($prefix_systems); $i++)
{
    if(strtolower($_SERVER["HTTP_HOST"])==$prefix_systems[$i][1]
        || strtolower($_SERVER["HTTP_HOST"])=="www.".$prefix_systems[$i][1])
    {
        $extended_get1 = $prefix_systems[$i][0];
        $extended_get2 = sha1("6784567GFD".$extended_get1."214XdT00".$extended_get1."sktxx#21");
        $system_found = true;
        break;
    }
}

if(!$system_found) header('HTTP/1.0 404 Not Found');

?>
