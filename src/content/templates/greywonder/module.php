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
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<ul class="blogger">
	<?php if (!empty($user_cache[1]['photo']['src'])): ?>
	<li><img src="<?php echo BLOG_URL.$user_cache[1]['photo']['src']; ?>" width="<?php echo $user_cache[1]['photo']['width']; ?>" height="<?php echo $user_cache[1]['photo']['height']; ?>" alt="blogger" /></li>
	<?php endif;?>
	<li><b><?php echo $name; ?></b></li>
	<li><?php echo $user_cache[1]['des']; ?></li>
	</ul>
	</div>
<?php }?>
<?php
//widget：日历
function widget_calendar($title){ ?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<ul id="calendar">
	</ul>
	<script>sendinfo('<?php echo Calendar::url(); ?>','calendar');</script>
	</div>
<?php }?>
<?php
//widget：标签
function widget_tag($title){
	global $CACHE;
	$tag_cache = $CACHE->readCache('tags');?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<ul class="tags">
	<li>
	<?php foreach($tag_cache as $value): ?>
		<span style="font-size:<?php echo $value['fontsize']; ?>pt; line-height:24px;">
		<a href="<?php echo Url::tag($value['tagurl']); ?>" title="<?php echo $value['usenum']; ?> 篇日志"><?php echo $value['tagname']; ?></a></span>
	<?php endforeach; ?>
	</li>
	</ul>
	</div>
<?php }?>
<?php
//widget：分类
function widget_sort($title){
	global $CACHE;
	$sort_cache = $CACHE->readCache('sort'); ?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<ul>
	<?php foreach($sort_cache as $value): ?>
	<li>
	<a href="<?php echo Url::sort($value['sid']); ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
	<a href="<?php echo BLOG_URL; ?>rss.php?sort=<?php echo $value['sid']; ?>"><img src="<?php echo TEMPLATE_URL; ?>images/rss.png" width="14" height="14" alt="订阅该分类"/></a>
	</li>
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
	<ul>
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
function widget_newcomm($title){
	global $CACHE; 
	$com_cache = $CACHE->readCache('comment');
	?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<ul class="recent-comment">
	<?php
	foreach($com_cache as $value):
	$url = Url::log($value['gid']).'#'.$value['cid'];
	?>
	<li><?php echo $value['name']; ?>：<a href="<?php echo $url; ?>"><?php echo preg_replace("#\|ali(\d+)\|#i",'<img src="'.TEMPLATE_URL.'images/ali/$1.gif" id="ali$1" width="16" height="16" alt="阿狸$1" />',$value['content']); ?></a></li>
	<?php endforeach; ?>
	</ul>
	</div>
<?php }?>
<?php
//widget：最新日志
function widget_newlog($title){
	global $CACHE; 
	$newLogs_cache = $CACHE->readCache('newlog');
	?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<ul>
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
	<ul>
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
	<ul>
	<form name="keyform" method="get" action="<?php echo BLOG_URL; ?>">
		<input name="keyword" class="search" type="text" value="" size="25" />
		<input type="submit" class="submit" value="搜索" onclick="return keyw()" />
	</form>
	</ul>
	</div>
<?php } ?>
<?php
//widget：归档
function widget_archive($title){
	global $CACHE; 
	$record_cache = $CACHE->readCache('record');
	?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<ul>
	<?php foreach($record_cache as $value): ?>
	<li><a href="<?php echo Url::record($value['date']); ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
	<?php endforeach; ?>
	</ul>
	</div>
<?php } ?>
<?php
//widget：自定义组件
function widget_custom_text($title, $content){ ?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<ul>
	<li><?php echo $content; ?></li>
	</ul>
	</div>
<?php } ?>
<?php
//widget：链接
function widget_link($title){
	global $CACHE; 
	$link_cache = $CACHE->readCache('link');
	?>
	<div class="widget">
	<h3><?php echo $title; ?></h3>
	<ul class="blogroll">
	<?php foreach($link_cache as $value): ?>
	<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</div>
<?php }?>
<?php
//blog：置顶
function topflg($istop){
	$topflg = $istop == 'y' ? "<img src=\"".TEMPLATE_URL."/images/import.gif\" title=\"置顶日志\" /> " : '';
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
function blog_sort($blogid){
	global $CACHE; 
	$log_cache_sort = $CACHE->readCache('logsort');
	?>
	<?php if(!empty($log_cache_sort[$blogid])): ?>
	分类：<a href="<?php echo Url::sort($log_cache_sort[$blogid]['id']); ?>"><?php echo $log_cache_sort[$blogid]['name']; ?></a>
	<?php endif;?>
<?php }?>
<?php
//blog：文件附件
function blog_att($blogid){
	global $CACHE;
	$log_cache_atts = $CACHE->readCache('logatts');
	$att = '';
	if(!empty($log_cache_atts[$blogid])){
		$att .= '<div class="log-att"><p><b>附件下载</b>：</p><hr />';
		foreach($log_cache_atts[$blogid] as $val){
			$att .= '<p><a href="'.BLOG_URL.$val['url'].'" target="_blank">'.$val['filename'].'</a> '.$val['size'].'</p>';
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
		$tag = '<div class="log-tags"><b>标签</b>：';
		foreach ($log_cache_tags[$blogid] as $value){
			$tag .= "	<a href=\"".Url::tag($value['tagurl'])." rel=\"tag\" \">".$value['tagname'].'</a>';
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
	<?php if($prevLog):?>
	<div class="previous"><a href="<?php echo Url::log($prevLog['gid']) ?>"><?php echo $prevLog['title'];?></a></div>
	<?php endif;?>
	<?php if($nextLog):?>
	<div class="next"><a href="<?php echo Url::log($nextLog['gid']) ?>"><?php echo $nextLog['title'];?></a></div>
	<?php endif;?>
<?php }?>
<?php
//blog：引用通告地址
function blog_trackback_url($tb_url, $allow_tb){
    if($allow_tb == 'y'):?>
	<div class="trackback-url"><b>引用地址</b>： <input type="text" style="width:350px" value="<?php echo $tb_url; ?>"></div>
	<?php endif; ?>
<?php }?>
<?php
//blog：引用通告
function blog_trackback($tb){
	if($tb):
?>
	<div class="trackback">
		<h2>站外引用：</h2>
		<ul>
		<?php $alt = ''; ?>
		<?php foreach($tb as $key=>$value):?>
			<li<?php echo $alt; ?>>
				<p><span class="date"><?php echo $value['date'];?></span><i><?php echo $value['blog_name']; ?></i>发表了日志：<a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a></p>
				<p><?php echo subString($value['excerpt'],0,200); ?></p>
			</li>
		<?php $alt = $alt == '' ? ' class="alt"' : ''; ?>
		<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>
<?php }?>
<?php
//blog：博客评论列表
function blog_comments($comments,$params,$logid){
	extract($comments);
    if($comments): ?>
    <div class="comments" id="comments">
    	<div class="click-to-comment"><a href="#comment-post">发表评论</a></div>
		<h2>评论：</h2>
		<ul>
	<?php
	$isGravatar = Option::get('isgravatar');
	$alt = '';
	$comnum = count($commentStack);
	$pagenum = ceil($comnum / 10);
	$page = isset($params[2]) && ctype_digit($params[2]) ? abs(intval($params[2])) : $pagenum;
	$commentStack = array_slice($commentStack, ($page - 1) * 10, 10, true);
	foreach($commentStack as $key => $cid):
	$comment = $comments[$cid];
	$admin = $comment['poster'] == '奇遇' ? ' admin' : '';
	$hash = md5($comment['mail']);
	$avatar = "http://".(hexdec($hash{0}) % 3).".qiyuuu.com/$hash";
	$width = 40;
	if($key == 0) {$avatar .= "_80";$width = 80;}
	elseif($key == 1) {$avatar .= "_60";$width = 60;}
	$avatar .= ".jpg";
	$poster = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
	?>
	<li class="comment<?php echo $alt; echo $admin; ?>" id="comment-<?php echo $comment['cid']; ?>">
		<a name="<?php echo $comment['cid']; ?>"></a>
		<?php if($isGravatar == 'y'): ?><div class="avatar"><img src="<?php echo $avatar; ?>" width="<?php echo $width; ?>" height="<?php echo $width; ?>" alt="<?php echo $comment['poster']; ?>"/></div><?php endif; ?>
		<div class="comment-info">
			<b><?php echo $poster; ?></b>
			<span class="comment-time"><?php echo $comment['date']; ?></span>
			<div class="comment-content"><?php echo preg_replace("#\|ali(\d+)\|#i",'<img src="'.TEMPLATE_URL.'images/ali/$1.gif" id="ali$1" width="50" height="50" alt="阿狸$1" />',$comment['content']); ?></div>
			<div class="comment-reply"><a href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)">回复</a></div>
		</div>
		<?php $alt = $alt == '' ? ' alt' : ''; ?>
		<?php blog_comments_children($comments, $comment['children'], $alt); ?>
	</li>
	<?php endforeach; ?>
	</ul>
	</div>
	<?php if($comnum > 10): ?><div class="pagenavi">Page <?php echo $page; ?> of <?php echo $pagenum; ?> <?php echo pagination($comnum, 10, $page, Url::log($logid));?></div><?php endif; ?>
	<?php endif; ?>
<?php }?>
<?php
//blog：博客子评论列表
function blog_comments_children($comments, $children, $alt){
	$isGravatar = Option::get('isgravatar');
?>
	<ul class="children">
<?php
	foreach($children as $child):
	$comment = $comments[$child];
	$admin = $comment['poster'] == '奇遇' ? ' admin' : '';
	$hash = md5($comment['mail']);
	$avatar = "http://".(hexdec($hash{0}) % 3).".qiyuuu.com/$hash.jpg";
	$width = 40;
	$poster = $comment['url'] ? '<a href="'.$comment['url'].'" target="_blank">'.$comment['poster'].'</a>' : $comment['poster'];
	?>
	<li class="comment<?php echo $alt; echo $admin; ?>" id="comment-<?php echo $comment['cid']; ?>">
		<a name="<?php echo $comment['cid']; ?>"></a>
		<?php if($isGravatar == 'y'): ?><div class="avatar"><img src="<?php echo $avatar; ?>" width="<?php echo $width; ?>" height="<?php echo $width; ?>" alt="<?php echo $comment['poster']; ?>" /></div><?php endif; ?>
		<div class="comment-info">
			<b><?php echo $poster; ?></b>
			<span class="comment-time"><?php echo $comment['date']; ?></span>
			<div class="comment-content"><?php echo preg_replace("#\|ali(\d+)\|#i",'<img src="'.TEMPLATE_URL.'images/ali/$1.gif" id="ali$1" width="50" height="50" alt="阿狸$1" />',$comment['content']); ?></div>
			<div class="comment-reply"><a href="#comment-<?php echo $comment['cid']; ?>" onclick="commentReply(<?php echo $comment['cid']; ?>,this)">回复</a></div>
		</div>
		<?php $alt = $alt == '' ? ' alt' : ''; ?>
		<?php blog_comments_children($comments, $comment['children'], $alt);?>
	</li>
	<?php endforeach; ?>
	</ul>
<?php }?>
<?php
//blog：发表评论表单
function blog_comments_post($logid,$ckname,$ckmail,$ckurl,$verifyCode,$allow_remark){
	if($allow_remark == 'y'): ?>
	<div id="comment-place">
	<div class="comment-post" id="comment-post">
		<div class="cancel-reply" id="cancel-reply" style="display:none"><a href="#comment-post" onclick="cancelReply()">取消回复</a></div>
		<h2>发表评论：</h2>
		<form method="post" name="commentform" action="<?php echo BLOG_URL; ?>?action=addcom" id="commentform">
			<?php if(ROLE == 'visitor'): ?>
			<?php if($ckname != ''): ?>
			<p>欢迎回来，<b><?php echo $ckname; ?></b>  <a href="javascript:void(0);" style="font-size:12px" onclick="toggleInput()">换个昵称</a></p>
			<?php endif; ?>
			<div id="userinfo"<?php if($ckname != '') echo ' style="display:none"'; ?>>
			<p>
				<input type="text" name="comname" id="comname" maxlength="49" value="<?php echo $ckname; ?>" size="22" tabindex="1">
				<label for="author"><small>昵称</small></label>
			</p>
			<p>
				<input type="text" name="commail" id="commail"  maxlength="128"  value="<?php echo $ckmail; ?>" size="22" tabindex="2">
				<label for="email"><small>邮件地址 (选填)</small></label>
			</p>
			<p>
				<input type="text" name="comurl" id="comurl" maxlength="128"  value="<?php echo $ckurl; ?>" size="22" tabindex="3">
				<label for="url"><small>个人主页 (选填)</small></label>
			</p>
			</div>
			<?php
				else:
				$CACHE = Cache::getInstance();
				$user_cache = $CACHE->readCache('user');
			?>
			<p>您当前已登录为 <b><?php echo $user_cache[UID]['name']; ?></b></p>
			<input type="hidden" name="comname" maxlength="49" value="<?php echo $user_cache[UID]['name']; ?>" size="22" tabindex="1">
			<input type="hidden" name="commail"  maxlength="128"  value="<?php echo $user_cache[UID]['mail']; ?>" size="22" tabindex="2">
			<input type="hidden" name="comurl" maxlength="128"  value="<?php echo BLOG_URL; ?>" size="22" tabindex="3">
			<?php endif; ?>
			<div class="smiles" id="smiles">
				<?php for($i = 1; $i <= 20; $i++): ?>
				<img src="<?php echo TEMPLATE_URL; ?>images/ali/<?php echo $i; ?>.gif" id="ali<?php echo $i; ?>" width="24" height="24" alt="阿狸<?php echo $i; ?>" />
				<?php endfor; ?>
			</div>
			<p>
				<textarea name="comment" id="comment" rows="10" tabindex="4"></textarea>
			</p>
			<p><?php echo $verifyCode; ?> <input type="submit" id="comment_submit" value="发表评论(CTRL+ENTER)" onclick="return commentSubmit()" /></p>
			<input type="hidden" name="gid" value="<?php echo $logid; ?>" size="22" tabindex="1"/>
			<input type="hidden" name="pid" id="comment-pid" value="0" size="22" tabindex="1"/>
		</form>
	</div>
	</div>
	<?php endif; ?>
<?php }?>