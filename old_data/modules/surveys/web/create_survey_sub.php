<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

if($param_session_check != "zZ234vvvdkfgjZSD4352SDdfZz22W")
{
    header("Location: index.php");
}  
?>
<?php
/*
 * Tamer Qasim
 */

//Validation Data Fields
$errors = array();
$rules = array();

//Error Flag
$error_found = false; //No Errors at first
$error_no = "";

$title = string_wslashes($_POST['title']);
$description = string_wslashes($_POST['description']);

//Name
$rules[] = ("required,title,Required : Title.");
$rules[] = ("length<=100,title,Title : < 100 chars please.");

$errors = validateFields($_POST, $rules);

if (sizeof($errors)==0)
{
    $dbid = db_connect();

    mysql_query("BEGIN",$dbid);

    $rs = mysql_query("INSERT INTO tbl_survey VALUES(survey_id, $param_session_sys_id, $param_session_user_user_id,'',CURRENT_TIMESTAMP, CURRENT_TIMESTAMP,1,$param_session_sys_language, CURRENT_TIMESTAMP, 1)",$dbid);

    if(!$rs)
    {
        $error_found = true;
        $error_no = "1601";
        mysql_query("ROLLBACK",$dbid);
    }
    else
    {
        $current_id = mysql_insert_id($dbid);
        $reference = "S".($current_id+100);
        $rs1 = mysql_query("UPDATE tbl_survey SET reference_code = '$reference' WHERE survey_id = $current_id",$dbid);
        if(!$rs1)
        {
            $error_found = true;
            $error_no = "1602";
            mysql_query("ROLLBACK",$dbid);
        }
        else
        {
            $rs2 = mysql_query("INSERT INTO tbl_survey_title VALUES($current_id,$param_session_sys_language,'$title','$description')", $dbid);
            if(!$rs2)
            {
                $error_found = true;
                $error_no = "1602";
                mysql_query("ROLLBACK",$dbid);
            }
            else
            {
                mysql_query("COMMIT",$dbid);
            }
        }
    }

    db_close($dbid);

}
else
{
    $error_found = true;
    $error_no = "1501";
}

if ($error_found)
{
    //Failed
    header("Location: $param_server"."/templates/html/error.php?en=".$error_no);
}
else
{
    //Success
    header("Location: ".$param_server."/modules/surveys/web/index.php");
}

?>
