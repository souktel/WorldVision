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

$sys_id = string_wslashes($_POST['sys_id']);
if(!is_numeric($sys_id)) exit;
if($sys_id == 1 || $sys_id == "1") exit;

//Validation Data Fields
$errors = array();
$rules = array();

//Error Flag
$error_found = false; //No Errors at first
$error_no = "";

$name = string_wslashes($_POST['name']);
$prefix = trim(string_wslashes(trim($_POST['prefix'])));
$country = string_wslashes($_POST['country']);
$language = string_wslashes($_POST['language']);
$system_status = string_wslashes($_POST['system_status']);
$sms_status = string_wslashes($_POST['sms_status']);
$other_info1 = string_wslashes($_POST['other_info1']);
$other_info2 = string_wslashes($_POST['other_info2']);

//Modules
$modules = array();
for($i = 0; $i < sizeof($_POST['module']); $i++)
{
    $modules[] = string_wslashes($_POST['module'][$i]);
}

//Name
$rules[] = ("required,name,Required : Name.");
$rules[] = ("length<=100,name,Name : < 100 chars please.");

//Prefix
$rules[] = ("required,prefix,Required : Prefix.");
$rules[] = ("letters_only,prefix,Prefix : a-Z only please.");
$rules[] = ("length=1-4,prefix,Prefix : 1-4 chars");    

$errors = validateFields($_POST, $rules);

if (sizeof($errors)==0)
{
    $dbid = db_connect();

    mysql_query("BEGIN");

    //Select First City For The Selected Country
    $rs_city = mysql_query("SELECT city_id FROM tbl_ref_city WHERE country_id = $country", $dbid);
    $row_city = mysql_fetch_array($rs_city);
    $city = $row_city[0];
    //==

    $rs_system = mysql_query("UPDATE tbl_sys SET prefix = '$prefix', reference_code = '$prefix', name = '$name', default_language = $language, country = $country, status = $system_status, sms_status = $sms_status, other_info1 ='$other_info1', other_info2 ='$other_info2' WHERE sys_id = $sys_id", $dbid);

    if($rs_system)
    {
        //Delete All Previous Modules
        mysql_query("DELETE FROM tbl_sys_module WHERE sys_id = $sys_id AND module_id <> 1", $dbid);
        //==
        $modules_error = false; //No Error :default
        for($i = 0; $i < sizeof($modules); $i++)
        {
            $module_id = $modules[$i];
            if(!mysql_query("INSERT INTO tbl_sys_module VALUES($sys_id, $module_id)", $dbid))
            {
                $modules_error = true;
            }
        }
        if(!$error_found && !$modules_error) mysql_query("COMMIT");
    }
    else
    {
        $error_found = true;
        $error_no = "1602";
        mysql_query("ROLLBACK");
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
    header("Location: ".$param_server."/modules/admin/index.php");
}
?>