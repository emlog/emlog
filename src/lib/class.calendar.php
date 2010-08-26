<?php
/**
 * Calendar
 * @copyright (c) Emlog All Rights Reserved
 * $Id: class.calendar.php 1649 2010-04-15 14:02:30Z emloog@gmail.com $
 */

class Calendar {
    static function generate() {
        global $DB, $timezone, $utctimestamp;
        $timestamp = $utctimestamp + $timezone * 3600;
        
        //Write the post time to the array
        $query = $DB->query("SELECT date FROM ".DB_PREFIX."blog WHERE hide='n' and type='blog'");
        while ($date = $DB->fetch_array($query)){
        	$logdate[] = gmdate("Ymd", $date['date'] + $timezone * 3600);
        }
        //Get the current date
        $n_year  = gmdate("Y", $timestamp);
        $n_year2 = gmdate("Y", $timestamp);
        $n_month = gmdate("m", $timestamp);
        $n_day   = gmdate("d", $timestamp);
        $time    = gmdate("Ymd", $timestamp);
        $year_month = gmdate("Ym", $timestamp);
        
        if (isset($_GET['record'])){
        	$n_year = substr(intval($_GET['record']),0,4);
        	$n_year2 = substr(intval($_GET['record']),0,4);
        	$n_month = substr(intval($_GET['record']),4,2);
        	$year_month = substr(intval($_GET['record']),0,6);
        }
        //Year Month Jump Link
        $m  = $n_month - 1;
        $mj = $n_month + 1;
        
        $m  = ($m < 10) ? '0' . $m : $m;
        $mj = ($mj < 10) ? '0' . $mj : $mj;
        
        $year_up = $n_year;
        $year_down = $n_year;
        
        if ($mj > 12){
        	$mj = '01';
        	$year_up = $n_year + 1;
        }
        if ( $m < 1){
        	$m = '12';
        	$year_down = $n_year - 1;
        }
        $url = DYNAMIC_BLOGURL.'?action=cal&record=' . ($n_year - 1) . $n_month;//Last year
        $url2 = DYNAMIC_BLOGURL.'?action=cal&record=' . ($n_year + 1) . $n_month;//Next year
        $url3 = DYNAMIC_BLOGURL.'?action=cal&record=' . $year_down . $m;//Last month
        $url4 = DYNAMIC_BLOGURL.'?action=cal&record=' . $year_up . $mj;//Next month
        
        $calendar ="<table class=\"calendartop\" cellspacing=\"0\"><tr>
        <td><a href=\"javascript:void(0);\" onclick=\"sendinfo('$url','calendar');\"> &laquo; </a>$n_year2<a href=\"javascript:void(0);\" onclick=\"sendinfo('$url2','calendar');\"> &raquo; </a></td>
        <td><a href=\"javascript:void(0);\" onclick=\"sendinfo('$url3','calendar');\"> &laquo; </a>$n_month<a href=\"javascript:void(0);\" onclick=\"sendinfo('$url4','calendar');\"> &raquo; </a></td>
        </tr></table>
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
        
        //Get the first day of the given year and month is the day of the week
        $week = @gmdate("w",gmmktime(0,0,0,$n_month,1,$n_year));
        //Get the number of days in a given year and month
        $lastday = @gmdate("t",gmmktime(0,0,0,$n_month,1,$n_year));
        //Get the last day of the given year and month is the day of the week
        $lastweek = @gmdate("w",gmmktime(0,0,0,$n_month,$lastday,$n_year));
        if ( $week == 0){
        	$week = 7;
        }
        $j = 1;
        $w = 7;
        $isend = false;
        //Outer loop
        for ($i = 1;$i <= 6;$i++){
        	if ($isend || ($i == 6 && $lastweek==0)){
        		break;
        	}
        	$calendar .= '<tr>';
        	//Inner loop
        	for($j ; $j <= $w; $j++){
        		if ($j < $week){
        			$calendar.= '<td>&nbsp;</td>';
        		} elseif ( $j <= 7 ) {
        			$r = $j - $week + 1;
        			//If there are blog posts on that day, display the url style
        			$n_time = $n_year . $n_month . '0' . $r;
        			//There is a log and it is the same day
        			if (@in_array($n_time,$logdate) && $n_time == $time){
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
        			if ($t > $lastday){
        				$isend = true;
        				$calendar .= '<td>&nbsp;</td>';
        			} else {
        				//If there are logs on that day, display the url style
        				$t < 10 ? $n_time = $n_year . $n_month . '0' . $t : $n_time = $n_year . $n_month . $t;
        				if (@in_array($n_time,$logdate) && $n_time == $time){
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
        	}//End of inner loop
        	$calendar .= '</tr>';
        	$w += 7;
        }//End of outer loop
        $calendar .= '</table>';
        echo $calendar;
    }
}