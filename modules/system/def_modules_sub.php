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

$error_found = false;    

$dbid = db_connect();

mysql_query("BEGIN");

if(!mysql_query("DELETE FROM tbl_sys_default_usertype_module WHERE sys_id = $param_session_sys_id",$dbid))
{
    $error_found = true;
    $error_no = "1602";
    mysql_query("ROLLBACK");
}
else
{
    $av_module_ind = $_POST['av_module_ind'];
    for ($modu=0;$modu<sizeof($av_module_ind);$modu++)
    {
        $available_4user = $av_module_ind[$modu];
        $query_insert = "INSERT INTO tbl_sys_default_usertype_module VALUES(1,$param_session_sys_id,$available_4user)";
        if(!mysql_query($query_insert,$dbid))
        {
            $error_found = true;
            $error_no = "1602";
            mysql_query("ROLLBACK");
            break;
        }
    }

    if(!$error_found)
    {
        $av_module_nind = $_POST['av_module_nind'];
        for ($modu=0;$modu<sizeof($av_module_nind);$modu++)
        {
            $available_4user = $av_module_nind[$modu];
            $query_insert = "INSERT INTO tbl_sys_default_usertype_module VALUES(2,$param_session_sys_id,$available_4user)";
            if(!mysql_query($query_insert,$dbid))
            {
                $error_found = true;
                $error_no = "1602";
                mysql_query("ROLLBACK");
                break;
            }
        }
    }

}

if(!$error_found) mysql_query("COMMIT");    

db_close($dbid);

if ($error_found)
{
    //Failed
    header("Location: $param_server"."/templates/html/error.php?en=".$error_no);
}
else
{
    //Success
    $return_url = $_POST["return_url"];
    header("Location: $return_url");
}

?>
