<?php
!defined('EMLOG_ROOT') && exit('access deined!');
$allow_remark = 'n';
$logid = '';
$blogtitle = '啊呃，哪里出错了？';
$log_title = 'Hi~';
$logs_info = getLogs();
$log_content = '<p>好像地址不正确呀，你计划看点什么？</p>';
$log_content .= '<p>不妨看看' . $logs_info['type'] . '</p>';
$log_content .= '<p>';
$curpage = '404';
foreach($logs_info['logs'] as $value)
{
	$log_content .= '<a href="'. BLOG_URL .'?post=' . $value['gid'] .'">' . $value['title'] . '</a><br />';
}
$log_content .= '</p>';
$log_content .= '<p>或者<a href="'. BLOG_URL .'?post=70">点击此处</a>给我留言</p>';
$log_content .= '<p>当然，你也可以尝试一下搜索：)</p>';
$log_content .= '<p><form method="get" action="http://www.google.com/search" target="_blank" id="logserch">
<input type="text" name="q" style="width:200px" />
<input type="submit" name="btnG" id="logserch_logserch" value="搜索" />
<input type="hidden" name="ie" value="UTF8" />
<input type="hidden" name="oe" value="UTF8" />
<input type="hidden" name="hl" value="zh-CN" />
<input type="hidden" name="domains" value="www.qiyuuu.com" />
<input type="hidden" name="sitesearch" value="www.qiyuuu.com" />
</form>';
include getViews('header');
include getViews('page');
function getLogs($type = 'hot')
{
	global $DB;
	require_once EMLOG_ROOT.'/model/class.blog.php';
	$emBlog = new emBlog();
	if($type == 'hot')
	{
		$type = '热门日志';
		$logs = $emBlog->getLogsForHome('ORDER BY comnum DESC',1,5);
	}else{
		$type = '随机日志';
		$logs = $emBlog->getRandLog(5);
	}
	return array('type'=>$type,'logs'=>$logs);
}