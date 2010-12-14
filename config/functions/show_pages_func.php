<?php
/**
 * Souktel v2.0
 * Developed By Tamer A. Qasim
 * +972(0)599358296
 * q.tamer@gmail.com
 */

$maxPage = ceil($numrows/$rowsPerPage);

$self = $_SERVER['PHP_SELF']."?".$_SERVER["QUERY_STRING"];
$nav  = '';

for($page = 1; $page <= $maxPage; $page++)
{
    if ($page == $pageNum)
    {
        $nav .= " $page ";
    }
    else
    {
        $nav .= " <a href=\"$self&page=$page\">$page</a> ";
    }
}

if ($pageNum > 1)
{
    $page  = $pageNum - 1;
    $prev  = " [<a href=\"$self&page=$page\">Previous</a>] ";

    $first = " [<a href=\"$self&page=1\">First</a>] ";
}
else
{
    $prev  = '&nbsp;[Previous]&nbsp;';
    $first = '[First]&nbsp;';
}

if ($pageNum < $maxPage)
{
    $page = $pageNum + 1;
    $next = " [<a href=\"$self&page=$page\">Next</a>] ";

    $last = " [<a href=\"$self&page=$maxPage\">Last</a>] ";
}
else
{
    $next = '&nbsp;[Next]&nbsp;';
    $last = '[Last]';
}
?>
<p style="text-align: center;">
    <font face="Trebuchet MS" size="2">Total Number of Results ( <?php echo $numrows." )<br><br>";?></font>
</p>
<p style="text-align: center;">
    <font face="Trebuchet MS" size="2"><?php echo $first.$prev ." $pageNum / $maxPage ".$next.$last."<br><br>";?></font>
</p>