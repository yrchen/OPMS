<?
setlocale(LC_TIME,"ch");
//if($year=="") $year = date(Y,time());
//if($month=="") $month = date("m",time());
if(!isset($year)) $year = date("Y",time());
if(!isset($month)) $month = date("m",time());

$month_text = date(F,mktime(0,0,0,$month,1,$year));
$selected = strftime("%B",mktime(0,0,0,$month,1,$year));

echo "year,month=$year,$month\n";
echo "<center><form action=ex2.php method=post><select name=month>\n";
echo "<option selected value=$month>$selected</option>\n";
?>
<option value=1>一月</option>
<option value=2>二月</option>
<option value=3>三月</option>
<option value=4>四月</option>
<option value=5>五月</option>
<option value=6>六月</option>
<option value=7>七月</option>
<option value=8>八月</option>
<option value=9>九月</option>
<option value=10>十月</option>
<option value=11>十一月</option>
<option value=12>十二月</option>
</select>

<?
echo "<select name=year>";
echo "<option selected value=$year>$year</option>\n";
?>
    <option value=2000>2000</option>
    <option value=2001>2001</option>
    <option value=2002>2002</option>
    <option value=2003>2003</option>
    <option value=2004>2004</option>
    <option value=2005>2005</option>
    </select>
<?
echo "<input type=submit value=確定></form>\n";

echo "<table><tr><table border=1 bgcolor=#FFFFFF><tr>";
echo "<td colspan=7 align=center>";
echo "<h2>$year 年 $selected</h2>
    </td></tr><tr>
    <td bgcolor=darkblue><font color=white><b>週日</b></font></td>
    <td bgcolor=darkblue><font color=white><b>週一</b></font></td>
    <td bgcolor=darkblue><font color=white><b>週二</b></font></td>
    <td bgcolor=darkblue><font color=white><b>週三</b></font></td>
    <td bgcolor=darkblue><font color=white><b>週四</b></font></td>
    <td bgcolor=darkblue><font color=white><b>週五</b></font></td>
    <td bgcolor=darkblue><font color=white><b>週六</b></font></td>
    </tr>\n";

$nextmonth = $month +1;
$lastday = mktime(0,0,0,$nextmonth,0,$year);
$lastday = date(d,$lastday);

$firstday = mktime(0,0,0,$month,1,$year);
$day_of_week = date("l",$firstday);
echo "<tr>\n";

switch( $day_of_week ) {
    case 'Monday':
        echo str_repeat("<td></td>",1);
        break;
    case 'Tuesday':
        echo str_repeat("<td></td>",2);
        break;
    case 'Wednesday':
        echo str_repeat("<td></td>",3);
        break;
    case 'Thursday':
        echo str_repeat("<td></td>",4);
        break;
    case 'Friday':
        echo str_repeat("<td></td>",5);
        break;
    case 'Saturday':
        echo str_repeat("<td></td>",6);
        break;
}

$counter=1;
while( $counter <= $lastday ) {
    $day = mktime(0,0,0,$month,$counter,$year);
    $day_of_week = date("l",$day);
    if( $day_of_week == "Sunday" ) echo "<tr>\n";
    echo "<td>$counter</td>\n";
    if( $day_of_week == "Saturday" ) echo "</tr>\n";
    $counter++;
}
echo "</table></td><td></td></tr></table>";
?>