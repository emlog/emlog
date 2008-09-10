<?php
/**
 * 日历生成
 * @copyright (c) 2008, Emlog All Rights Reserved
 * @version emlog-2.7.0
 * $Id$
 */

require_once('./common.php');

//建立日志时间写入数组
$query = $DB->query("SELECT date FROM {$db_prefix}blog WHERE hide='n' ");
while($date = $DB->fetch_array($query))
{
	$logdate[] = date("Ymd",$date['date']);
}
//获取当前日期
$n_year=date("Y",$localdate);
$n_year2=date("Y",$localdate);
$n_month=date("m",$localdate);
$n_day=date("d",$localdate);
$time=date("Ymd",$localdate);
$year_month=date("Ym",$localdate);

if(isset($_GET['record']))
{
	$n_year=substr(intval($_GET['record']),0,4);
	$n_year2=substr(intval($_GET['record']),0,4);
	$n_month=substr(intval($_GET['record']),4,2);
	$year_month=substr(intval($_GET['record']),0,6);
}	
//年月跳转连接
$m=$n_month-1;
$mj=$n_month+1;
$m = ($m<10) ? "0".$m : $m;
$mj = ($m<10) ? "0".$mj : $mj;

$year_up = $n_year;
$year_down = $n_year;

if($mj>12)
{
	$mj='01';
	$year_up=$n_year+1;
}
if($m<1)
{
	$m='12';
	$year_down = $n_year-1;
}
$url = "./calendar.php?record=".($n_year-1).$n_month;//上一年份
$url2 = "./calendar.php?record=".($n_year+1).$n_month;//下一年份
$url3 = "./calendar.php?record=".$year_down.$m;//上一月份
$url4 = "./calendar.php?record=".$year_up.$mj;//下一月份

$calendar =
"<table class=\"calendartop\">
<tr>
<td>
<a href=\"javascript:void(0);\" onclick=\"sendinfo('$url','calendar');\"> &laquo; </a>$n_year2<a href=\"javascript:void(0);\" onclick=\"sendinfo('$url2','calendar');\"> &raquo; </a>
</td>
<td>
<a href=\"javascript:void(0);\" onclick=\"sendinfo('$url3','calendar');\"> &laquo; </a>$n_month<a href=\"javascript:void(0);\" onclick=\"sendinfo('$url4','calendar');\"> &raquo; </a>
</td>
</tr>
</table>
<table class=\"calendar\">
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
$week=@date("w",mktime(0,0,0,$n_month,1,$n_year));
//获取给定年月的天数
$lastday=@date("t",mktime(0,0,0,$n_month,1,$n_year));
//获取给定年月的最后一天是星期几
$lastweek=@date("w",mktime(0,0,0,$n_month,$lastday,$n_year));
if($week==0)
{
	$week=7;
}
$j=1;
$w=7;
$isend = false;
//外循环生成行
for($i=1;$i<=6;$i++)
{
	if($isend || ($i == 6 && $lastweek==0))
	{
		break;
	}
	$calendar.="<tr>\n";
	//内循环生成列
	for($j;$j<=$w;$j++)
	{
		if($j<$week)
		{
			$calendar.="<td>&nbsp;</td>\n";
		}elseif($j<=7){
			$r=$j-$week+1;
			//如果该日有日志就显示url样式
			$n_time=$n_year.$n_month."0".$r;
			//有日志且为当天
			if(@in_array($n_time,$logdate)&&$n_time==$time)
			{
				$calendar.="<td class=\"day\"><a href=\"index.php?record=$n_time\">".$r."</a></td>\n";
			}elseif(@in_array($n_time,$logdate)){
				$calendar.="<td class=\"day2\"><a href=\"index.php?record=$n_time\">".$r."</a></td>\n";
			}elseif($n_time==$time){
				$calendar.="<td class=\"day\">".$r."</td>\n";
			}else{
				$calendar.="<td>".$r."</td>\n";
			}
		}else{
			$t=$j-($week-1);
			if($t>$lastday)
			{
				$isend = true;
				$calendar.="<td>&nbsp;</td>\n";
			}else{
				//如果该日有日志就显示url样式
				$t<10 ? $n_time=$n_year.$n_month."0".$t : $n_time=$n_year.$n_month.$t;
				if(@in_array($n_time,$logdate)&&$n_time==$time)
				{
					$calendar.="<td class=\"day\"><a href=\"index.php?record=$n_time\">".$t."</a></td>\n";
				}elseif(@in_array($n_time,$logdate)){
					$calendar.="<td class=\"day2\"><a href=\"index.php?record=$n_time\">".$t."</a></td>\n";
				}elseif($n_time==$time){
					$calendar.="<td class=\"day\">".$t."</td>\n";
				}else{
					$calendar.="<td>".$t."</td>\n";
				}
			}
		}
	}//内循环结束
	$calendar.="</tr>\n";
	$w+=7;
}//外循环结束
$calendar.="</table>";

echo $calendar;

?>