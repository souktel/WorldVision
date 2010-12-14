<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

//Random Digits
function gen_random($no_digits)
{
    $digits = "";
    srand(time());
    for ($i=0; $i < $no_digits; $i++)
    {
        $random = (rand()%3);
        $digits .= $random;
    }
    return $digits;
}
?>
