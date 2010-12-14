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

$user_id = string_wslashes($_POST['user_id']);

$name = trim(string_wslashes(trim($_POST['name'])));
$mobile = trim(string_wslashes(trim($_POST['mobile'])));

$password = string_wslashes($_POST['password']);
$pin = string_wslashes($_POST['pin']);

$country = string_wslashes($_POST['country']);
$city = string_wslashes($_POST['city']);

$email = string_wslashes($_POST['email']);

$status = string_wslashes($_POST['status']);

if($status != 1) $status = 0;

$usertype = string_wslashes($_POST['usertype']);

if($usertype == 1 || $usertype == "1")
{
    $year = string_wslashes($_POST['year']);
    $month = string_wslashes($_POST['month']);
    $day = string_wslashes($_POST['day']);
    $gender = string_wslashes($_POST['gender']);

    //DOB
    //$rules[] = ("valid_date,month,day,year,any_date,Date of Birth : Invalid Date.");

    //Gender
    $rules[] = ("digits_only,gender,Gender : Digits only please.");
    $rules[] = ("required,gender,Required : Gender.");

}
else if($usertype == 2 || $usertype == "2")
{
    $phone = string_wslashes($_POST['phone']);
    $fax = string_wslashes($_POST['fax']);
    $website = string_wslashes($_POST['website']);
    $business_field = string_wslashes($_POST['business_field']);
    $description = string_wslashes($_POST['description']);

    //Phone
    $rules[] = ("digits_only,phone,Phone : Digits only please.");
    $rules[] = ("length<=20,phone,Phone : < 20 digits please.");

    //Fax
    $rules[] = ("digits_only,fax,Fax : Digits only please.");
    $rules[] = ("length<=20,fax,Fax : < 20 digits please.");

}
//Name
$rules[] = ("required,name,Required : Name.");
$rules[] = ("length<=100,name,Name : < 100 chars please.");

//Mobile
$rules[] = ("digits_only,mobile,Mobile : Digits only please.");
$rules[] = ("required,mobile,Required : Mobile.");
$rules[] = ("length<=20,mobile,Mobile : < 20 digits please.");

//Country
$rules[] = ("digits_only,country,Country : Digits only please.");
$rules[] = ("required,country,Required : Country.");

//City
$rules[] = ("digits_only,city,City : Digits only please.");
$rules[] = ("required,city,Required : City.");

//User Type
$rules[] = ("digits_only,usertype,Usertype : Digits only please.");
$rules[] = ("required,usertype,Required : Usertype.");

//Email
$rules[] = ("valid_email,email,Email : Not Valid Email");

$errors = validateFields($_POST, $rules);

if (sizeof($errors)==0)
{
    $dbid = db_connect();

    $pin_stat = ", pin = '1234'";
    if($pin != "1234") $pin_stat = "";
    $password_stat = ", password = SHA1('1234')";
    if($password != "1234") $password_stat = "";

    $query = "UPDATE tbl_sys_user SET status = $status, mobile = '$mobile' $pin_stat $password_stat, name = '$name', country = $country, city = $city, email = '$email' WHERE user_id = $user_id AND sys_id = $param_session_sys_id";

    $query_unique_mobile = "SELECT user_id FROM tbl_sys_user WHERE sys_id = $param_session_sys_id AND user_id <> $user_id AND (mobile = '$mobile' OR username = '$mobile')";

    mysql_query("BEGIN");

    if($usertype == "1" || $usertype == 1)
    {
        $rs = mysql_query($query_unique_mobile, $dbid);

        if($row = mysql_fetch_array($rs))
        {
            $error_found = true;
            $error_no = "10101"; // Mobile number already exists
        }
        else
        {
            if(mysql_query($query,$dbid))
            {
                $query_insert = "UPDATE tbl_sys_user_ind SET dob_y = $year, dob_m = $month, dob_d = $day, gender = $gender WHERE user_id = $user_id";
                if(!mysql_query($query_insert,$dbid))
                {
                    $error_found = true;
                    $error_no = "1602";
                    mysql_query("ROLLBACK");
                }
                else
                {
                    if(!mysql_query("DELETE FROM tbl_sys_user_module WHERE user_id = $user_id AND module_id <> 1",$dbid))
                    {
                        $error_found = true;
                        $error_no = "1602";
                        mysql_query("ROLLBACK");
                    }
                    else
                    {
                        $av_module = $_POST['av_module'];
                        for ($modu=0;$modu<sizeof($av_module);$modu++)
                        {
                            $available_4user = $av_module[$modu];
                            $query_insert = "INSERT INTO tbl_sys_user_module VALUES($user_id,$available_4user)";
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
            }
            else
            {
                $error_found = true;
                $error_no = "1602";
                mysql_query("ROLLBACK");
            }
        }
    }
    else if($usertype == "2" || $usertype == 2)
    {
        $rs = mysql_query($query_unique_mobile, $dbid);

        if($row = mysql_fetch_array($rs))
        {
            $error_found = true;
            $error_no = "10101"; // Mobile number already exists
        }
        else
        {
            if(mysql_query($query,$dbid))
            {
                $query_insert = "UPDATE tbl_sys_user_nind SET phone = '$phone', fax = '$fax', website = '$website', business_field = '$business_field', business_desc = '$description' WHERE user_id = $user_id";
                if(!mysql_query($query_insert,$dbid))
                {
                    $error_found = true;
                    $error_no = "1602";
                    mysql_query("ROLLBACK");
                }
                else
                {
                    if(!mysql_query("DELETE FROM tbl_sys_user_module WHERE user_id = $user_id",$dbid))
                    {
                        $error_found = true;
                        $error_no = "1602";
                        mysql_query("ROLLBACK");
                    }
                    else
                    {
                        $av_module = $_POST['av_module'];
                        for ($modu=0;$modu<sizeof($av_module);$modu++)
                        {
                            $available_4user = $av_module[$modu];
                            $query_insert = "INSERT INTO tbl_sys_user_module VALUES($user_id,$available_4user)";
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
            }
            else
            {
                $error_found = true;
                $error_no = "1602";
                mysql_query("ROLLBACK");
            }
        }
    }
    else
    {
        $error_found = true;
        $error_no = "1601";
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
