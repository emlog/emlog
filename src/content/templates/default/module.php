<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<?php
//widget：blogger
function widget_blogger($title){
	global $user_cache; 
	$name = $user_cache[1]['mail'] != '' ? "<a href=\"mailto:".$user_cache[1]['mail']."\">".$user_cache[1]['name']."</a>" : $user_cache[1]['name'];?>
	<li>
	<h3><span onclick="showhidediv('bloggerinfo')"><?php echo $title; ?></span></h3>
	<ul style="text-align:center" id="bloggerinfo">
	<div id="bloggerinfoimg">
	<?php if (!empty($user_cache[1]['photo']['src'])): ?>
	<img src="<?php echo $user_cache[1]['photo']['src']; ?>" width="<?php echo $user_cache[1]['photo']['width']; ?>" height="<?php echo $user_cache[1]['photo']['height']; ?>" alt="blogger" />
	<?php endif;?>
	</div>
	<li><b><?php echo $name; ?></b></li>
	<li><?php echo $user_cache[1]['des']; ?></li>
	</ul>
	</li>
<?php }?>
<?php
//widget：日历
function widget_calendar($title){
	global $calendar_url; ?>
	<li>
	<h3><span onclick="showhidediv('calendar')"><?php echo $title; ?></span></h3>
	<div id="calendar">
	</div>
	<script>sendinfo('<?php echo $calendar_url; ?>','calendar');</script>
	</li>
<?php }?>
<?php
//widget：标签
function widget_tag($title){
	global $tag_cache; ?>
	<li>
	<h3><span onclick="showhidediv('blogtags')"><?php echo $title; ?></span></h3>
	<ul id="blogtags">
	<li>
	<?php foreach($tag_cache as $value): ?>
		<span style="font-size:<?php echo $value['fontsize']; ?>pt; height:30px;">
		<a href="<?php echo BLOG_URL; ?>?tag=<?php echo $value['tagurl']; ?>" title="<?php echo $value['usenum']; ?> 篇日志"><?php echo $value['tagname']; ?></a></span>
	<?php endforeach; ?>
	</li>
	</ul>
	</li>
<?php }?>
<?php
//widget：分类
function widget_sort($title){
	global $sort_cache; ?>
	<li>
	<h3><span onclick="showhidediv('blogsort')"><?php echo $title; ?></span></h3>
	<ul id="blogsort">
	<?php foreach($sort_cache as $value): ?>
	<li>
	<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
	<a href="<?php echo BLOG_URL; ?>rss.php?sort=<?php echo $value['sid']; ?>"><img align="absmiddle" src="<?php echo TEMPLATE_URL; ?>images/icon_rss.gif" alt="订阅该分类"/></a>
	</li>
	<?php endforeach; ?>
	</ul>
	</li>
<?php }?>
<?php
//widget：twitter
function widget_twitter($title){
	global $index_twnum; ?>
	<li>
		<h3><span onclick="showhidediv('twitter')"><?php echo $title; ?></span></h3>
        <ul id="twitter"></ul>
        <script>sendinfo('<?php echo BLOG_URL; ?>twitter.php?p=1','twitter');</script>
		<?php if(ISLOGIN === true): ?>
		<p><a href="javascript:void(0);" onclick="showhidediv('addtw','tw')">写碎语</a></p>
		<p id='addtw' style="display: none;">
		<textarea name="tw" id="tw" style="overflow-y: hidden;width:180px;height:70px;" class="input"></textarea>
		<a href="javascript:void(0);" onclick="postinfo('<?php echo BLOG_URL; ?>twitter.php?action=add','tw','twitter');">发布</a>
		<a href="javascript:void(0);" onclick="showhidediv('addtw')">取消</a>
		</p>
		<?php endif;?>
	</li>
<?php } ?>
<?php 
//widget：音乐
function widget_music($title){
	global $options_cache;
	$music = @unserialize($options_cache['music']);
	$key = $music['randplay'] ? mt_rand(0,count($music['mlinks']) - 1) : 0 ;
	$musicurl = $music['mlinks'] ? $music['mlinks'][$key] : '';
	$musicdes = !empty($music['mdes'][$key]) ? $music['mdes'][$key] .'<br>' : '';
	$autoplay = $music['auto'] ? "&autoplay=1" : '';
	?>
	<li>
	<h3><span onclick="showhidediv('blogmusic')"><?php echo $title; ?></span></h3>	
	<ul id="blogmusic">
	<li><?php echo $musicdes; ?><object type="application/x-shockwave-flash" data="<?php echo TEMPLATE_URL; ?>images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" width="180" height="20"><param name="movie" value="<?php echo TEMPLATE_URL; ?>images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" /></object>
	</li>
	</ul>
	</li>
<?php }?>
<?php
//widget：最新评论
function widget_newcomm($title){
	global $com_cache; ?>
	<li>
	<h3><span onclick="showhidediv('newcomment')"><?php echo $title; ?></span></h3>
	<ul id="newcomment">
	<?php 
	foreach($com_cache as $value): 
	$url = BLOG_URL.'?post='.$value['gid'].'#'.$value['cid'];
	?>
	<li id="comment"><?php echo $value['name']; ?> 
	<?php if($value['reply']): ?>
	<a href="<?php echo $url; ?>" title="博主回复：<?php echo $value['reply']; ?>">
	<img src="<?php echo TEMPLATE_URL; ?>images/reply.gif" align="absmiddle"/>
	</a>
	<?php endif;?>
	<br /><a href="<?php echo $url; ?>"><?php echo $value['content']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</li>
<?php }?>
<?php
//widget：最新日志
function widget_newlog($title){
	global $newLogs_cache; ?>
	<li>
	<h3><span onclick="showhidediv('newlog')"><?php echo $title; ?></span></h3>
	<ul id="newlog">
	<?php foreach($newLogs_cache as $value): ?>
	<li><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</li>
<?php }?>
<?php
//widget：随机日志
function widget_random_log($title){
	global $index_randlognum, $emBlog;
	if (!isset($emBlog))
	{
		global $DB;
		require_once(EMLOG_ROOT.'/model/class.blog.php');
		$emBlog = new emBlog($DB);
	}
	$randLogs = $emBlog->getRandLog($index_randlognum);?>
	<li>
	<h3><span onclick="showhidediv('randlog')"><?php echo $title; ?></span></h3>
	<ul id="randlog">
	<?php foreach($randLogs as $value): ?>
	<li><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</li>
<?php }?>
<?php
//widget：搜索
function widget_search($title){ ?>
	<li>
	<h3><span onclick="showhidediv('logserch')"><?php echo $title; ?></span></h3>
	<ul id="logserch">
	<li>
	<form name="keyform" method="get" action="<?php echo BLOG_URL; ?>index.php"><p>
	<input name="keyword"  type="text" value="" style="width:120px;"/>
	<input type="submit" id="logserch_logserch" value="搜索" onclick="return keyw()" />
	</form>
	</li>
	</ul>
	</li>
<?php } ?>
<?php
//widget：归档
function widget_archive($title){
	global $dang_cache; ?>
	<li>
	<h3><span onclick="showhidediv('record')"><?php echo $title; ?></span></h3>
	<ul id="record">
	<?php 
	foreach($dang_cache as $value): 
	$value['url'] = BLOG_URL.$value['url'];
	?>
	<li><a href="<?php echo $value['url']; ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
	<?php endforeach; ?>		
	</ul>
	</li>
<?php } ?>
<?php
//widget：自定义组件
function widget_custom_text($title, $content, $id){ ?>
	<li>
	<h3><span onclick="showhidediv('<?php echo $id; ?>')"><?php echo $title; ?></span></h3>
	<ul id="<?php echo $id; ?>">
	<li><?php echo $content; ?></li>
	</ul>
	</li>
<?php } ?>
<?php
//widget：链接
function widget_link($title){
	global $link_cache; ?>
	<li>
	<h3><span onclick="showhidediv('link')"><?php echo $title; ?></span></h3>
	<ul id="link">
	<?php foreach($link_cache as $value): ?>     	
	<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</li>
<?php }?>
<?php
//widget：博客信息
function widget_bloginfo($title){
	global $sta_cache,$viewcount_day,$viewcount_all; ?>
	<li>
	<h3><span onclick="showhidediv('bloginfo')"><?php echo $title; ?></span></h3>
	<ul id="bloginfo">
	<li>日志数量：<?php echo $sta_cache['lognum']; ?></li>
	<li>评论数量：<?php echo $sta_cache['comnum']; ?></li>
	<li>引用数量：<?php echo $sta_cache['tbnum']; ?></li>
	<li>今日访问：<?php echo $viewcount_day; ?></li>
	<li>总访问量：<?php echo $viewcount_all; ?></li>
	</ul>
	</li>
<?php }?>
<?php
//blog：置顶
function topflg($istop){
	global $log_cache_sort; 
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
	global $log_cache_sort; ?>
	<?php if($log_cache_sort[$blogid]): ?>
	[<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $sort; ?>"><?php echo $log_cache_sort[$blogid]; ?></a>]
	<?php endif;?>
<?php }?>
<?php
//blog：文件附件
function blog_att($blogid){
	global $log_cache_atts; 
	$attachment = !empty($log_cache_atts[$blogid]) ? '文件附件：'.$log_cache_atts[$blogid] : '';
	echo $attachment;
}
?>
<?php
//blog：日志标签
function blog_tag($blogid){
	global $log_cache_tags; 
	if (!empty($log_cache_tags[$blogid]))
	{
		$tag = '标签:';
		foreach ($log_cache_tags[$blogid] as $value)
		{
			$tag .= "	<a href=\"".BLOG_URL."?tag=".$value['tagurl']."\">".$value['tagname'].'</a>';
		}
		echo $tag;
	}
}
?>
<?php
//blog：日志作者
function blog_author($uid){
	global $user_cache,$DB;
	$author = $user_cache[$uid]['name'];
	$mail = $user_cache[$uid]['mail'];
	$des = $user_cache[$uid]['des'];
	$title = !empty($mail) || !empty($des) ? "title=\"$des $mail\"" : '';
	echo "<a href=\"".BLOG_URL."?author=$uid\" $title>$author</a>";
}
?>
<?php
//blog：相邻日志
function neighbor_log(){
	global $prevLog,$nextLog; ?>
	<?php if($prevLog):?>
	&laquo; <a href="<?php echo BLOG_URL; ?>?post=<?php echo $prevLog['gid']; ?>"><?php echo $prevLog['title'];?></a>
	<?php endif;?>
	<?php if($nextLog && $prevLog):?>
		|
	<?php endif;?>
	<?php if($nextLog):?>
		 <a href="<?php echo BLOG_URL; ?>?post=<?php echo $nextLog['gid']; ?>"><?php echo $nextLog['title'];?></a>&raquo;
	<?php endif;?>
<?php }?>
<?php
//blog：引用通告
function blog_trackback(){
	global $allow_tb,$tbscode,$logid,$tb; ?>
	<?php if($allow_tb == 'y'):?>	
	<div id="trackback_address">
	<p>引用地址: <input type="text" style="width:350px" class="input" value="<?php echo BLOG_URL;?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>">
	<a name="tb"></a></p>
	</div>
	<?php endif; ?>
	<?php foreach($tb as $key=>$value):?>
		<ul id="trackback">
		<li><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a></li>
		<li>BLOG: <?php echo $value['blog_name'];?></li><li><?php echo $value['date'];?></li>
		</ul>
	<?php endforeach; ?>	
<?php }?>
<?php
//blog：博客评论列表
function blog_comments(){
	global $comments; ?>
	<?php if($comments): ?>
	<p class="comment"><b>评论：</b><a name="comment"></a></p>
	<?php endif; ?>
	<?php
	foreach($comments as $key=>$value):
	$reply = $value['reply']?"<span>博主回复：{$value['reply']}</span>":'';
	$value['poster'] = $value['url'] ? '<a href="'.$value['url'].'" target="_blank">'.$value['poster'].'</a>' : $value['poster'];
	?>
	<div id="com_line">
		<a name="<?php echo $value['cid']; ?>"></a>
		<b><?php echo $value['poster']; ?> </b>
		<div class="time"><?php echo $value['date']; ?></div>
		<div class="com_date">
		<?php echo $value['content']; ?>
		</div>
		<div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply; ?></div>
		<?php if(ROLE == 'admin'): ?>
			<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>','reply<?php echo $value['cid']; ?>')">回复</a>
			<div id='replybox<?php echo $value['cid']; ?>' style="display:none;">
			<textarea name="reply<?php echo $value['cid']; ?>" class="input" id="reply<?php echo $value['cid']; ?>" style="overflow-y: hidden;width:360px;height:50px;"><?php echo $value['reply']; ?></textarea>
			<br />
			<a href="javascript:void(0);" onclick="postinfo('<?php echo BLOG_URL; ?>admin/comment.php?action=doreply&cid=<?php echo $value['cid']; ?>&flg=1','reply<?php echo $value['cid']; ?>','replycomm<?php echo $value['cid']; ?>');">提交</a>
			<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>')">取消</a>
			</div>
		<?php endif; ?>
	</div>
	<?php endforeach; ?>
<?php }?>
<?php
//blog：发表评论表单
function blog_comments_post(){
	global $logid,$ckname,$ckmail,$ckurl,$cheackimg,$allow_remark; ?>
	<?php if($allow_remark == 'y'): ?>
	<p class="comment"><b>发表评论：</b><a name="comment"></a></p>
	<div class="comment_post">
	<form method="post"  name="commentform" action="<?php echo BLOG_URL; ?>index.php?action=addcom" id="commentform">
	<p>
	<input type="hidden" name="gid" value="<?php echo $logid; ?>"  size="22" tabindex="1"/>
	<input type="text" name="comname" maxlength="49" value="<?php echo $ckname; ?>"  size="22" tabindex="1">
	<label for="author"><small>昵称</small></label></p>
	<p>
	<input type="text" name="commail"  maxlength="128"  value="<?php echo $ckmail; ?>" size="22" tabindex="2"> 
	<label for="email"><small>邮件地址 (选填)</small></label></p>
	<p><input type="text" name="comurl" maxlength="128"  value="<?php echo $ckurl; ?>" size="22" tabindex="3">
	<label for="url"><small>个人主页 (选填)</small></label>
	</p>
	<p><textarea name="comment" id="comment"  rows="10" tabindex="4"></textarea></p>
	<p><div class="comment_yz"><?php echo $cheackimg; ?><input name="Submit" type="submit" id="comment_submit" value="发表评论" onclick="return checkform()" /></div></p>
	</form>
	</div>
	<?php endif; ?>
<?php }?>