<?php 
/*
* Sidebar widgets
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<?php
//widget:blogger
function widget_blogger($title){
	global $lang; 
	global $user_cache;
	$name = $user_cache[1]['mail'] != '' ? "<a href=\"mailto:".$user_cache[1]['mail']."\">".$user_cache[1]['name']."</a>" : $user_cache[1]['name'];?>
	<li>
	<h3><span onclick="showhidediv('bloggerinfo')"><?php echo $title; ?></span></h3>
	<ul style="text-align:center" id="bloggerinfo">
	<div id="bloggerinfoimg">
	<?php if (!empty($user_cache[1]['photo']['src'])): ?>
	<img src="<?php echo BLOG_URL.$user_cache[1]['photo']['src']; ?>" width="<?php echo $user_cache[1]['photo']['width']; ?>" height="<?php echo $user_cache[1]['photo']['height']; ?>" alt="blogger" />
	<?php endif;?>
	</div>
	<li><b><?php echo $name; ?></b></li>
	<li><?php echo $user_cache[1]['des']; ?></li>
	</ul>
	</li>
<?php }?>

<?php
//widget: Calendar
function widget_calendar($title){
	global $lang; 
	global $calendar_url; ?>
	<li>
	<h3><span onclick="showhidediv('calendar')"><?php echo $title; ?></span></h3>
	<div id="calendar">
	</div>
	<script>sendinfo('<?php echo $calendar_url; ?>','calendar');</script>
	</li>
<?php }?>

<?php
//widget: Tags
function widget_tag($title){
	global $lang; 
	global $tag_cache; ?>
	<li>
	<h3><span onclick="showhidediv('blogtags')"><?php echo $title; ?></span></h3>
	<ul id="blogtags">
	<li>
	<?php foreach($tag_cache as $value): ?>
		<span style="font-size:<?php echo $value['fontsize']; ?>pt; height:30px;">
		<a href="<?php echo BLOG_URL; ?>?tag=<?php echo $value['tagurl']; ?>" title="<?php echo $lang['blog_posts'];?>: <?php echo $value['usenum']; ?>"><?php echo $value['tagname']; ?></a></span>
	<?php endforeach; ?>
	</li>
	</ul>
	</li>
<?php }?>

<?php
//widget: Categories
function widget_sort($title){
	global $lang; 
	global $sort_cache; ?>
	<li>
	<h3><span onclick="showhidediv('blogsort')"><?php echo $title; ?></span></h3>
	<ul id="blogsort">
	<?php foreach($sort_cache as $value): ?>
	<li>
	<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
	<a href="<?php echo BLOG_URL; ?>rss.php?sort=<?php echo $value['sid']; ?>"><img align="absmiddle" src="<?php echo TEMPLATE_URL; ?>images/icon_rss.gif" alt="<? echo $lang['category_feed'];?>"/></a>
	</li>
	<?php endforeach; ?>
	</ul>
	</li>
<?php }?>

<?php
//widget: twitter
function widget_twitter($title){
	global $lang; 
	global $newtws_cache,$istwitter; ?>
	<li>
	<h3><span onclick="showhidediv('twitter')"><?php echo $title; ?></span></h3>
	<ul id="twitter">
	<?php foreach($newtws_cache as $value): ?>
	<li><?php echo $value['t']; ?><p><?php echo smartDate($value['date']); ?> </p></li>
	<?php endforeach; ?>
    <?php if ($istwitter == 'y') :?>
	<p style="text-align:right"><a href="<?php echo BLOG_URL . 't/'; ?>"><? echo $lang['more']; ?> &raquo;</a></p>
	<?php endif;?>
	</ul>
	</li>
<?php }?>

<?php
//widget: Music
function widget_music($title){
	global $lang; 
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
//widget: Latest comments
function widget_newcomm($title){
	global $lang; 
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
	<a href="<?php echo $url; ?>" title="<? echo $lang['blog_reply'];?>: <?php echo $value['reply']; ?>">
	<img src="<?php echo TEMPLATE_URL; ?>images/reply.gif" align="absmiddle"/>
	</a>
	<?php endif;?>
	<br /><a href="<?php echo $url; ?>"><?php echo $value['content']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</li>
<?php }?>

<?php
//widget: Latest Posts
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
//widget: Random Post
function widget_random_log($title){
	global $index_randlognum, $emBlog;
	if (!isset($emBlog))
	{
		require_once EMLOG_ROOT.'/model/class.blog.php';
		$emBlog = new emBlog();
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
//widget: Search
function widget_search($title){
	global $lang; 
?>
	<li>
	<h3><span onclick="showhidediv('logserch')"><?php echo $title; ?></span></h3>
	<ul id="logserch">
	<li>
	<form name="keyform" method="get" action="<?php echo BLOG_URL; ?>index.php">
	<input name="keyword"  type="text" value="" style="width:120px;"/>
	<input type="submit" id="logserch_logserch" value="<? echo $lang['do_search'];?>" onclick="return keyw()" />
	</form>
	</li>
	</ul>
	</li>
<?php } ?>

<?php
//widget: Archive
function widget_archive($title){
	global $lang;
	global $dang_cache;
?>
	<li>
	<h3><span onclick="showhidediv('record')"><?php echo $title; ?></span></h3>
	<ul id="record">
	<?php foreach($dang_cache as $value): ?>
	<li><a href="<?php echo BLOG_URL.$value['url']; ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
//2008年12月, 2008-12
$sep = mb_substr($value['record'],4,1);
$da = explode($sep,$value['record']);
$m = $lang['month_'.intval($da[1])].' '.$da[0];
?>
	<li><a href="./<?php echo $value['url']; ?>"><?php echo $m; ?> ( <?php echo $value['lognum']; ?> )</a></li>
	<?php endforeach; ?>
	</ul>
	</li>
<?php } ?>

<?php
//widget: Custom Component
function widget_custom_text($title, $content, $id){ ?>
	<li>
	<h3><span onclick="showhidediv('<?php echo $id; ?>')"><?php echo $title; ?></span></h3>
	<ul id="<?php echo $id; ?>">
	<li><?php echo $content; ?></li>
	</ul>
	</li>
<?php } ?>

<?php
//widget: Links
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
//widget: Statistics
function widget_bloginfo($title){
	global $lang; 
	global $sta_cache,$viewcount_day,$viewcount_all; ?>
	<li>
	<h3><span onclick="showhidediv('bloginfo')"><?php echo $title; ?></span></h3>
	<ul id="bloginfo">
	<li><?php echo $lang['number_of_posts'];?>: <?php echo $sta_cache['lognum']; ?></li>
	<li><?php echo $lang['number_of_comments'];?>: <?php echo $sta_cache['comnum']; ?></li>
	<li><?php echo $lang['number_of_trackbacks'];?>: <?php echo $sta_cache['tbnum']; ?></li>
	<li><?php echo $lang['visits_today'];?>: <?php echo $viewcount_day; ?></li>
	<li><?php echo $lang['visits_total'];?>: <?php echo $viewcount_all; ?></li>
	</ul>
	</li>
<?php }?>

<?php
//blog: Top Blog Flag
function topflg($istop){
	global $lang;
	global $log_cache_sort;
	$topflg = $istop == 'y' ? "<img src=\"".TEMPLATE_URL."/images/import.gif\" align=\"absmiddle\"  title=\"{$lang['post_recommend']}\" /> " : '';
	echo $topflg;
}
?>

<?php
//blog: Edit
function editflg($logid,$author){
	global $lang;
	$editflg = ROLE == 'admin' || $author == UID ? '<a href="'.BLOG_URL.'admin/write_log.php?action=edit&gid='.$logid.'">'.$lang['edit'].'</a>' : '';
	echo $editflg;
}
?>

<?php
//blog: Categories
function blog_sort($sort, $blogid){
	global $log_cache_sort; ?>
	<?php if(@$log_cache_sort[$blogid]): ?>
	[<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $sort; ?>"><?php echo $log_cache_sort[$blogid]; ?></a>]
	<?php endif;?>
<?php }?>

<?php
//blog: Attachments
function blog_att($blogid){
	global $lang;
	global $log_cache_atts;
	$att = '';
	if(!empty($log_cache_atts[$blogid])){
		$att .= $lang['attachments']. ': ';
		foreach($log_cache_atts[$blogid] as $val){
			$att .= '<br /><a href="'.BLOG_URL.$val['url'].'" target="_blank">'.$val['filename'].'</a> '.$val['size'];
		}
	}
	echo $att;
}
?>

<?php
//blog: Blog Tags
function blog_tag($blogid){
	global $lang;
	global $log_cache_tags;
	if (!empty($log_cache_tags[$blogid]))
	{
		$tag = $lang['tags'].':';
		foreach ($log_cache_tags[$blogid] as $value)
		{
			$tag .= "	<a href=\"".BLOG_URL."?tag=".$value['tagurl']."\">".$value['tagname'].'</a>';
		}
		echo $tag;
	}
}
?>

<?php
//blog: Blog Author
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
//blog: Nearest Posts
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
//blog: Trackbacks
function blog_trackback(){
	global $lang;
	global $allow_tb,$tbscode,$logid,$tb; ?>
	<?php if($allow_tb == 'y'):?>
	<div id="trackback_address">
	<p><? echo $lang['trackback_address'];?>: <input type="text" style="width:350px" class="input" value="<?php echo BLOG_URL;?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>">
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
//blog: Blog Comment List
function blog_comments(){
	global $lang; 
	global $comments; ?>
	<?php if($comments): ?>
	<p class="comment"><b><? echo $lang['comments'];?>:</b><a name="comment"></a></p>
	<?php endif; ?>
	<?php
	foreach($comments as $key=>$value):
	$reply = $value['reply']?"<span>".$lang['blog_reply'].": {$value['reply']}</span>":'';
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
			<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>','reply<?php echo $value['cid']; ?>')"><? echo $lang['reply'];?></a>
			<div id='replybox<?php echo $value['cid']; ?>' style="display:none;">
			<textarea name="reply<?php echo $value['cid']; ?>" class="input" id="reply<?php echo $value['cid']; ?>" style="overflow-y: hidden;width:360px;height:50px;"><?php echo $value['reply']; ?></textarea>
			<br />
			<a href="javascript:void(0);" onclick="postinfo('<?php echo BLOG_URL; ?>admin/comment.php?action=doreply&cid=<?php echo $value['cid']; ?>&flg=1','reply<?php echo $value['cid']; ?>','replycomm<?php echo $value['cid']; ?>');"><? echo $lang['submit'];?></a>
			<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>')"><? echo $lang['cancel'];?></a>
			</div>
		<?php endif; ?>
	</div>
	<?php endforeach; ?>
<?php }?>

<?php
//blog: Comment form
function blog_comments_post(){
	global $lang;
	global $logid,$ckname,$ckmail,$ckurl,$cheackimg,$allow_remark; ?>
	<?php if($allow_remark == 'y'): ?>
	<p class="comment"><b><? echo $lang['comment'];?>:</b><a name="comment"></a></p>
	<div class="comment_post">
	<form method="post"  name="commentform" action="<?php echo BLOG_URL; ?>index.php?action=addcom" id="commentform">
	<p>
	<input type="hidden" name="gid" value="<?php echo $logid; ?>"  size="22" tabindex="1"/>
	<input type="text" name="comname" maxlength="49" value="<?php echo $ckname; ?>"  size="22" tabindex="1">
	<label for="author"><small><? echo $lang['nickname'];?></small></label></p>
	<p>
	<input type="text" name="commail"  maxlength="128"  value="<?php echo $ckmail; ?>" size="22" tabindex="2">
	<label for="email"><small><? echo $lang['email_address'].' ('.$lang['optional'].')';?></small></label></p>
	<p><input type="text" name="comurl" maxlength="128"  value="<?php echo $ckurl; ?>" size="22" tabindex="3">
	<label for="url"><small><? echo $lang['your_homepage'].' ('.$lang['optional'].')';?></small></label>
	</p>
	<p><textarea name="comment" id="comment"  rows="10" tabindex="4"></textarea></p>
	<p><div class="comment_yz"><?php echo $cheackimg; ?><input type="submit" id="comment_submit" value="<? echo $lang['comment_add'];?>" onclick="return checkform()" /></div></p>
	</form>
	</div>
	<?php endif; ?>
<?php }?>