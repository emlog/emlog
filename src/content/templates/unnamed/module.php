<?php 
/*
* 侧边栏组件、页面模块
*/
if(!defined('EMLOG_ROOT')) {exit('error!');}
$ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
$isIE6 = strpos($ua,'MSIE 6.0');
$isIE9 = strpos($ua,'MSIE 9.0');
$isIE = strpos($ua,'MSIE');
?>
<?php
//widget：blogger
function widget_blogger($title){
	global $CACHE;
	$user_cache = $CACHE->readCache('user');
	$name = $user_cache[1]['mail'] != '' ? "<a href=\"mailto:".$user_cache[1]['mail']."\">".$user_cache[1]['name']."</a>" : $user_cache[1]['name'];?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<div id="blogger">
	<?php if (!empty($user_cache[1]['photo']['src'])): ?><img src="<?php echo BLOG_URL.$user_cache[1]['photo']['src']; ?>" width="<?php echo $user_cache[1]['photo']['width']; ?>" height="<?php echo $user_cache[1]['photo']['height']; ?>" alt="blogger" /><?php endif;?>
	<p><b><?php echo $name; ?></b><br />
	<?php echo $user_cache[1]['des']; ?></p>
	</div>
	</div>
<?php }?>
<?php
//widget：日历
function widget_calendar($title){ ?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<div id="calendar">
	</div>
	<script>sendinfo('<?php echo Calendar::url(); ?>','calendar');</script>
	</div>
<?php }?>
<?php
//widget：标签
function widget_tag($title){
	global $CACHE;
	$tag_cache = $CACHE->readCache('tags');
	$hide_tag = count($tag_cache) > 20;
?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<div id="side-tags">
	<?php foreach($tag_cache as $key=>$value): ?>
		<span style="font-size:<?php echo $value['fontsize']; ?>pt; line-height:26px;"<?php if($hide_tag && $key>18) echo ' class="hide-tags"';?>>
		<a href="<?php echo Url::tag($value['tagurl']); ?>" title="<?php echo $value['usenum']; ?> 篇日志" style="color:#<?php echo get_tag_color($value['fontsize']);?>"><?php echo $value['tagname']; ?></a></span>
	<?php endforeach; ?>
	<?php if($hide_tag): ?><span id="show-tags" onclick="$('.hide-tags').show();$(this).remove();">更多&raquo;</span><?php endif; ?>
	</div>
	</div>
<?php }?>
<?php
//widget：分类
function widget_sort($title){
	global $CACHE;
	$sort_cache = $CACHE->readCache('sort'); ?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<ul id="side-sort">
	<?php foreach($sort_cache as $value): ?>
	<li><a href="<?php echo Url::sort($value['sid']); ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a><span><a href="<?php echo BLOG_URL; ?>rss.php?sort=<?php echo $value['sid']; ?>" title="订阅<?php echo $value['sortname']; ?>" class="non-ajax">RSS</a></span></li>
	<?php endforeach; ?>
	</ul>
	</div>
<?php }?>
<?php
//widget：最新碎语
function widget_twitter($title){
	global $CACHE; 
	$newtws_cache = $CACHE->readCache('newtw');
	$istwitter = Option::get('istwitter');
	?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<ul id="side-tw">
	<?php foreach($newtws_cache as $value): ?>
	<li><?php echo $value['t']; ?><p><?php echo smartDate($value['date']); ?> </p></li>
	<?php endforeach; ?>
    <?php if ($istwitter == 'y') :?>
	<li class="tw-more"><a href="<?php echo BLOG_URL . 't/'; ?>">更多&raquo;</a></li>
	<?php endif;?>
	</ul>
	</div>
<?php }?>
<?php
//widget：最新评论
function widget_newcomm($title,$_ = 1){
	global $CACHE; 
	$com_cache = $CACHE->readCache('comment');
	if($_):
	?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<ul id="side-comment">
	<?php
	endif;
	foreach($com_cache as $value):
	$url = Url::comment($value['gid'], $value['page'], $value['cid']);
	?>
	<li><img src="<?php echo getGravatar($value['mail'],32); ?>" class="side-avatar" width="32" height="32" /><b><?php echo $value['name']; ?></b> 说：
	<br /><a href="<?php echo $url; ?>"><?php echo preg_replace("#\|ali(\d+)\|#i",'<img src="'.TEMPLATE_URL.'images/ali/$1.gif" id="ali$1" width="16" height="16" alt="阿狸$1" />',$value['content']); ?></a></li>
	<?php endforeach; ?>
	<?php if($_): ?>
	</ul>
	</div>
	<?php endif; ?>
<?php }?>
<?php
//widget：最新日志
function widget_newlog($title){
	global $CACHE; 
	$newLogs_cache = $CACHE->readCache('newlog');
	?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<ul id="side-newlog">
	<?php foreach($newLogs_cache as $value): ?>
	<li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</div>
<?php }?>
<?php
//widget：随机日志
function widget_random_log($title){
	$index_randlognum = Option::get('index_randlognum');
	$Log_Model = new Log_Model();
	$randLogs = $Log_Model->getRandLog($index_randlognum);?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<ul id="randlog">
	<?php foreach($randLogs as $value): ?>
	<li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</div>
<?php }?>
<?php
//widget：搜索
function widget_search($title){ ?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<div id="side-search">
	<form name="keyform" method="get" action="<?php echo BLOG_URL; ?>" id="search" >
		<input name="keyword" class="search-input" id="keyword" type="text" value="" />
		<input type="submit" class="search-submit" value="GO" />
	</form>
	</div>
	</div>
<?php }?>
<?php
//widget：归档
function widget_archive($title){
	global $CACHE; 
	$record_cache = $CACHE->readCache('record');
	?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<ul id="side-record">
	<?php foreach($record_cache as $value): ?>
	<li><a href="<?php echo Url::record($value['date']); ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
	<?php endforeach; ?>
	</ul>
	</div>
<?php }?>
<?php
//widget：自定义组件
function widget_custom_text($title, $content){ ?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<ul>
	<?php echo $content; ?>
	</ul>
	</div>
<?php }?>
<?php
//widget：链接
function widget_link($title){
	global $CACHE; 
	$link_cache = $CACHE->readCache('link');
	$even = '';
	?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<ul id="side-link">
	<?php foreach($link_cache as $value): ?>
	<li<?php echo $even;?>><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
	<?php $even = $even == '' ? ' class="even"' : '';endforeach; ?>
	</ul>
	</div>
<?php }?>
<?php
//blog：置顶
function topflg($istop){
	$topflg = $istop == 'y' ? "<img src=\"".TEMPLATE_URL."/images/top.gif\" title=\"置顶日志\" alt=\"置顶日志\" /> " : '';
	echo $topflg;
}
?>
<?php
//blog：编辑
function editflg($logid,$author){
	$editflg = ROLE == 'admin' || $author == UID ? '<a href="'.BLOG_URL.'admin/write_log.php?action=edit&gid='.$logid.'" class="non-ajax">编辑</a>' : '';
	echo $editflg;
}
?>
<?php
//blog：分类
function blog_sort($blogid){
	global $CACHE; 
	$log_cache_sort = $CACHE->readCache('logsort');
	?>
	<?php if(!empty($log_cache_sort[$blogid])): ?>
	/ <a href="<?php echo Url::sort($log_cache_sort[$blogid]['id']); ?>"><?php echo $log_cache_sort[$blogid]['name']; ?></a>
	<?php endif;?>
<?php }?>
<?php
//blog：文件附件
function blog_att($blogid){
	global $CACHE;
	$log_cache_atts = $CACHE->readCache('logatts');
	$att = '';
	if(!empty($log_cache_atts[$blogid])){
		$att .= '<div class="att"><b>附件下载</b>：';
		foreach($log_cache_atts[$blogid] as $val){
			$att .= '<br /><a href="'.BLOG_URL.$val['url'].'" target="_blank">'.$val['filename'].'</a> '.$val['size'];
		}
		$att .= '</div>';
	}
	echo $att;
}
?>
<?php
//blog：日志标签
function blog_tag($blogid){
	global $CACHE;
	$log_cache_tags = $CACHE->readCache('logtags');
	if (!empty($log_cache_tags[$blogid])){
		$tag = '<div class="log-tags"><b>标签</b>:';
		foreach ($log_cache_tags[$blogid] as $value){
			$tag .= "	<a href=\"".Url::tag($value['tagurl'])."\" rel=\"tag\">".$value['tagname'].'</a>';
		}
		$tag .= '</div>';
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
	<div class="prevlog"><b>上一篇</b>：<?php if($prevLog):?><a href="<?php echo Url::log($prevLog['gid']) ?>"><?php echo $prevLog['title'];?></a><?php else: ?>没有了<?php endif;?></div>
	<div class="nextlog"><b>下一篇</b>：<?php if($nextLog):?><a href="<?php echo Url::log($nextLog['gid']) ?>"><?php echo $nextLog['title'];?></a><?php else: ?>没有了<?php endif;?></div>
<?php }?>
<?php
//blog：引用通告
function blog_trackback($tb, $tb_url, $allow_tb){
    if($allow_tb == 'y' && Option::get('istrackback') == 'y'):?>
	<div id="tb">
		<b>引用地址</b>：<?php echo $tb_url; ?>
		<?php if($tb): ?><div class="tb-count" onclick='$("#trackbacklist").toggle("normal")'>展开/折叠引用</div><?php endif; ?>
	</div>
	<?php endif; ?>
	<ul id="trackbacklist">
	<?php foreach($tb as $key=>$value):?>
		<li class="trackback">
			<?php echo $value['blog_name'];?>：<a href="<?php echo $value['url'];?>" target="_blank"><b><?php echo $value['title'];?></b></a>
			<div class="tb-time"><?php echo $value['date'];?></div>
		</li>
	<?php endforeach; ?>
	</ul>
<?php }?>
<?php
//blog：博客评论列表
function blog_comments($comments){
    extract($comments);
    if($commentStacks): ?>
	<h2>评论：</h2>
	<ul id="commentlist">
	<?php
	$alt = '';
	$isGravatar = Option::get('isgravatar');
	foreach($commentStacks as $cid):
    $comment = $comments[$cid];
	$poster = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
	?>
	<li class="comment<?php echo $alt;?>" id="comment-<?php echo $comment['cid']; ?>">
		<a name="<?php echo $comment['cid']; ?>"></a>
		<?php if($isGravatar == 'y'): ?><div class="avatar"><img src="<?php echo getGravatar($comment['mail'],40); ?>" width="40" height="40" alt="<?php echo $comment['poster'];?>" /></div><?php endif; ?>
		<div class="comment-info">
			<div class="comment-reply"><a href="javascript:void(0)" onclick="commentReply(<?php echo $comment['cid']; ?>,this)">回复</a></div>
			<div class="comment-meta"><?php echo $poster; ?> <span class="comment-time"><?php echo $comment['date']; ?></span></div>
			<div class="comment-content"><?php echo preg_replace("#\|ali(\d+)\|#i",'<img src="'.TEMPLATE_URL.'images/ali/$1.gif" id="ali$1" width="50" height="50" alt="阿狸$1" />',$comment['content']); ?></div>
		</div>
		<?php
			$alt = $alt == '' ? ' alt' : '';
			blog_comments_children($comments, $comment['children'] ,$alt);
		?>
	</li>
	<?php endforeach; ?>
	</ul>
    <div id="pagenavi">
	    <?php echo $commentPageUrl;?>
    </div>
	<?php endif; ?>
<?php }?>
<?php
//blog：博客子评论列表
function blog_comments_children($comments, $children, $alt){
	if($children):
?>
	<ul class="children">
<?php
	$isGravatar = Option::get('isgravatar');
	foreach($children as $child):
	$comment = $comments[$child];
	$poster = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
	?>
	<li class="comment<?php echo $alt;?>" id="comment-<?php echo $comment['cid']; ?>">
		<a name="<?php echo $comment['cid']; ?>"></a>
		<?php if($isGravatar == 'y'): ?><div class="avatar"><img src="<?php echo getGravatar($comment['mail'],32); ?>" width="32" height="32" alt="<?php echo $comment['poster'];?>" /></div><?php endif; ?>
		<div class="comment-info">
			<div class="comment-reply"><a href="javascript:void(0)" onclick="commentReply(<?php echo $comment['cid']; ?>,this)">回复</a></div>
			<div class="comment-meta"><?php echo $poster; ?> <span class="comment-time"><?php echo $comment['date']; ?></span></div>
			<div class="comment-content"><?php echo preg_replace("#\|ali(\d+)\|#i",'<img src="'.TEMPLATE_URL.'images/ali/$1.gif" id="ali$1" width="50" height="50" alt="阿狸$1" />',$comment['content']); ?></div>
		</div>
		<?php
			$alt = $alt == '' ? ' alt' : '';
			blog_comments_children($comments, $comment['children'] ,$alt);
		?>
	</li>
	<?php endforeach; ?>
	</ul>
	<?php endif; ?>
<?php }?>
<?php
//blog：发表评论表单
function blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark){
	if($allow_remark == 'y'): ?>
	<div id="comment-place">
	<div class="comment-post" id="comment-post">
		<h2>发表评论：</h2>
		<div class="cancel-reply" id="cancel-reply" style="display:none"><a href="javascript:void(0);" onclick="cancelReply()">取消回复</a></div>
		<form method="post" name="commentform" action="<?php echo BLOG_URL; ?>index.php?action=addcom" id="commentform">
			<input type="hidden" name="gid" value="<?php echo $logid; ?>" />
			<div class="cmt-form-l">
				<p><textarea name="comment" id="comment" rows="10" tabindex="4"></textarea></p>
			</div>
			<div class="cmt-form-r">
			<div id="message"></div>
			<?php if(ROLE == 'visitor'): ?>
			<p>
				<label for="author">昵称</label>
				<input type="text" name="comname" id="comname" maxlength="49" value="<?php echo $ckname; ?>" size="22" tabindex="1">
			</p>
			<p>
				<label for="email">邮件地址 (选填)</label>
				<input type="text" name="commail" id="commail"  maxlength="128"  value="<?php echo $ckmail; ?>" size="22" tabindex="2">
			</p>
			<p>
				<label for="url">个人主页 (选填)</label>
				<input type="text" name="comurl" id="comurl" maxlength="128"  value="<?php echo $ckurl; ?>" size="22" tabindex="3">
			</p>
			<?php endif; ?>
			<p><?php echo $verifyCode; ?> <input type="submit" id="comment_submit" value="发表评论" /></p>
			<input type="hidden" name="pid" id="comment-pid" value="0" size="22" tabindex="1"/>
			</div>
		</form>
	</div>
	</div>
	<?php endif; ?>
<?php }?>
<?php
function get_tag_color($fontsize) {
	$color = array(
		10 => 'c3c3c3',
		11 => 'c8c8c8',
		12 => 'cdcdcd',
		13 => 'd2d2d2',
		14 => 'd7d7d7',
		15 => 'dcdcdc',
		16 => 'e1e1e1',
		17 => 'e6e6e6',
		18 => 'ebebeb',
		19 => 'f0f0f0',
		20 => 'f5f5f5',
		21 => 'fafafa',
		22 => 'ffffff'
		);
	return isset($color[$fontsize]) ? $color[$fontsize] : 666;
}
function loadJs(){
	$content = ob_get_contents();
	if(stripos($content,"jquery") !== false) {
		echo '<script src="'.TEMPLATE_URL.'js/function.withoutJQ.js" type="text/javascript"></script>';
	} else {
		echo '<script src="'.TEMPLATE_URL.'js/function.js" type="text/javascript"></script>';
	}
}