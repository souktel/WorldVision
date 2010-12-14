<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$group_id = "";
$group_send = false;

if($group_rs = mysql_query("SELECT group_id, owner_id FROM tbl_alerts_group WHERE sys_id = $sms_sys_id AND upper(reference_code) = upper('$group_reference') AND status >= 0", $sms_dbid))
{
    if($group_row = mysql_fetch_array($group_rs))
    {
        $group_id = $group_row[0];
        if($group_row[1] == $sms_user_user_id)
        {
            //You are the owner
            $group_send = true;
        }
        else
        {
            if($sender_rs = mysql_query("SELECT 1 FROM tbl_alerts_group_senders gs, tbl_sys_user u WHERE gs.group_id = $group_id AND u.user_id = gs.sender_id AND lower(u.mobile) = lower('$sms_user_mobile') ", $sms_dbid))
            {
                if($sender_row = mysql_fetch_array($sender_rs))
                {
                    //You are the sender
                    $group_send = true;
                }
            }
            else
            {
                reply("A32", null);
            }
        }

        if($group_send == true)
        {
            if($member_rs = mysql_query("SELECT mobile FROM tbl_alerts_group_members WHERE group_id = $group_id", $sms_dbid))
            {
                $receivers = array();
                while($member_row = mysql_fetch_array($member_rs))
                {
                    $receivers[] = $member_row[0];
                }
                $nofr = sizeof($receivers);
                if($nofr>=1)
                {
                    if($rs_senderid = mysql_query("SELECT sender_id FROM tbl_sys_senderid WHERE sys_id = $sms_sys_id", $sms_dbid))
                    {
                        if($req_sender_id_arr = mysql_fetch_array($rs_senderid))
                        {
                            $req_sender_id = $req_sender_id_arr[0];
                        }
                    }

                    $send_success = send_sms($req_sender_id, $sms_sys_id, $receivers, $msg2send, 2,$group_reference);
                    if($send_success) reply("A33", array("@#nofr"=>$nofr, "@#group_reference"=>strtoupper($group_reference)));
                    else reply("Z03", null);
                }
                else
                {
                    reply("A34", null);
                }
            }
        }
        else
        {
            reply("A35", null);
        }

    }
    else
    {
        reply("A36", null);
    }
}
else
{
    reply("A37", null);
}
?>
