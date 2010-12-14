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
$error_found = false;

$group_id = string_wslashes($_POST['group_id']);
if(!is_numeric($group_id)) exit;

$submit = strtoupper($_POST['submit']);

if($submit == "EXPORT")
{
    $dbid = db_connect();

    if($rs = mysql_query("SELECT reference_code, name FROM tbl_alerts_group WHERE group_id = $group_id AND sys_id = $param_session_sys_id AND owner_id = $param_session_user_user_id", $dbid))
    {
        if($row = mysql_fetch_array($rs))
        {
            $group_reference = $row[0];
            $group_name = $row[1];
            if($rs1 = mysql_query("SELECT * FROM tbl_alerts_group_members WHERE group_id = $group_id", $dbid))
            {
                while($row1 = mysql_fetch_array($rs1))
                {
                    $rs_members[] = $row1[1];
                    $rs_members_name[] = $row1[2];
                    $rs_members_loc[] = $row1[3];
                    $rs_members_ot1[] = $row1[4];
                    $rs_members_ot2[] = $row1[5];
                }
            }
        }
        else
        {
            exit;
        }
    }
    else
    {
        exit;
    }

    db_close($dbid);

    $counter = sizeof($rs_members);

    if($counter > 0)
    {
        //Generate File Name
        $filename = strtoupper($group_name)."-".strtoupper($group_reference)."-".$counter.".csv";

        //Generate CSV Output
        for($csvi = 0; $csvi < $counter; $csvi++)
        {
            $csvoutput .= $rs_members[$csvi]."\t,".$rs_members_name[$csvi]."\t,".$rs_members_loc[$csvi]."\t,".$rs_members_ot1[$csvi]."\t,".$rs_members_ot2[$csvi]."\r\n";
        }
        //Export Results
        header("Expires: 0");
        header("Cache-control: private");
		header('Content-type: text/html; charset=utf-8'); 
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Description: File Transfer");
        header("Content-Type: application/vnd.ms-excel");
        header("Content-disposition: attachment; filename=$filename");
        echo $csvoutput;
    }
    else
    {
        //Redirect: Group is Empty
        Header("Location: ".$apath."modules/groups/web/index.php?msg=This group has no members inside.");
    }
}
else if($submit == "IMPORT")
{
    if ($_FILES["file"]["error"] > 0)
    {
        Header("Location: ".$apath."modules/groups/web/index.php?msg=".urlencode($_FILES["import_file"]["error"]));
    }
    else
    {
        $filename = $_FILES["import_file"]["tmp_name"];
        if(strtolower(trim($_FILES["import_file"]["type"])) != "application/vnd.ms-excel")
        {
            Header("Location: ".$apath."modules/groups/web/index.php?msg=Invalid file type, file must be MS Excell CSV file.");
        }
        else
        {
            $dbid = db_connect();

            if($rs = mysql_query("SELECT reference_code, name FROM tbl_alerts_group WHERE group_id = $group_id AND sys_id = $param_session_sys_id AND owner_id = $param_session_user_user_id", $dbid))
            {
                if($row = mysql_fetch_array($rs))
                {
                    $array_members = array();
                    $members_count = 0;
                    setlocale( LC_ALL, 'ar_SA.UTF-8' );
                    $handle = fopen($filename, "r");
                    while (($data = fgetcsv($handle)) !== false) {
                        if(is_numeric(trim($data[0])))
                        {
                            $array_members[$members_count][0] = preg_replace("/[^0-9]/", '',$data[0]);
                            $array_members[$members_count][1] = $data[1];
                            $array_members[$members_count][2] = $data[2];
                            $array_members[$members_count][3] = $data[3];
                            $array_members[$members_count][4] = $data[4];
                            $members_count++;
                        }
                    }
                    fclose($handle);

                    $added_counter = 0;
                    $not_added_counter = 0;
                    $not_added_numbers = "";

                    for($membersi = 0; $membersi < sizeof($array_members); $membersi++)
                    {
                        $member2add = trim($array_members[$membersi][0]);
                        $member2add_name = trim(string_wslashes($array_members[$membersi][1]));
                        $member2add_loc = trim(string_wslashes($array_members[$membersi][2]));
                        if (strtolower($array_members[$membersi][3]) == strtolower('Male'))
                            {
                                $member2add_ot1 = 0;
                            }
                        else  $member2add_ot1 = 1;

                        //$member2add_ot1 = trim(string_wslashes($array_members[$membersi][3]));
                        $member2add_ot2 = trim(string_wslashes($array_members[$membersi][4]));

                        if(mysql_query("INSERT INTO tbl_alerts_group_members VALUES($group_id, '$member2add', '$member2add_name','$member2add_loc','$member2add_ot1','$member2add_ot2')",$dbid))
                        {
                            $added_counter++;
                        }
                        else
                        {
                            $not_added_counter++;
                            $not_added_numbers .= ($not_added_counter==1?"":", ").$member2add;
                        }
                    }

                    $msg = "";
                    if($not_added_counter != 0)
                    {
                        $msg = $not_added_counter." mobile numbers not added successfully ($not_added_numbers), $added_counter mobile numbers added successfully.";
                    }
                    else
                    {
                        $msg = $added_counter." mobile numbers added successfully.";
                    }
                    $msg = urlencode($msg);

                    Header("Location: ".$apath."modules/groups/web/index.php?msg=".$msg);

                }
            }

            db_close($dbid);
        }
    }
}
?>