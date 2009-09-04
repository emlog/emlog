<?php
/**
 * Calendar
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.3.0
 * $Id$
 */

require_once('init.php');

//Array of Blog time
$query = $DB->query("SELECT date FROM ".DB_PREFIX."blog WHERE hide='n' and type='blog'");
while ($date = $DB->fetch_array($query))
{
	$logdate[] = date("Ymd",$date['date']);
}

//Get the current date
$n_year  = date("Y",$localdate);
$n_year2 = date("Y",$localdate);
$n_month = date("m",$localdate);
$n_day   = date("d",$localdate);
$time    = date("Ymd",$localdate);
$year_month = date("Ym",$localdate);

if (isset($_GET['record']))
{
	$n_year = substr(intval($_GET['record']),0,4);
	$n_year2 = substr(intval($_GET['record']),0,4);
	$n_month = substr(intval($_GET['record']),4,2);
	$year_month = substr(intval($_GET['record']),0,6);
}

//Date link to jump
$m  = $n_month - 1;
$mj = $n_month + 1;

$m  = ($m < 10) ? '0' . $m : $m;
$mj = ($mj < 10) ? '0' . $mj : $mj;

$year_up = $n_year;
$year_down = $n_year;

if ($mj > 12)
{
	$mj = '01';
	$year_up = $n_year + 1;
}
if ( $m < 1)
{
	$m = '12';
	$year_down = $n_year - 1;
}
$url = './calendar.php?record=' . ($n_year - 1) . $n_month;//Pevious Year
$url2 = './calendar.php?record=' . ($n_year + 1) . $n_month;//Next Year
$url3 = './calendar.php?record=' . $year_down . $m;//Previous Month
$url4 = './calendar.php?record=' . $year_up . $mj;//Next Month

$calendar =
"<table class=\"calendartop\" cellspacing=\"0\">
<tr>
<td>
<a href=\"javascript:void(0);\" onclick=\"sendinfo('$url','calendar');\"> &laquo; </a>$n_year2<a href=\"javascript:void(0);\" onclick=\"sendinfo('$url2','calendar');\"> &raquo; </a>
</td>
<td>
<a href=\"javascript:void(0);\" onclick=\"sendinfo('$url3','calendar');\"> &laquo; </a>$n_month<a href=\"javascript:void(0);\" onclick=\"sendinfo('$url4','calendar');\"> &raquo; </a>
</td>
</tr>
</table>

<table class=\"calendar\" cellspacing=\"0\">
<tr>
    <td class=\"week\">{$lang['monday_short']}</td>
    <td class=\"week\">{$lang['tuesday_short']}</td>
    <td class=\"week\">{$lang['wednesday_short']}</td>
    <td class=\"week\">{$lang['thursday_short']}</td>
    <td class=\"week\">{$lang['friday_short']}</td>
    <td class=\"week\">{$lang['saturday_short']}</td>
    <td class=\"sun\">{$lang['sunday_short']}</td>
</tr>";

//Day of the week for the first day of the month
$week = @date("w",mktime(0,0,0,$n_month,1,$n_year));

//Last day of the month
$lastday = @date("t",mktime(0,0,0,$n_month,1,$n_year));

//Day of the week for the last day of the month
$lastweek = @date("w",mktime(0,0,0,$n_month,$lastday,$n_year));
if ( $week == 0)
{
	$week = 7;
}
$j = 1;
$w = 7;
$isend = false;

//Outer loop
for ($i = 1;$i <= 6;$i++)
{
	if ($isend || ($i == 6 && $lastweek==0))
	{
		break;
	}
	$calendar .= '<tr>';

	//Inner loop
	for($j ; $j <= $w; $j++)
	{
		if ($j < $week)
		{
			$calendar.= '<td>&nbsp;</td>';
		} elseif ( $j <= 7 ) {
			$r = $j - $week + 1;

			//If there are blogs on that day, display the url style
			$n_time = $n_year . $n_month . '0' . $r;

			//There is a blog and it is the same day
			if (@in_array($n_time,$logdate) && $n_time == $time)
			{
				$calendar .= "<td class=\"day\"><a href=\"./?record=$n_time\">". $r .'</a></td>';
			} elseif (@in_array($n_time,$logdate)) {
				$calendar .= "<td class=\"day2\"><a href=\"./?record=$n_time\">". $r .'</a></td>';
			} elseif ($n_time == $time){
				$calendar .= '<td class="day">'. $r .'</td>';
			} else {
				$calendar.= '<td>'. $r .'</td>';
			}
		}else{
			$t = $j - ($week - 1);
			if ($t > $lastday)
			{
				$isend = true;
				$calendar .= '<td>&nbsp;</td>';
			} else {
				//If there are blogs on that day, display the url style
				$t < 10 ? $n_time = $n_year . $n_month . '0' . $t : $n_time = $n_year . $n_month . $t;
				if (@in_array($n_time,$logdate) && $n_time == $time)
				{
					$calendar .= "<td class=\"day\"><a href=\"./?record=$n_time\">". $t .'</a></td>';
				} elseif(@in_array($n_time,$logdate)){
					$calendar .= "<td class=\"day2\"><a href=\"./?record=$n_time\">". $t .'</a></td>';
				} elseif($n_time == $time) {
					$calendar .= '<td class="day">'. $t .'</td>';
				} else {
					$calendar .= '<td>'.$t.'</td>';
				}
			}
		}
	}//End of inner loop

	$calendar .= '</tr>';
	$w += 7;
}//End of outer loop

$calendar .= '</table>';

echo $calendar;
