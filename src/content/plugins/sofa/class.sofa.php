<?php
/*
Plugin Name: 沙发热榜
Version: 1.0
Plugin URL:
Description: 比比看谁抢的沙发多哦～
Author: 奇遇
Author Email: qiyuuu@gmail.com
Author URL: http://www.qiyuuu.com
*/
!defined('EMLOG_ROOT') && exit('access deined!');
class sofa extends Cache {
	private $db;
	private static $instance = null;
	private function __construct() {
		$this->db = MySql::getInstance();
	}
	public static function getInstance() {
		if (self::$instance == null) {
			self::$instance = new sofa();
		}
		return self::$instance;
	}
	function update(){
		$sql = "SELECT title,url,poster,gid,date,mail,comment FROM (SELECT a.url,a.poster,a.gid,a.mail,a.hide,a.date,a.comment,b.title FROM ".DB_PREFIX."comment AS a, ".DB_PREFIX."blog AS b WHERE a.gid=b.gid AND a.hide='n' ORDER BY a.cid ASC) AS tmp GROUP BY gid";
		$query = $this->db->query($sql);
		$sofalist = array();
		$timezone = Option::get('timezone');
		$localtime = time() + $timezone * 3600;
		$nonce_year = gmdate('Y', $localtime);
		$nonce_month = gmdate('m', $localtime);
		while($show_sofa = $this->db->fetch_array($query)) {
			$show_sofa['date'] += $timezone * 3600;
			$year = gmdate('Y', $show_sofa['date']);
			$month = gmdate('m', $show_sofa['date']);
			if(!isset($sofalist[$year])) {
				$sofalist[$year] = array();
			}
			if(!isset($sofalist[$year][$month]) && $year == $nonce_year) {
				$sofalist[$year][$month] = array();
			}
			$hash = substr(md5($show_sofa['poster']),0,6);
			if($year == $nonce_year) {
				if(!isset($sofalist[$year][$month][$hash])) {
					$sofalist[$year][$month][$hash] = array(
								'url' => htmlspecialchars($show_sofa['url']),
								'num' => 0,
								'poster' => htmlspecialchars($show_sofa['poster']),
								'new' => htmlClean($show_sofa['comment']),
								'gid' => $show_sofa['gid'],
								'title'=> htmlspecialchars($show_sofa['title']),
								'date' => 0,
								'mail' => ''
									);
				}
				$sofalist[$year][$month][$hash]['num']++;
				if($sofalist[$year][$month][$hash]['date'] < $show_sofa['date']) {
					$sofalist[$year][$month][$hash]['new'] = htmlClean($show_sofa['comment']);
					$sofalist[$year][$month][$hash]['mail'] = $show_sofa['mail'];
					if($show_sofa['url']) {
						$sofalist[$year][$month][$hash]['url'] = $show_sofa['url'];
					}
					$sofalist[$year][$month][$hash]['title'] = $show_sofa['title'];
					$sofalist[$year][$month][$hash]['gid'] = $show_sofa['gid'];
				}
			} else {
				if(!isset($sofalist[$year][$hash])) {
					$sofalist[$year][$hash] = array(
								'url' => htmlspecialchars($show_sofa['url']),
								'num' => 0,
								'poster' => htmlspecialchars($show_sofa['poster']),
								'new' => htmlClean($show_sofa['comment']),
								'gid' => $show_sofa['gid'],
								'title'=> htmlspecialchars($show_sofa['title']),
								'date' => 0,
								'mail' => ''
									);
				}
				$sofalist[$year][$hash]['num']++;
				if($sofalist[$year][$hash]['date'] < $show_sofa['date']) {
					$sofalist[$year][$hash]['new'] = htmlClean($show_sofa['comment']);
					$sofalist[$year][$hash]['mail'] = $show_sofa['mail'];
					if($show_sofa['url']) {
						$sofalist[$year][$hash]['url'] = $show_sofa['url'];
					}
					$sofalist[$year][$hash]['title'] = $show_sofa['title'];
					$sofalist[$year][$hash]['gid'] = $show_sofa['gid'];
				}
			}
		}
		$content = '<style>#sofa h4,#sofa h3{margin:0 0 5px;}#sofa .sofa-avatar{border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;}.sofa-nonce-month{float:left;width:32%;margin-right:1%;margin-top:5px}.sofa-nonce-month .sofa-avatar{float:left;margin:5px;}.sofa-list{clear:both;}.sofa-list img{float:left;margin:3px;}</style>';
		$content .= '<div id="sofa">';
		if(isset($sofalist[$nonce_year])) {
			$content .= '<div class="sofa-nonce-year"><h3>'.$nonce_year.'年度沙发榜</h3>';
			if(isset($sofalist[$nonce_year][$nonce_month])) {
				$content .= '<h4>本月沙发榜</h4>';
				uasort($sofalist[$nonce_year][$nonce_month],array($this,'sort'));
				$i = 0;
				foreach($sofalist[$nonce_year][$nonce_month] as $key=>$sofa) {
					$content .= '<div class="sofa-nonce-month">';
					$avatar = getGravatar($sofa['mail'],40);
					$img = '<img class="sofa-avatar" src="'.$avatar.'" width="40" height="40" alt="'.$sofa['poster'].'" />';
					if($sofa['url']) {
						$img = '<a href="'.$sofa['url'].'" target="_blank">'.$img.'</a>';
						$sofa['poster'] = '<a href="'.$sofa['url'].'" target="_blank">'.$sofa['poster'].'</a>';
					}
					$content .= $img.'<b>'.$sofa['poster'].'</b> 本月抢到'.$sofa['num'].'个沙发，最新一个在<a href="'.Url::log($sofa['gid']).'">《'.$sofa['title'].'》</a>说：<br />'.preg_replace("#\|ali(\d+)\|#i",'<img src="'.TEMPLATE_URL.'images/ali/$1.gif" id="ali$1" width="50" height="50" alt="阿狸$1" />',$sofa['new']);
					$content .= '</div>';
					if($i % 3 == 2) {
						$content .= '<div style="clear:both"></div>';
					}
					$i++;
				}
				unset($sofalist[$nonce_year][$nonce_month]);
			} else {
				$content .= '<div class="no-sofa">本月尚无人抢到沙发</div>';
			}
			krsort($sofalist[$nonce_year]);
			foreach($sofalist[$nonce_year] as $month=>$sofa_month) {
				$content .= '<div class="sofa-list">';
				$content .= '<h4>'.$month.'月沙发榜</h4>';
				uasort($sofa_month,array($this,'sort'));
				foreach($sofa_month as $key=>$sofa) {
					$avatar = getGravatar($sofa['mail'],32);
					$img = '<img class="sofa-avatar" src="'.$avatar.'" width="32" height="32" alt="'.$sofa['poster'].'" title="'.$sofa['poster'].'('.$sofa['num'].')" />';
					if($sofa['url']) {
						$img = '<a href="'.$sofa['url'].'" target="_blank">'.$img.'</a>';
						$sofa['poster'] = '<a href="'.$sofa['url'].'" target="_blank">'.$sofa['poster'].'</a>';
					}
					$content .= $img;
				}
				$content .= '</div>';
				unset($sofalist[$year][$month]);
			}
			$content .= '</div>';
			unset($sofalist[$nonce_year]);
		} else {
			$content .= '<div class="no-sofa">'.$year.'年度尚无人抢到沙发</div>';
		}
		krsort($sofalist);
		foreach($sofalist as $year=>$sofa_year) {
			$content .= '<div class="sofa-list">';
			$content .= '<h3>'.$year.'年沙发榜</h3>';
			uasort($sofa_year,array($this,'sort'));
			foreach($sofa_year as $key=>$sofa) {
				$avatar = getGravatar($sofa['mail'],40);
				$img = '<img class="sofa-avatar" src="'.$avatar.'" width="32" height="32" alt="'.$sofa['poster'].'" title="'.$sofa['poster'].'('.$sofa['num'].')" />';
				if($sofa['url']) {
					$img = '<a href="'.$sofa['url'].'" target="_blank">'.$img.'</a>';
					$sofa['poster'] = '<a href="'.$sofa['url'].'" target="_blank">'.$sofa['poster'].'</a>';
				}
				$content .= $img;
			}
			$content .= '</div>';
		}
		$content .= '</div>';
		$content = addslashes($content);
		$sql = "UPDATE ".DB_PREFIX."blog SET content='$content' WHERE alias='sofa'";
		$this->db->query($sql);
	}
	private function sort($a,$b) {
		if($a['num'] < $b['num']) {
			return 1;
		} elseif($a['num'] == $b['num']) {
			if($a['date'] > $b['date']) {
				return 1;
			} elseif($a['date'] == $b['date']) {
				return 0;
			} else {
				return -1;
			}
		} else {
			return -1;
		}
	}
}
