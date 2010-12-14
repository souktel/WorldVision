<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */
//new
function generateMsgId($api_id) {
    $chars = "abcdefghijkmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    srand((double)microtime()*1000000);
    $i = 0;
    $msgidchr = "";
    while ($i <= 5) {
        $num = rand() % 25;
        $tmp = substr($chars, $num, 1);
        $msgidchr = $msgidchr . $tmp;
        $i++;
    }
    return $api_id.date("YmdHis").$msgidchr;
}

function sendCurl($url, $url_qs) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $url_qs);
    $con_str = curl_exec($ch);
    curl_close($ch);
    return $con_str;
}

function isEnglish($message) {
    for($m_i = 0; $m_i < strlen($message); $m_i++) {
        $ascii = ord($message[$m_i]);
        if(!($ascii >= 0 && $ascii <= 127)) {
            return false;
        }
    }
    return true;
}

function logMessage($dbid, $sender, $recipient, $message, $language, $msgId) {
    $message = string_wslashes($message);
    mysql_query("INSERT INTO tbl_sent VALUES(id, '$sender', '$recipient', '$message', '$language', '$msgId',CURRENT_TIMESTAMP, '', NULL)", $dbid);
}

function sendBulkSMS($msgId, $recipients, $message, $dbid, $api_id, $api_key) {
    global $req_ps, $req_intl,$req_sender_id, $tw;

    if(!isset ($tw)) $tw = '';

    $shortcode = 'WVATFALUNA';
    if($req_ps != '') $shortcode = $req_ps;
    else $shortcode = $req_intl;

    if(is_array($recipients)) {
        $o_recipients = $recipients;
    }
    else {
        $o_recipients[] = $recipients;
    }

    $shortcode = $req_sender_id==""?$shortcode:$req_sender_id;
    $message = urlencode($message);

    $to = '';
    for($to_i = 0; $to_i < sizeof($o_recipients); $to_i++) {
        $to .= $o_recipients[$to_i].',';
    }
    $to = urlencode(trim($to, ','));
    
    $result = sendCurl('http://api.mysouktel.com/sms/send.php', "api_id=$api_id&key=$api_key&text=$message&msgid=$msgId&sc=$shortcode&to=$to".$tw);
    if($result == "EZERO") {
        return false; //There is no ERROR
    } else {
        return $result;
    }
    
}

?>
