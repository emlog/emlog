<?php
/**
 * Calendar
 * @package EMLOG (www.emlog.net)
 */

class Calendar {

	/**
	 * Calendar call address
	 */
	static function url() {
		$calendarUrl = isset($GLOBALS['record']) ? DYNAMIC_BLOGURL . '?action=cal&record=' . (int)$GLOBALS['record'] : DYNAMIC_BLOGURL . '?action=cal';
		return $calendarUrl;
	}

	/**
	 * Generate calendar
	 */
	static function generate() {
		$DB = Database::getInstance();

		//Array of post create time
		$logdate = [];
		$query = $DB->query("SELECT date FROM " . DB_PREFIX . "blog WHERE hide='n' and checked='y' and type='blog'");
		while ($date = $DB->fetch_array($query)) {
			$logdate[] = date("Ymd", $date['date']);
		}
		//Get the current date
		$n_year = date("Y");
		$n_year2 = date("Y");
		$n_month = date("m");
		$n_day = date("d");
		$time = date("Ymd");
		$year_month = date("Ym");

		if (isset($_GET['record'])) {
			$n_year = substr((int)$_GET['record'], 0, 4);
			$n_year2 = substr((int)$_GET['record'], 0, 4);
			$n_month = substr((int)$_GET['record'], 4, 2);
			$year_month = substr((int)$_GET['record'], 0, 6);
		}

		//Month to jump links
		$m = $n_month - 1;
		$mj = $n_month + 1;

		$m = ($m < 10) ? '0' . $m : $m;
		$mj = ($mj < 10) ? '0' . $mj : $mj;

		$year_up = $n_year;
		$year_down = $n_year;

		if ($mj > 12) {
			$mj = '01';
			$year_up = $n_year + 1;
		}
		if ($m < 1) {
			$m = '12';
			$year_down = $n_year - 1;
		}
/*vot*/	$url = DYNAMIC_BLOGURL . '?action=cal&record=' . ($n_year - 1) . $n_month; //Previous Year
/*vot*/	$url2 = DYNAMIC_BLOGURL . '?action=cal&record=' . ($n_year + 1) . $n_month;//Next Year
/*vot*/	$url3 = DYNAMIC_BLOGURL . '?action=cal&record=' . $year_down . $m;         //Previous Month
/*vot*/	$url4 = DYNAMIC_BLOGURL . '?action=cal&record=' . $year_up . $mj;          //Next month

		$calendar = "<table class=\"calendartop\" cellspacing=\"0\"><tr>
		<td><a href=\"javascript:void(0);\" onclick=\"sendinfo('$url','calendar');\"> &laquo; </a>$n_year2<a href=\"javascript:void(0);\" onclick=\"sendinfo('$url2','calendar');\"> &raquo; </a></td>
		<td><a href=\"javascript:void(0);\" onclick=\"sendinfo('$url3','calendar');\"> &laquo; </a>$n_month<a href=\"javascript:void(0);\" onclick=\"sendinfo('$url4','calendar');\"> &raquo; </a></td>
		</tr></table>
		<table class=\"calendar\" cellspacing=\"0\">
<!--vot-->	<tr><td class=\"week\">".lang('weekday1')."</td><td class=\"week\">".lang('weekday2')."</td><td class=\"week\">".lang('weekday3')."</td><td class=\"week\">".lang('weekday4')."</td><td class=\"week\">".lang('weekday5')."</td><td class=\"week\">".lang('weekday6')."</td><td class=\"sun\">".lang('weekday7')."</td></tr>";

		//Get a given date is the first day of the week
		$week = @gmdate("w", gmmktime(0, 0, 0, $n_month, 1, $n_year));
		//Gets the number of days in a given year and month
		$lastday = @gmdate("t", gmmktime(0, 0, 0, $n_month, 1, $n_year));
		//Get a given date is the last day of the week
		$lastweek = @gmdate("w", gmmktime(0, 0, 0, $n_month, $lastday, $n_year));
		if ($week == 0) {
			$week = 7;
		}
		$j = 1;
		$w = 7;
		$isend = false;
		//Outer loop generates rows
		for ($i = 1; $i <= 6; $i++) {
			if ($isend || ($i == 6 && $lastweek == 0)) {
				break;
			}
			$calendar .= '<tr>';
			//Inner loop generates columns
			for ($j; $j <= $w; $j++) {
				if ($j < $week) {
					$calendar .= '<td>&nbsp;</td>';
				} elseif ($j <= 7) {
					$r = $j - $week + 1;
					//Format the date for url
					$n_time = $n_year . $n_month . '0' . $r;
					//If there is an article for that day
					if (in_array($n_time, $logdate) && $n_time == $time) {
						$calendar .= '<td class="day"><a href="' . Url::record($n_time) . '">' . $r . '</a></td>';
					} elseif (in_array($n_time, $logdate)) {
						$calendar .= '<td class="day2"><a href="' . Url::record($n_time) . '">' . $r . '</a></td>';
					} elseif ($n_time == $time) {
						$calendar .= '<td class="day">' . $r . '</td>';
					} else {
						$calendar .= '<td>' . $r . '</td>';
					}
				} else {
					$t = $j - ($week - 1);
					if ($t > $lastday) {
						$isend = true;
						$calendar .= '<td>&nbsp;</td>';
					} else {
						//Format the date for url
						$t < 10 ? $n_time = $n_year . $n_month . '0' . $t : $n_time = $n_year . $n_month . $t;
						if (in_array($n_time, $logdate) && $n_time == $time) {
							$calendar .= '<td class="day"><a href="' . Url::record($n_time) . '">' . $t . '</a></td>';
						} elseif (in_array($n_time, $logdate)) {
							$calendar .= '<td class="day2"><a href="' . Url::record($n_time) . '">' . $t . '</a></td>';
						} elseif ($n_time == $time) {
							$calendar .= '<td class="day">' . $t . '</td>';
						} else {
							$calendar .= '<td>' . $t . '</td>';
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