<?php
/**
 * 日历
 * @copyright (c) Emlog All Rights Reserved
 * @version emlog-3.4.0
 * $Id$
 */

require_once 'init.php';

//建立日志时间写入数组
$query = $DB->query("SELECT date FROM ".DB_PREFIX."blog WHERE hide='n' and type='blog'");
while ($date = $DB->fetch_array($query))
{
	$logdate[] = gmdate("Ymd",$date['date']);
}
//获取当前日期
$n_year  = gmdate("Y",$localdate);
$n_year2 = gmdate("Y",$localdate);
$n_month = gmdate("m",$localdate);
$n_day   = gmdate("d",$localdate);
$time    = gmdate("Ymd",$localdate);
$year_month = gmdate("Ym",$localdate);

if (isset($_GET['record']))
{
	$n_year = substr(intval($_GET['record']),0,4);
	$n_year2 = substr(intval($_GET['record']),0,4);
	$n_month = substr(intval($_GET['record']),4,2);
	$year_month = substr(intval($_GET['record']),0,6);
}

//年月跳转连接
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
$url = DYNAMIC_BLOGURL.'calendar.php?record=' . ($n_year - 1) . $n_month;//上一年份
$url2 = DYNAMIC_BLOGURL.'calendar.php?record=' . ($n_year + 1) . $n_month;//下一年份
$url3 = DYNAMIC_BLOGURL.'calendar.php?record=' . $year_down . $m;//上一月份
$url4 = DYNAMIC_BLOGURL.'calendar.php?record=' . $year_up . $mj;//下一月份

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
<td class=\"week\">一</td>
<td class=\"week\">二</td>
<td class=\"week\">三</td>
<td class=\"week\">四</td>
<td class=\"week\">五</td>
<td class=\"week\">六</td>
<td class=\"sun\">日</td>
</tr>";

//获取给定年月的第一天是星期几
$week = @gmdate("w",gmmktime(0,0,0,$n_month,1,$n_year));
//获取给定年月的天数
$lastday = @gmdate("t",gmmktime(0,0,0,$n_month,1,$n_year));
//获取给定年月的最后一天是星期几
$lastweek = @gmdate("w",gmmktime(0,0,0,$n_month,$lastday,$n_year));
if ( $week == 0)
{
	$week = 7;
}
$j = 1;
$w = 7;
$isend = false;
//外循环生成行
for ($i = 1;$i <= 6;$i++)
{
	if ($isend || ($i == 6 && $lastweek==0))
	{
		break;
	}
	$calendar .= '<tr>';
	//内循环生成列
	for($j ; $j <= $w; $j++)
	{
		if ($j < $week)
		{
			$calendar.= '<td>&nbsp;</td>';
		} elseif ( $j <= 7 ) {
			$r = $j - $week + 1;
			//如果该日有日志就显示url样式
			$n_time = $n_year . $n_month . '0' . $r;
			//有日志且为当天
			if (@in_array($n_time,$logdate) && $n_time == $time)
			{
				$calendar .= '<td class="day"><a href="'.BLOG_URL.'?record='.$n_time.'">'. $r .'</a></td>';
			} elseif (@in_array($n_time,$logdate)) {
				$calendar .= '<td class="day2"><a href="'.BLOG_URL.'?record='.$n_time.'">'. $r .'</a></td>';
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
				//如果该日有日志就显示url样式
				$t < 10 ? $n_time = $n_year . $n_month . '0' . $t : $n_time = $n_year . $n_month . $t;
				if (@in_array($n_time,$logdate) && $n_time == $time)
				{
					$calendar .= '<td class="day"><a href="'.BLOG_URL.'?record='.$n_time.'">'. $t .'</a></td>';
				} elseif(@in_array($n_time,$logdate)){
					$calendar .= '<td class="day2"><a href="'.BLOG_URL.'?record='.$n_time.'">'. $t .'</a></td>';
				} elseif($n_time == $time) {
					$calendar .= '<td class="day">'. $t .'</td>';
				} else {
					$calendar .= '<td>'.$t.'</td>';
				}
			}
		}
	}//内循环结束
	$calendar .= '</tr>';
	$w += 7;
}//外循环结束
$calendar .= '</table>';

echo $calendar;
