<?php
/*
Plugin Name: JiaThis分享插件
Version: 1.0
Plugin URL:
Description: JiaThis社会化分享插件在日志内容页面提供分享到微博、QQ、人人等按钮，方便访客分享，给你代来更多流量和外链。
ForEmlog:4.2.1
Author: emlog
Author URL: http://www.emlog.net
*/

!defined('EMLOG_ROOT') && exit('access deined!');

function jiathis_share()
{
	echo '
	<!-- JiaThis Button BEGIN -->
	<div id="ckepop">
		<span class="jiathis_txt">分享到：</span>
		<a class="jiathis_button_tsina">新浪微博</a>
		<a class="jiathis_button_tqq">腾讯微博</a>
		<a class="jiathis_button_renren">人人网</a>
		<a href="http://www.jiathis.com/share?uid=1588758" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank">更多</a>
		<a class="jiathis_counter_style"></a>
	</div>
	<script type="text/javascript">var jiathis_config = {data_track_clickback:true};</script>
	<script type="text/javascript" src="http://v2.jiathis.com/code/jia.js?uid=1588758" charset="utf-8"></script>
	<br />
	<!-- JiaThis Button END -->
	';
}

addAction('log_related', 'jiathis_share');
