<?php
/* emlog 2.5.0 Emlog.Net */
require_once('./common.php');
//建立日志时间写入数组
$query = $DB->query("SELECT date FROM ".$db_prefix."blog WHERE hide='n' ");
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
//end

if(isset($_GET['date']))
{
	$n_year=substr(intval($_GET['date']),0,4);
	$n_year2=substr(intval($_GET['date']),0,4);
	$n_month=substr(intval($_GET['date']),-2);
	$year_month=intval($_GET['date']);
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
$url = "./calendar.php?smp=$localdate&date=".($n_year-1).$n_month;//上一年份
$url2 = "./calendar.php?smp=$localdate&date=".($n_year+1).$n_month;//下一年份
$url3 = 	"./calendar.php?smp=$localdate&date=".$year_down.$m;//上一月份
$url4 = "./calendar.php?smp=$localdate&date=".$year_up.$mj;//下一月份

$calendar =
"<table class=\"calendartop\">
<tr>
<td>
<a href=\"javascript:void(0);\" onclick=\"sendinfo('$url');\">&nbsp;&laquo;&nbsp;</a>$n_year2<a href=\"javascript:void(0);\" onclick=\"sendinfo('$url2');\">&nbsp;&raquo;&nbsp;</a>
</td>
<td>
<a href=\"javascript:void(0);\" onclick=\"sendinfo('$url3');\">&nbsp;&laquo;&nbsp;</a>$n_month<a href=\"javascript:void(0);\" onclick=\"sendinfo('$url4');\">&nbsp;&raquo;&nbsp;</a>
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
//获取给定年月的最后一天是星期几
$lastday=@date("t",mktime(0,0,0,$n_month,1,$n_year));

if($week==0)
$week=7;
$j=1;
$w=7;
//外循环生成行
for($i=1;$i<=6;$i++){
	$calendar.="<tr>\n";
	//内循环生成列
	for($j;$j<=$w;$j++){
		if($j<$week){
			$calendar.="<td>&nbsp;</td>\n";
		}
		elseif($j<=7){
			$r=$j-$week+1;
			//如果该日有日至就显示url样式
			$n_time=$n_year.$n_month."0".$r;
		if(@in_array($n_time,$logdate)&&$n_time==$time)
			$calendar.="<td class=\"day\"><a href=\"index.php?record=$n_time\">".$r."</a></td>\n";
				elseif(@in_array($n_time,$logdate))
					$calendar.="<td class=\"day2\"><a href=\"index.php?date=$year_month&record=$n_time\">".$r."</a></td>\n";
				elseif($n_time==$time)
					$calendar.="<td class=\"day\">".$r."</td>\n";
				else
					$calendar.="<td>".$r."</td>\n";
		}
		else{
			$t=$j-($week-1);
			if($t>$lastday)
				$calendar.="<td>&nbsp;</td>\n";
				else{
				//如果该日有日至就显示url样式
				$t<10?
				$n_time=$n_year.$n_month."0".$t:
				$n_time=$n_year.$n_month.$t;
				if(@in_array($n_time,$logdate)&&$n_time==$time)
					$calendar.="<td class=\"day\"><a href=\"index.php?record=$n_time\">".$t."</a></td>\n";
				elseif(@in_array($n_time,$logdate))
					$calendar.="<td class=\"day2\"><a href=\"index.php?date=$year_month&record=$n_time\">".$t."</a></td>\n";
				elseif($n_time==$time)
					$calendar.="<td class=\"day\">".$t."</td>\n";
				else
					$calendar.="<td>".$t."</td>\n";
				}
			}
		}//内循环结束
	$calendar.="</tr>\n";
	$w+=7;
}//外循环结束
$calendar.="</table>";
echo $calendar;
?>