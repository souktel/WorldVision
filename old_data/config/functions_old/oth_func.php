<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

function strlimit($unlimited_str, $maximum_len=30)
{
    if(strlen($unlimited_str)> $maximum_len)
    {
        $unlimited_str = substr($unlimited_str, 0, $maximum_len)."...";
    }
    else
    {
        $spacing = "";
        for($ci=0; $ci < ($maximum_len-strlen($unlimited_str)); $ci++)
        {
            $spacing .=" ";
        }
        $unlimited_str .= $spacing;
    }
    return $unlimited_str;
}
?>
