<?php
/*
Plugin Name: sitemap
Version: 1.0
Plugin URL: http://www.qiyuuu.com/for-emlog/emlog-plugin-sitemap
Description: 生成sitemap，供搜索引擎抓取
Author: 奇遇
Author Email: qiyuuu@gmail.com
Author URL: http://www.qiyuuu.com
*/
!defined('EMLOG_ROOT') && exit('access deined!');
class sitemap {
	private $db;
	private $path;
	private $changefreq;
	private $priority;
	private $comment_time;
	private $data;
	function __construct() {
		extract(sitemap_config());
		$this->db = MySql::getInstance();
		$this->path = EMLOG_ROOT . '/' . $sitemap_name;
		$this->changefreq = $sitemap_changefreq;
		$this->priority = $sitemap_priority;
		$this->comment_time = $sitemap_comment_time;
	}
	function build() {
		$this->setData();
		$xml = $this->buildXML();
		return @file_put_contents($this->path,$xml);
	}
	private function setData() {
		$CACHE = Cache::getInstance();
		$data = array();
		$lastCommentTime = $this->getLastCommentTime();
		$data[] = array('url'=>BLOG_URL,'lastmod'=>time(),'changefreq'=>'always','priority'=>'1.0');
		//日志
		$query = $this->db->query("SELECT gid,date FROM " . DB_PREFIX . "blog WHERE type='blog' AND hide='n' ORDER BY date DESC");
		while($row = $this->db->fetch_array($query)) {
			$lastmod = $this->comment_time && isset($lastCommentTime[$row['gid']]) ? $lastCommentTime[$row['gid']] : $row['date'];
			$data[] = array('url'=>Url::log($row['gid']),'lastmod'=>$lastmod,'changefreq'=>$this->changefreq[0],'priority'=>$this->priority[0]);
		}
		//页面
		$query = $this->db->query("SELECT gid,date FROM " . DB_PREFIX . "blog WHERE type='page' AND hide='n' ORDER BY date DESC");
		while($row = $this->db->fetch_array($query)) {
			$lastmod = $this->comment_time && isset($lastCommentTime[$row['gid']]) ? $lastCommentTime[$row['gid']] : $row['date'];
			$data[] = array('url'=>Url::log($row['gid']),'lastmod'=>$lastmod,'changefreq'=>$this->changefreq[0],'priority'=>$this->priority[0]);
		}
		//分类
		foreach($CACHE->readCache('sort') as $value) {
			$data[] = array('url'=>Url::sort($value['sid']),'lastmod'=>time(),'changefreq'=>$this->changefreq[2],'priority'=>$this->priority[2]);	
		}
		//标签
		foreach($CACHE->readCache('tags') as $value) {
			$data[] = array('url'=>Url::tag($value['tagurl']),'lastmod'=>time(),'changefreq'=>$this->changefreq[3],'priority'=>$this->priority[3]);
		}
		//碎语
		if(Option::get('istwitter') == 'y') {
			$newtws_cache = $CACHE->readCache('newtw');
			$data[] = array('url'=>BLOG_URL . 't/','lastmod'=>$newtws_cache[0]['date'],'changefreq'=>$this->changefreq[4],'priority'=>$this->priority[4]);
		}
		//归档
		foreach($CACHE->readCache('record') as $value) {
			preg_match("/^([\d]{4})([\d]{2})$/", $value['date'], $match);
			$days = getMonthDayNum($match[2], $match[1]);
			$lastmod = emStrtotime($value['date'] . '01') + 3600 * 24 * $days;
			$data[] = array('url'=>Url::record($value['date']),'lastmod'=>$lastmod,'changefreq'=>$this->changefreq[5],'priority'=>$this->priority[5]);	
		}
		$this->data = $data;
	}
	private function generate($url, $lastmod, $changefreq, $priority) {
		$url = htmlspecialchars($url);
		$lastmod = gmdate('c',$lastmod);
		return "<url>\n<loc>$url</loc>\n<lastmod>$lastmod</lastmod>\n<changefreq>$changefreq</changefreq>\n<priority>$priority</priority>\n</url>\n";
	}
	private function buildXML() {
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
		foreach($this->data as $value) {
			extract($value);
			$xml .= $this->generate($url, $lastmod, $changefreq, $priority);
		}
		$xml .= '</urlset>';
		return $xml;
	}
	private function getLastCommentTime() {
		$query = $this->db->query("SELECT gid,max(date) as date FROM " . DB_PREFIX . "comment WHERE hide='n' GROUP BY gid");
		$lastCommentTime = array();
		while($row = $this->db->fetch_array($query)) {
			$lastCommentTime[$row['gid']] = $row['date'];
		}
		return $lastCommentTime;
	}
}