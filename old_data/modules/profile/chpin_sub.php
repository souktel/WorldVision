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

//Validation Data Fields
$errors = array();
$rules = array();

//Error Flag
$error_found = false; //No Errors at first
$error_no = "";

$pin = string_wslashes($_POST['pin']);

//New PIN CODE
$rules[] = ("digits_only,pin,New PIN : Digits only please.");
$rules[] = ("required,pin,Required : New PIN.");
$rules[] = ("length=4-4,pin,New PIN : 4 Digits");   

$errors = validateFields($_POST, $rules);

if (sizeof($errors)==0)
{
    $dbid = db_connect();

    $query = "UPDATE tbl_sys_user SET pin = $pin WHERE user_id = $param_session_user_user_id AND sys_id = $param_session_sys_id";

    mysql_query("BEGIN");

    if(!mysql_query($query, $dbid))
    {
        mysql_query("ROLLBACK");
        $error_found = true;
        $error_no = "1502";
    }

    if(!$error_found) mysql_query("COMMIT");

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
    $return_url = $_POST["return_url"];
    header("Location: $return_url");
}

?>
