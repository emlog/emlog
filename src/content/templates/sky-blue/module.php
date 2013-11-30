<?php 
/*
* 侧边栏组件、页面模块
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<?php
//widget：blogger
function widget_blogger($title){
	global $CACHE;
	$user_cache = $CACHE->readCache('user');
	$name = $user_cache[1]['mail'] != '' ? "<a href=\"mailto:".$user_cache[1]['mail']."\">".$user_cache[1]['name']."</a>" : $user_cache[1]['name'];?>
	<li>
	<h2><?php echo $title; ?></h2>
	<ul id="bloggerinfo" style="text-align:center">
	<div id="bloggerinfoimg">
	<?php if (!empty($user_cache[1]['photo']['src'])): ?>
	<img src="<?php echo BLOG_URL.$user_cache[1]['photo']['src']; ?>" width="<?php echo $user_cache[1]['photo']['width']; ?>" height="<?php echo $user_cache[1]['photo']['height']; ?>" alt="blogger" />
	<?php endif;?>
	</div>
	<span><b><?php echo $name; ?></b><br />
	<?php echo $user_cache[1]['des']; ?></span>
	</ul>
	</li>
	<div class="sidebar_foot"></div>
<?php }?>
<?php
//widget：日历
function widget_calendar($title){ ?>
	<li>
	<h2><?php echo $title; ?></h2>
	<ul id="calendar">
	</ul>
	<script>sendinfo('<?php echo Calendar::url(); ?>','calendar');</script>
	</li>
	<div class="sidebar_foot"></div>
<?php }?>
<?php
//widget：标签
function widget_tag($title){
	global $CACHE;
	$tag_cache = $CACHE->readCache('tags');?>
	<li>
	<h2><?php echo $title; ?></h2>
	<ul id="blogtags">
	<li>
	<?php foreach($tag_cache as $value): ?>
		<span style="font-size:<?php echo $value['fontsize']; ?>pt; height:30px;">
		<a href="<?php echo Url::tag($value['tagurl']); ?>" title="<?php echo $value['usenum']; ?> 篇日志" rel="tag"><?php echo $value['tagname']; ?></a></span>
	<?php endforeach; ?>
	</li>
	</ul>
	</li>
	<div class="sidebar_foot"></div>
<?php }?>
<?php
//widget：分类
function widget_sort($title){
	global $CACHE;
	$sort_cache = $CACHE->readCache('sort'); ?>
	<li>
	<h2><?php echo $title; ?></h2>
		<ul id="blogsort">
	<?php foreach($sort_cache as $value): ?>
	<li>
	<a href="<?php echo Url::sort($value['sid']); ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
	<a href="<?php echo BLOG_URL; ?>rss.php?sort=<?php echo $value['sid']; ?>"><img align="absmiddle" src="<?php echo TEMPLATE_URL; ?>images/icon_rss.gif" alt="订阅该分类"/></a>
	</li>
	<?php endforeach; ?>
	</ul>
	</li>
	<div class="sidebar_foot"></div>
<?php }?>
<?php
//widget：最新碎语
function widget_twitter($title){
	global $CACHE; 
	$newtws_cache = $CACHE->readCache('newtw');
	$istwitter = Option::get('istwitter');
	?>
	<li>
	<h2><?php echo $title; ?></h2>
	<ul id="twitter">
	<?php foreach($newtws_cache as $value): ?>
	<li><span><?php echo $value['t']; ?></span><p><?php echo smartDate($value['date']); ?> </p></li>
	<?php endforeach; ?>
    <?php if ($istwitter == 'y') :?>
	<li><a href="<?php echo BLOG_URL . 't/'; ?>">更多&raquo;</a></li>
	<?php endif;?>
	</ul>
	</li>
	<div class="sidebar_foot"></div>
<?php }?>
<?php
//widget：最新评论
function widget_newcomm($title){
	global $CACHE; 
	$com_cache = $CACHE->readCache('comment');
	?>
	<li>
	<h2><?php echo $title; ?></h2>
	<ul id="newcomment">
	<?php
	foreach($com_cache as $value):
	$url = Url::log($value['gid']).'#'.$value['cid'];
	?>
	<li><span><?php echo $value['name']; ?></span>
	<br /><a href="<?php echo $url; ?>"><?php echo $value['content']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</li>
	<div class="sidebar_foot"></div>
<?php }?>
<?php
//widget：最新日志
function widget_newlog($title){
	global $CACHE; 
	$newLogs_cache = $CACHE->readCache('newlog');
	?>
	<li>
	<h2><?php echo $title; ?></h2>
	<ul id="newlog">
	<?php foreach($newLogs_cache as $value): ?>
	<li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</li>
	<div class="sidebar_foot"></div>
<?php }?>
<?php
//widget：随机日志
function widget_random_log($title){
	$index_randlognum = Option::get('index_randlognum');
	$Log_Model = new Log_Model();
	$randLogs = $Log_Model->getRandLog($index_randlognum);?>
	<li>
	<h2><?php echo $title; ?></h2>
	<ul id="randlog">
	<?php foreach($randLogs as $value): ?>
	<li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</li>
	<div class="sidebar_foot"></div>
<?php }?>
<?php
//widget：搜索
function widget_search($title){ ?>
	<li>
	<h2><?php echo $title; ?></h2>
	<ul id="logserch">
	<li>
	<form name="keyform" method="get" action="<?php echo BLOG_URL; ?>">
	<input name="keyword"  type="text" value="" style="width:120px;"/>
	<input type="submit" id="logserch_logserch" value="搜索" onclick="return keyw()" />
	</form>
	</li>
	</ul>
	</li>
	<div class="sidebar_foot"></div>
<?php } ?>
<?php
//widget：归档
function widget_archive($title){
	global $CACHE; 
	$record_cache = $CACHE->readCache('record');
	?>
	<li>
	<h2><?php echo $title; ?></h2>
	<ul id="record">
	<?php foreach($record_cache as $value): ?>
	<li><a href="<?php echo Url::record($value['date']); ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
	<?php endforeach; ?>
	</ul>
	</li>
	<div class="sidebar_foot"></div>
<?php } ?>
<?php
//widget：自定义组件
function widget_custom_text($title, $content){ ?>
	<li>
	<h2><?php echo $title; ?></h2>
	<ul>
	<?php echo $content; ?>
	</ul>
	</li>
	<div class="sidebar_foot"></div>
<?php } ?>
<?php
//widget：链接
function widget_link($title){
	global $CACHE; 
	$link_cache = $CACHE->readCache('link');
	?>
	<li>
	<h2><?php echo $title; ?></h2>
	<ul id="link">
	<li><a href="http://www.qiyuuu.com/plugin/feeds_gatherer/" title="友链日志">查看友链日志</a></li>
	<?php foreach($link_cache as $value): ?>
	<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</li>
	<div class="sidebar_foot"></div>
<?php }?>
<?php
//blog：置顶
function topflg($istop){
	global $CACHE;
	$log_cache_sort = $CACHE->readCache('logsort');
	$topflg = $istop == 'y' ? "<img src=\"".TEMPLATE_URL."/images/import.gif\" align=\"absmiddle\"  title=\"置顶日志\" /> " : '';
	echo $topflg;
}
?>
<?php
//blog：编辑
function editflg($logid,$author){
	$editflg = ROLE == 'admin' || $author == UID ? '<a href="'.BLOG_URL.'admin/write_log.php?action=edit&gid='.$logid.'">编辑</a>' : '';
	echo $editflg;
}
?>
<?php
//blog：分类
function blog_sort($sort, $blogid){
	global $CACHE; 
	$log_cache_sort = $CACHE->readCache('logsort');
	?>
	<?php if($log_cache_sort[$blogid]): ?>
	分类：<a href="<?php echo Url::sort($sort); ?>"><?php echo $log_cache_sort[$blogid]['sortname']; ?></a>
	<?php endif;?>
<?php }?>
<?php
//blog：文件附件
function blog_att($blogid){
	global $CACHE;
	$log_cache_atts = $CACHE->readCache('logatts');
	$att = '<p>';
	if(!empty($log_cache_atts[$blogid])){
		$att .= '<b>附件下载：</b>';
		foreach($log_cache_atts[$blogid] as $val){
			$att .= '<br /><a href="'.BLOG_URL.$val['url'].'" target="_blank">'.$val['filename'].'</a> '.$val['size'];
		}
	}
	$att .= '</p>';
	echo $att;
}
?>
<?php
//blog：日志标签
function blog_tag($blogid){
	global $CACHE;
	$log_cache_tags = $CACHE->readCache('logtags');
	if (!empty($log_cache_tags[$blogid])){
		$tag = '标签：';
		foreach ($log_cache_tags[$blogid] as $value){
			$tag .= "	<a href=\"".Url::tag($value['tagurl'])."\">".$value['tagname'].'</a>';
		}
		echo $tag;
	}
}
?>
<?php
//blog：日志作者
function blog_author($uid){
	global $CACHE;
	$user_cache = $CACHE->readCache('user');
	$author = $user_cache[$uid]['name'];
	$mail = $user_cache[$uid]['mail'];
	$des = $user_cache[$uid]['des'];
	$title = !empty($mail) || !empty($des) ? "title=\"$des $mail\"" : '';
	echo '<a href="'.Url::author($uid)."\" $title>$author</a>";
}
?>
<?php
//blog：相邻日志
function neighbor_log($neighborLog){
	extract($neighborLog);?>
	<p class="links" style="text-align:center">
	<?php if($prevLog):?>
	&laquo; <a href="<?php echo Url::log($prevLog['gid']) ?>"><?php echo $prevLog['title'];?></a>
	<?php endif;?>
	<?php if($nextLog && $prevLog):?>
		|
	<?php endif;?>
	<?php if($nextLog):?>
		 <a href="<?php echo Url::log($nextLog['gid']) ?>"><?php echo $nextLog['title'];?></a>&raquo;
	<?php endif;?>
	</p>
<?php }?>
<?php
//blog：引用通告地址
function blog_trackback_url($tb_url, $allow_tb){
    if($allow_tb == 'y'):?>
	<p class="links tburl">引用地址： <input type="text" style="width:350px" class="input" value="<?php echo $tb_url; ?>">
	<?php endif; ?>
<?php }?>
<?php
//blog：引用通告
function blog_trackback($tb){
?>
	<ol class="trackbacklist">
<?php foreach($tb as $key=>$value): ?>
		<li class="author" id="trackback-<?php echo $value['tbid'];?>">
			<p><?php echo str_replace('&amp;nbsp;','',$value['excerpt']);?></p>
            <span class="author_name">来自 <b><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></b> - <?php echo $value['date'];?></span>
		</li>
	<?php endforeach; ?>
	</ol>
<?php }?>
<?php
//blog：博客评论列表
function blog_comments($logid,$params){
?>
	<div class="top_post"></div>
    <div class="post">
    	<div class="byline">
			<h2 class="title">　评论：<a href="javascript:void(0);" onclick="$('#comment').focus()">（发表请点击）</a><a name="comments"></a></h2>
        </div>
    	<div class="entry">
			<?php
				$DB = MySql::getInstance();
				$page = isset($params[2]) && ctype_digit($params[2]) ? abs(intval($params[2])) : 1;
				$sql = "SELECT cid FROM ".DB_PREFIX."comment WHERE hide='n' AND gid=$logid AND pid=0";
				$commnum = $DB->num_rows($DB->query($sql));
				show_comment_main($logid,$page);
			?>
			<div class="pagenavi">
			<?php
				echo pagination($commnum, 10, $page, Url::log($logid));
			?>
			</div>
		</div>
    </div>
    <div class="bottom_post"></div>
<?php }?>
<?php
//blog: 评论树主干
function show_comment_main($logid,$page)
{
?>
	<ol class="commentlist">
<?php
	$DB = MySql::getInstance();
	$ip = getIp();
	$time = time();
	$start = ($page - 1)*10;
	$sql = "SELECT * FROM ".DB_PREFIX."comment WHERE hide='n' AND gid=$logid AND pid=0 ORDER BY cid DESC LIMIT $start,10";
	$query = $DB->query($sql);
	while($row = $DB->fetch_array($query)):
	$row['author'] = $row['url'] ? '<a href="'.BLOG_URL.'?gourl='.urlencode($row['url']).'" target="_blank">'.htmlspecialchars($row['poster']).'</a>' : htmlspecialchars($row['poster']);
?>
	<li class="comment" id="comment-<?php echo $row['cid']; ?>">
		<a name="<?php echo $row['cid']; ?>"></a>
		<img alt="<?php echo $row['poster']; ?>" src="<?php echo BLOG_URL; ?>avatar.php?<?php echo md5($row['mail']); ?>" height='40' width='40' />
		<p><?php echo htmlClean($row['comment']); ?></p>
        <span class="author_name">- <?php echo $row['author']; ?> - <?php echo smartDate($row['date']); ?> - <a href="javascript:void(0);" onclick="reply_comm(this)">回复</a></span>
		<?php show_comment_tree($logid,$row['cid'],1); ?>
	</li>
<?php
	endwhile;
?>
	</ol>
<?php
}
?>
<?php
//blog: 评论树枝
function show_comment_tree($logid,$pid,$depth){
?>
	<ol class="commentlist">
<?php
	$DB = MySql::getInstance();
	$ip = getIp();
	$time = time();
	$floor = 1;
	$sql = "SELECT * FROM ".DB_PREFIX."comment WHERE hide='n' AND gid=$logid AND pid=$pid ORDER BY cid ASC";
	$query = $DB->query($sql);
	while($row = $DB->fetch_array($query)):
	$row['author'] = $row['url'] ? '<a href="'.BLOG_URL.'?gourl='.urlencode($row['url']).'" target="_blank">'.htmlspecialchars($row['poster']).'</a>' : htmlspecialchars($row['poster']);
?>
	<li class="comment" id="comment-<?php echo $row['cid']; ?>">
		<a name="<?php echo $row['cid']; ?>"></a>
		<img alt="<?php echo $row['poster']; ?>" src="<?php echo BLOG_URL; ?>avatar.php?<?php echo md5($row['mail']); ?>" height='40' width='40' />
		<p><?php echo htmlClean($row['comment']); ?></p>
        <span class="author_name">- <?php echo $row['author']; ?> - <?php echo smartDate($row['date']); ?> - <a href="javascript:void(0);" onclick="reply_comm(this)">回复</a></span>
	<?php
		if($depth < 10):
		show_comment_tree($logid,$row['cid'],$depth+1);
	?>
	</li>
	<?php else: ?>
	</li>
	<?php show_comment_tree($logid,$row['cid'],$depth+1); ?>
	<?php endif; ?>
<?php
	$floor++;
	endwhile;
?>
	</ol>
<?php
}?>
<?php
//blog：发表评论表单
function blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark){
	if($allow_remark == 'y'):
		$CACHE = Cache::getInstance();
		$user_cache = $CACHE->readCache('user');
?>
	<h3 id="respond">Leave a Reply</h3>
	<form method="post"  name="commentform" action="<?php echo BLOG_URL; ?>?action=addcom" id="commentform">
	<p id="cancel_reply" style="display:none;"><a href="javascript:void(0);" onclick="cancel_reply()">不回此楼了</a></p>
	<?php if(ROLE == 'visitor') :?>
	<p><input type="text" name="comname" id="comname" value="<?php echo $ckname; ?>" size="22" tabindex="1" />
	<label for="author">昵称（必填）</label></p>
	<p><input type="text" name="commail" id="commail" value="<?php echo $ckmail; ?>" size="22" tabindex="2" />
	<label for="email">邮箱（选填）</label></p>
	<p><input type="text" name="comurl" id="comurl" value="<?php echo $ckurl; ?>" size="22" tabindex="3" />
	<label for="url">主页（选填）</label></p>
	<?php else: ?>
	<p><?php echo $user_cache[UID]['name']; ?></p>
	<p><input type="hidden" name="comname" id="comname" value="<?php echo $user_cache[UID]['name']; ?>" size="22" tabindex="1" /></p>
	<p><input type="hidden" name="commail" id="commail" value="<?php echo $user_cache[UID]['mail']; ?>" size="22" tabindex="2" /></p>
	<p><input type="hidden" name="comurl" id="comurl" value="<?php echo BLOG_URL;?>" size="22" tabindex="3" /></p>
	<?php endif;?>
	<p><textarea name="comment" id="comment" onkeydown="c(event)" cols="73" rows="10" tabindex="4"></textarea></p>
	<p><input name="submit" type="submit" id="comment_submit" tabindex="5" value="发表（CTRL+ENTER)" onclick="return submitComment(); " />
	<input type="hidden" name="gid" value="<?php echo $logid; ?>"  size="22" />
	<input type="hidden" name="pid" id="pid" value="0" size="22" />
	</p>
	</form>
	<?php endif; ?>
<?php }?>