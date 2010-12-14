<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

/*
* Function
* name: check_password
* one attribute($p_pass: string)
* return boolean
*/
function check_password($p_pass)
{
    //to change the minimum length change must be occured in the if statement and in the reqular expression it self
    /*$valid = false;
    if(strlen($p_pass) >= 8 && strlen($p_pass) <=16)
    {
        if (preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $p_pass)) {
            $valid = true;
        } else {
            $valid = false;
        }
    } else {
        $valid = false;
    }
    return $valid;*/
    return true;
}

/*
 * Function
 * name is_email
 * attribute $email
 * return boolean
 */
function is_email($email)
{
    return true;
    if (preg_match("", $email)) {
        return true;
    } else {
        return false;
    }
}

/*
 * Function
 * name is_alphanum
 * attribute $string
 * return boolean
 */
function is_alphanum($string)
{
    return true;
    if (preg_match("", $string)) {
        return true;
    } else {
        return false;
    }
}

/*
 * Function
 * name check_len
 * attrivute $string, $minimum length, $maximum length
 * return boolean
 */
function check_len($string, $min, $max)
{
    if(strlen($string) >= $min && strlen($string) <= $max) return true;
    else return false;
}
?>
