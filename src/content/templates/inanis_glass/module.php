<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<?php
//widget：blogger
function widget_blogger($title){
	global $user_cache; 
	$name = $user_cache[1]['mail'] != '' ? "<a href=\"mailto:".$user_cache[1]['mail']."\">".$user_cache[1]['name']."</a>" : $user_cache[1]['name'];?>
	<div class="sidebar-top"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
  	<div class="sidebar-mid">
    <h3><?php echo $title;?></h3>
    <ul style="text-align:center;margin-right:10px;" id="bloggerinfo">
	<div id="bloggerinfoimg">
	<?php if (!empty($user_cache[1]['photo']['src'])): ?>
	<img src="<?php echo $user_cache[1]['photo']['src']; ?>" width="<?php echo $user_cache[1]['photo']['width']; ?>" height="<?php echo $user_cache[1]['photo']['height']; ?>" alt="blogger" />
	<?php endif;?>
	</div>
	<li><b><?php echo $name; ?></b></li>
		<li><span id="bloggerdes"><?php echo $user_cache[1]['des']; ?></span>
		<?php if(ROLE == 'admin'): ?>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
		<img src="<?php echo CERTEMPLATE_URL; ?>/images/modify.gif" align="absmiddle" alt="修改我的状态"/></a></li>
		<li id='modbdes' style="display:none;">
		<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:170px;height:60px;"><?php echo $user_cache[1]['des']; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('./admin/blogger.php?action=update&flg=1','bdes','bloggerdes');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
		<?php endif; ?>
		</li>
	</ul>
  </div>
  <div class="sidebar-bottom"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
<?php }?>
<?php
//widget：calendar
function widget_calendar($title){
	global $calendar_url; ?>
	<div class="sidebar-top"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
  	<div class="sidebar-mid">
	<h3><?php echo $title; ?></h3>
	<div id="calendar">
	</div>
	<script>sendinfo('<?php echo $calendar_url; ?>','calendar');</script>
	</div>
  <div class="sidebar-bottom"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
<?php }?>
<?php
//widget：tag
function widget_tag($title){
	global $tag_cache; ?>
	<div class="sidebar-top"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
  	<div class="sidebar-mid">
	<h3><?php echo $title; ?></h3>
	<ul>
	<?php foreach($tag_cache as $value): ?>
		<a href="./?tag=<?php echo $value['tagurl']; ?>" style="font-size:<?php echo $value['fontsize']; ?>pt;"title="<?php echo $value['usenum']; ?> topic<?php if($value['usenum'] > 1) echo "s"; ?>"><?php echo $value['tagname']; ?></a>
	<?php endforeach; ?>
	</ul>
	</div>
  <div class="sidebar-bottom"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
<?php }?>
<?php
//widget：sort
function widget_sort($title){
	global $sort_cache; ?>
	<div class="sidebar-top"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
  	<div class="sidebar-mid">
	<h3><?php echo $title; ?></h3>
	<ul>
	<?php foreach($sort_cache as $value): ?>
	<li>
	<a href="./?sort=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
	<a href="./rss.php?sort=<?php echo $value['sid']; ?>"><img align="absmiddle" src="<?php echo CERTEMPLATE_URL; ?>/images/icon_rss.gif" alt="RSS Feed for this Categorie"/></a>
	</li>
	<?php endforeach; ?>
	</ul>
	</div>
  <div class="sidebar-bottom"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
<?php }?>
<?php
//widget：twitter
function widget_twitter($title){
	global $tw_cache,$index_twnum,$localdate; ?>
	<?php if($index_twnum>0): ?>
	<div class="sidebar-top"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
  	<div class="sidebar-mid">
		<h3><?php echo $title; ?></h3>
		<ul id="twitter">
		<?php
		if(isset($tw_cache) && is_array($tw_cache)):
		$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('./twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
		foreach (array_slice($tw_cache,0,$index_twnum) as $value):
		$delbt = ROLE == 'admin'?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
		$value['date'] = smartyDate($localdate,$value['date']);
		?>
		<li> <?php echo $value['content']; ?> <?php echo $delbt; ?><br><span><?php echo $value['date']; ?></span></li>
		<?php endforeach;?>
		<?php echo $morebt;?>
		<?php endif;?>
		</ul>
		<?php if(ROLE == 'admin'): ?>
		<ul>
		<p><a href="javascript:void(0);" onclick="showhidediv('addtw','tw')">我要唠叨</a></p>
		<li id='addtw' style="display: none;">
		<textarea name="tw" id="tw" style="overflow-y: hidden;width:170px;height:70px;" class="input"></textarea>
		<p>
		<a href="javascript:void(0);" onclick="postinfo('./twitter.php?action=add','tw','twitter');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('addtw')">取消</a>
		</p>
		</li>
		</ul>
		<?php endif;?>
	</div>
  <div class="sidebar-bottom"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
	<?php endif;?>
<?php } ?>
<?php 
//widget：music
function widget_music($title){
	global $musicdes,$musicurl,$autoplay; ?>
	<div class="sidebar-top"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
  	<div class="sidebar-mid">
	<h3><?php echo $title; ?></h3>	
	<ul>
	<li><?php echo $musicdes; ?><object type="application/x-shockwave-flash" data="<?php echo CERTEMPLATE_URL; ?>/images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" width="170" height="18"><param name="movie" value="<?php echo CERTEMPLATE_URL; ?>/images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" /></object>
	</li>
	</ul>
	</div>
  <div class="sidebar-bottom"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
<?php }?>
<?php
//widget：new comments
function widget_newcomm($title){
	global $com_cache; ?>
	<div class="sidebar-top"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
  	<div class="sidebar-mid">
	<h3><?php echo $title; ?></h3>
	<ul>
	<?php 
	foreach($com_cache as $value): 
	$value['url'] = $value['url'];
	?>
	<li id="comment"><?php echo $value['name']; ?> 
	<?php if($value['reply']): ?>
	<a href="<?php echo $value['url']; ?>" title="博主回复：<?php echo $value['reply']; ?>">
	<img src="<?php echo CERTEMPLATE_URL; ?>/images/reply.gif" align="absmiddle"/>
	</a>
	<?php endif;?>
	<br /><a href="<?php echo $value['url']; ?>"><?php echo $value['content']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</div>
  <div class="sidebar-bottom"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
<?php }?>
<?php
//widget：new posts
function widget_newlog($title){
	global $newLogs_cache; ?>
	<div class="sidebar-top"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
  	<div class="sidebar-mid">
	<h3><?php echo $title; ?></h3>
	<ul>
	<?php foreach($newLogs_cache as $value): ?>
	<li><a href="./?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</div>
  <div class="sidebar-bottom"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
<?php }?>
<?php
//widget：random posts
function widget_random_log($title){
	global $index_randlognum, $emBlog;
	if (!isset($emBlog))
	{
		global $DB;
		require_once(EMLOG_ROOT.'/model/C_blog.php');
		$emBlog = new emBlog($DB);
	}
	$randLogs = $emBlog->getRandLog($index_randlognum);?>
	<div class="sidebar-top"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
  	<div class="sidebar-mid">
	<h3><?php echo $title; ?></h3>
	<ul>
	<?php foreach($randLogs as $value): ?>
	<li><a href="./?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</div>
  <div class="sidebar-bottom"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
<?php }?>
<?php
//widget：search
function widget_search($title){ ?>
	<div class="sidebar-top"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
  	<div class="sidebar-mid">
	<ul><li>
	<form method="get" name="keyform" id="searchform" action="<?php echo BLOG_URL; ?>">
  	<div class="search-form">
    <input onfocus="SearchBoxFocus();" onblur="SearchBoxBlur();" id="searchbox1" type="text" name="keyword" class="search-text"/><input type="submit" id="searchsubmit" value="" class="search-submit" />
  	</div>
	</form></li>
	</ul>
	</div>
  <div class="sidebar-bottom"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
<?php } ?>
<?php
//widget：archive
function widget_archive($title){
	global $dang_cache; ?>
	<div class="sidebar-top"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
  	<div class="sidebar-mid">
	<h3><?php echo $title; ?></h3>
	<ul>
	<?php foreach($dang_cache as $value): ?>
	<li><a href="./<?php echo $value['url']; ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
	<?php endforeach; ?>
	</ul>
	</div>
  <div class="sidebar-bottom"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
<?php } ?>
<?php
//widget：custom widgets
function widget_custom_text($title, $content, $id){ ?>
	<div class="sidebar-top"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
  	<div class="sidebar-mid">
	<h3><?php echo $title; ?></h3>
	<ul id="<?php echo $id; ?>">
	<?php echo $content; ?>
	</ul>
	</div>
  <div class="sidebar-bottom"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
<?php } ?>
<?php
//widget：links
function widget_link($title){
	global $link_cache; ?>
	<div class="sidebar-top"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
  	<div class="sidebar-mid">
	<h3><?php echo $title; ?></h3>
	<ul>
	<?php foreach($link_cache as $value): ?>     	
	<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
	<?php endforeach; ?>
	</ul>
	</div>
  <div class="sidebar-bottom"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
<?php }?>
<?php
//widget：bloginfo
function widget_bloginfo($title){
	global $sta_cache,$viewcount_day,$viewcount_all; ?>
	<div class="sidebar-top"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
  	<div class="sidebar-mid">
	<h3><?php echo $title; ?></h3>
	<ul>
	<li>日志数量：<?php echo $sta_cache['lognum']; ?></li>
	<li>评论数量：<?php echo $sta_cache['comnum']; ?></li>
	<li>引用数量：<?php echo $sta_cache['tbnum']; ?></li>
	<li>今日访问：<?php echo $viewcount_day; ?></li>
	<li>总访问量：<?php echo $viewcount_all; ?></li>
	</ul>
	</div>
  <div class="sidebar-bottom"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
<?php }?>
<?php
//blog：edit
function editflg($logid,$author){
	$editflg = ROLE == 'admin' || $author == UID ? '<a href="'.'./admin/write_log.php?action=edit&gid='.$logid.'">编辑</a>' : '';
	echo $editflg;
}
?>
<?php 
//blog：sort
function blog_sort($sort, $blogid){
	global $log_cache_sort; ?>
	<?php if($log_cache_sort[$blogid]): ?>
	<strong>分类:</strong>	<a href="./?sort=<?php echo $sort; ?>"><?php echo $log_cache_sort[$blogid]; ?></a><br />
	<?php endif;?>
<?php }?>
<?php
//blog：attach
function blog_att($blogid){
	global $log_cache_atts; 
	$attachment = !empty($log_cache_atts[$blogid]) ? '<strong>附件：<strong>'.$log_cache_atts[$blogid] : '';
	echo $attachment;
}
?>
<?php
//blog：tag
function blog_tag($blogid){
	global $log_cache_tags; 
	if (!empty($log_cache_tags[$blogid]))
	{
?>
<strong>标签:</strong>
<?php
		foreach ($log_cache_tags[$blogid] as $value)
		{
			echo "	<a href=\"./?tag=".$value['tagurl']."\">".$value['tagname'].'</a>';
		}
?>
<br />
<?php
	}
}
?>
<?php
//blog：author
function blog_author($uid){
	global $user_cache,$DB;
	$author = $user_cache[$uid]['name'];
	$mail = $user_cache[$uid]['mail'];
	$des = $user_cache[$uid]['des'];
	$title = !empty($mail) || !empty($des) ? "title=\"$des $mail\"" : '';
	echo "<a href=\"./?author=$uid\" $title>$author</a>";
}
?>
<?php
//blog：neighbor log
function neighbor_log(){
	global $prevLog,$nextLog; ?>
	<div style="float:right;width:660px;">
	<div class="navigation">
	<?php if($prevLog):?>
	<div class="alignleft"><a href="./?post=<?php echo $prevLog['gid']; ?>" title="<?php echo $prevLog['title'];?>"><img style="vertical-align:middle;" src="<?php echo CERTEMPLATE_URL; ?>/images/arbk.png" alt="<?php echo $prevLog['title'];?>" />上一篇</a>
	</div>
	<?php endif;?>
	<div class="alignright">
	<?php if($nextLog):?>
	<a href="./?post=<?php echo $nextLog['gid']; ?>" title="<?php echo $nextLog['title'];?>">下一篇<img style="vertical-align:middle;" src="<?php echo CERTEMPLATE_URL; ?>/images/arfw.png" alt="<?php echo $nextLog['title'];?>"></a>
	</div>
	<?php endif;?>
	</div>
	</div><br /><br /><br />
<?php }?>
<?php
//page: comment
function blog_comment(){
	global $comments,$logid,$ckname,$ckmail,$ckurl,$cheackimg,$allow_remark,$user_cache;
	$oddcomment = 'alt';
?>
	<div class="postcont">
	<div class="alignright">
	<div class="PTtop"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
	<div class="PTbar">
	<div class="PT PTds"><span class="ptblurl">&nbsp;</span><h3>评论 &raquo; (<?php echo count($comments);?>)</h3><span class="ptblurr">&nbsp;</span></div>
	</div>
	<div class="PTbtm"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
	<div class="p1">
	<a name="comment"></a>
	<?php
	if ($comments) : ?>
	<ol class="commentlist" id="singlecomments">
	<?php foreach ($comments as $value) : ?> 
	<li id="comment-<?php echo $value['cid']; ?>"> 
	<span class="avatar"><img src='<?php echo CERTEMPLATE_URL; ?>/images/avatar.bmp' class='avatar avatar-48 photo' height='48' width='48' /></span>
	<div class="commentbox <?php echo $oddcomment; ?>">
	<a name="<?php echo $value['cid']; ?>"></a>
	<span class="commentauthor">
		<?php if($value['url']):?>
			<a href="<?php echo $value['url']; ?>" target="_blank"><?php echo $value['poster']; ?></a>
		<?php else:?>
			<?php echo $value['poster']; ?>
		<?php endif;?>
		说:
		<?php if($value['mail']):?>
			<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
		<?php endif;?>
	</span><br />
	<span class="comment-time"><?php echo $value['date']; ?></span>
	<?php echo $value['content']; ?>                  
	</div>
	</li>
	<?php /* Changes every other comment to a different class */
 		if ('greybox' == $oddcomment) $oddcomment = 'alt';
		else $oddcomment = 'greybox';
	?> 
	<?php if($value['reply']):
		if(isset($user_cache[1]['photo']['src']))
		{
			$imgsrc = $user_cache[1]['photo']['src'];
			$imgtn = chImageSize($imgsrc,48,48);
			$width = $imgtn['w'];
			$height = $imgtn['h'];
		}else{
			$imgsrc = CERTEMPLATE_URL."/images/avatar.bmp";
			$width = 48;
			$height = 48;
		}
		?>
	<li id="comment-reply-<?php echo $value['cid']; ?>"> 
	<span class="avatar"><img src='<?php echo $imgsrc; ?>' class='avatar avatar-48 photo' height='<?php echo $height;?>' width='<?php echo $width;?>' /></span>
	<div class="commentbox <?php echo $oddcomment; ?>">
	<span class="commentauthor">
		回复 <?php echo $value['poster']; ?>:
	</span><br />
	<?php echo $value['reply']; ?>                  
	</div>
	</li>
	<?php /* Changes every other comment to a different class */
 		if ('greybox' == $oddcomment) $oddcomment = 'alt';
		else $oddcomment = 'greybox';
		endif;
	?>
	<?php endforeach; /* end for each comment */ ?>
	</ol>
	<div>
	<div style="clear:both;"></div>
	</div>
	<?php else : // this is displayed if there are no comments so far ?>
	<?php if ($allow_remark == 'n') :?>
	<p class="nocomments" style="text-align:center;margin:35px 0 35px 0;">这篇日志的评论功能已关闭</p>
	<?php
	 	endif;
    endif;
    if ($allow_remark == 'y') : 
    
    // show the form
    ?>
	<div id="respond"><h3>发表评论</h3>
	<form action="./index.php?action=addcom" name="commentform" method="post" id="commentform">
	<p><input type="text" name="comname" id="author" value="<?php echo $ckname; ?>" size="22" tabindex="1" />
	<label for="author">昵称</label></p>
	<p><input type="text" name="commail" id="email" value="<?php echo $ckmail; ?>" size="22" tabindex="2" />
	<label for="email">邮箱地址(选填)</label></p>
	<p><input type="text" name="comurl" id="url" value="<?php echo $ckurl; ?>" size="22" tabindex="3" />
	<label for="url">个人主页(选填)</label></p>
	<input type="hidden" name="gid" value="<?php echo $logid; ?>"  size="22"/>
 	<p><textarea name="comment" id="comment" cols="50%" rows="10" tabindex="4" class="form-textarea"></textarea></p>
	<p><?php echo $cheackimg; ?><input name="submit" type="submit" id="submit" tabindex="5" value="发表评论" class="form-submit"  onclick="return checkform()"/></p>
	</form>
	</div>
	<?php 
    endif;?>
	</div>
	<div class="PFbtm"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
	</div>
</div>
<?php }?>
<?php
//blog: response
function blog_response(){
	global $comments,$logid,$ckname,$ckmail,$ckurl,$cheackimg,$allow_remark,$user_cache,$allow_tb,$tbscode,$tb;
	$oddcomment = 'alt';
?>
	<div class="postcont">
	<div class="alignright">
	<div class="PTtop"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
	<div class="PTbar">
	<div class="PT PTds"><span class="ptblurl">&nbsp;</span><h3><a name="comments"></a>评论及引用 &raquo; (<?php echo count($comments)+count($tb);?>)</h3><span class="ptblurr">&nbsp;</span></div>
	</div>
	<div class="PTbtm"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
	<div class="p1">
	<ol class="commentlist" id="singlecomments">
	
	<a name="comment"></a>
	<?php 
	//comments
	foreach ($comments as $value) : ?> 
	<li id="comment-<?php echo $value['cid']; ?>"> 
	<span class="avatar"><img src='<?php echo CERTEMPLATE_URL; ?>/images/avatar.bmp' class='avatar avatar-48 photo' height='48' width='48' /></span>
	<div class="commentbox <?php echo $oddcomment; ?>">
	<a name="<?php echo $value['cid']; ?>"></a>
	<span class="commentauthor">
		<?php if($value['url']):?>
			<a href="<?php echo $value['url']; ?>" target="_blank"><?php echo $value['poster']; ?></a>
		<?php else:?>
			<?php echo $value['poster']; ?>
		<?php endif;?>
		说:
		<?php if($value['mail']):?>
			<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
		<?php endif;?>
	</span><br />
	<span class="comment-time"><?php echo $value['date']; ?></span>
	<?php echo $value['content']; ?>                  
	</div>
	</li>
	<?php /* Changes every other comment to a different class */
 		if ('greybox' == $oddcomment) $oddcomment = 'alt';
		else $oddcomment = 'greybox';
	?> 
	<?php if($value['reply']):
		if(isset($user_cache[1]['photo']['src']))
		{
			$imgsrc = $user_cache[1]['photo']['src'];
			$imgtn = chImageSize($imgsrc,48,48);
			$width = $imgtn['w'];
			$height = $imgtn['h'];
		}else{
			$imgsrc = CERTEMPLATE_URL."/images/avatar.bmp";
			$width = 48;
			$height = 48;
		}
		?>
	<li id="comment-reply-<?php echo $value['cid']; ?>"> 
	<span class="avatar"><img src='<?php echo $imgsrc; ?>' class='avatar avatar-48 photo' height='<?php echo $height;?>' width='<?php echo $width;?>' /></span>
	<div class="commentbox <?php echo $oddcomment; ?>">
	<span class="commentauthor">
		回复 <?php echo $value['poster']; ?>:
	</span><br />
	<?php echo $value['reply']; ?>                  
	</div>
	</li>
	<?php /* Changes every other comment to a different class */
 		if ('greybox' == $oddcomment) $oddcomment = 'alt';
		else $oddcomment = 'greybox';
		endif;
	?>
	<?php endforeach; /* end for each comment */ ?>

	<a name="tb"></a>
	<?php
	//trackbacks
	foreach ($tb as $value) : ?> 
	<li class="trackback odd alt thread-odd thread-alt depth-1" id="trackback-<?php echo $value['tbid']; ?>">
	<div id="div-trackback-<?php echo $value['tbid']; ?>">
	<div class="comment-author vcard">
	<cite class="fn">
		<a href="<?php echo $value['url'];?>"  rel="external nofollow" class="url"><?php echo $value['blog_name'];?></a>
	</cite> 
		<span class="says">说:</span>
	</div>
		<div class="comment-meta commentmetadata"><?php echo $value['date']; ?></div>
		<p><strong><?php echo $value['title'];?></strong></p>
		<p><?php echo $value['excerpt']; ?></p>
		</div>
	</li>
	<?php /* Changes every other comment to a different class */
 		if ('greybox' == $oddcomment) $oddcomment = 'alt';
		else $oddcomment = 'greybox';
	?>
	<?php endforeach; /* end for each trackback */ ?>
	</ol>
	<div>
	<div style="clear:both;"></div>
	</div>
	<?php
    if ($allow_remark == 'y') : 
      // show the form
    ?>
	<div id="respond"><h3>发表评论</h3>
	<form action="./index.php?action=addcom" name="commentform" method="post" id="commentform">
	<p><input type="text" name="comname" id="author" value="<?php echo $ckname; ?>" size="22" tabindex="1" />
	<label for="author">昵称</label></p>
	<p><input type="text" name="commail" id="email" value="<?php echo $ckmail; ?>" size="22" tabindex="2" />
	<label for="email">邮箱地址(选填)</label></p>
	<p><input type="text" name="comurl" id="url" value="<?php echo $ckurl; ?>" size="22" tabindex="3" />
	<label for="url">个人主页(选填)</label></p>
	<input type="hidden" name="gid" value="<?php echo $logid; ?>"  size="22"/>
 	<p><textarea name="comment" id="comment" cols="50%" rows="10" tabindex="4" class="form-textarea"></textarea></p>
	<p><?php echo $cheackimg; ?><input name="submit" type="submit" id="submit" tabindex="5" value="发表评论" class="form-submit"  onclick="return checkform()"/></p>
	</form>
	</div>
	<?php 
    endif;?>
	<div>
	<div style="clear:both;"></div>
	</div>
	</div>
	<div class="PFtop"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
  <div class="PFpst">
    <span class="tagstyle spanchunk">
      <img class="tagicon" src="<?php echo CERTEMPLATE_URL; ?>/images/feed_50.png" alt=" " />
      <strong>引用通告:</strong><br />
      <?php if ($allow_tb == 'y') : ?> 
        <a href="<?php echo BLOG_URL;?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>" rel="trackback" title="复制引用通告地址以引用此日志">TrackBack <abbr title="统一标识符">URI</abbr></a> 
      <?php endif; ?>
    </span>
  </div>
	<div class="PFbtm"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
	</div>
</div>
<?php }?>
<?php
//default theme
function default_stylesheet(){
	include getViews('options');
	switch ($DefaultTheme) {
  case 1:
      $ds = "";
      break;
  case 2:
      $ds = "life-theme";
      break;
  case 3:
      $ds = "earth-theme";
      break;
  case 4:
      $ds = "wind-theme";
      break;
  case 5:
      $ds = "water-theme";
      break;
  case 6:
      $ds = "fire-theme";
      break;
  case 7:
      $ds = "lite-theme";
      break;
  default:
      $ds = "";
      break;
  }
  
  switch ($ManualOrRandom){
  case "manual":
      $mor = "manual";
      break;
  case "random":
      $mor = "random";
      break;
  default:
      $mor = "manual";
      break;
  }
  
  ?>
    <script type="text/javascript">
      var defaultstyle = "<?php echo $ds; ?>";
      var manual_or_random = "<?php echo $mor; ?>";
    </script>
  <?php
}
?>
<?php
//theme
function insert_stylemenu(){
	include getViews('options');
?>
	<div class="SMRtOptsFl SMsh" onclick="FlyOutWasClicked=1;" id="SMSub5">
	<div class="SMRtFlHd">选择主题...</div>
	<ul class="SMRtFlOpt">
	<li title="神秘的黑暗。" onclick="chooseStyle('none', 30)"><img class="switchbutton voidb" src="<?php echo CERTEMPLATE_URL; ?>/images/void-button.png" alt="Void" title="Void" />空洞 <?php if ($DefaultTheme==1):?><span style="font-size:12px">&laquo; 默认</span><?php endif;?></li>
	<li title="绿色的小生命" onclick="chooseStyle('life-theme', 30)"><img class="switchbutton lifeb" src="<?php echo CERTEMPLATE_URL; ?>/images/life-button.png" alt="Life" title="Life" />生机 <?php if ($DefaultTheme==2):?><span style="font-size:12px">&laquo; 默认</span><?php endif;?></li>
	<li title="神奇的地球红岩" onclick="chooseStyle('earth-theme', 30)"><img class="switchbutton earthb" src="<?php echo CERTEMPLATE_URL; ?>/images/earth-button.png" alt="Earth" title="Earth" />地球 <?php if ($DefaultTheme==3):?><span style="font-size:12px">&laquo; 默认</span><?php endif;?></li>
	<li title="来自天空的声音" onclick="chooseStyle('wind-theme', 30)"><img class="switchbutton windb" src="<?php echo CERTEMPLATE_URL; ?>/images/wind-button.png" alt="Wind" title="Wind" />轻风 <?php if ($DefaultTheme==4):?><span style="font-size:12px">&laquo; 默认</span><?php endif;?></li>
	<li title="深蓝是它的象征" onclick="chooseStyle('water-theme', 30)"><img class="switchbutton waterb" src="<?php echo CERTEMPLATE_URL; ?>/images/water-button.png" alt="Water" title="Water" />大海 <?php if ($DefaultTheme==5):?><span style="font-size:12px">&laquo; 默认</span><?php endif;?></li>
	<li title="肆虐的燃烧" onclick="chooseStyle('fire-theme', 30)"><img class="switchbutton fireb" src="<?php echo CERTEMPLATE_URL; ?>/images/fire-button.png" alt="Fire" title="Fire" />火焰 <?php if ($DefaultTheme==6):?><span style="font-size:12px">&laquo; 默认</span><?php endif;?></li>
	<li title="简洁的力量" onclick="chooseStyle('lite-theme', 30)"><img class="switchbutton liteb" src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt="Light" title="Light" />明亮 <?php if ($DefaultTheme==7):?><span style="font-size:12px">&laquo; 默认</span><?php endif;?></li>
	</ul>
	</div>
<?php }?>
<?php
//time style
function time_style(){
	include getViews('options');
?>
    <script type="text/javascript">
      var timestyle = <?php echo $TimeStyle; ?>;
    </script>
<?php
}
?>
<?php
//Latest 50 posts
function latest_posts()
{
	global $DB;
	$sql = "SELECT gid,title FROM ".DB_PREFIX."blog WHERE type='blog' AND hide='n' ORDER BY date DESC LIMIT 50";
	$query = $DB->query($sql);
	while($row = $DB->fetch_array($query))
	{
?>
	<li>
	<a href="./?post=<?php echo $row['gid']; ?>"><?php echo htmlspecialchars(trim($row['title']));?></a>
	</li>
<?php
	}
}
?>
<?php
//About this entry
function about()
{
	global $logid,$tb,$comments,$log_cache_sort,$sort,$author,$log_title,$date,$allow_tb;
?>
<!-- About This Entry -->
  <?php if($logid) { ?>
  <div class="sidebar-top"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
  <div class="sidebar-mid">
    <h3>关于这篇文章</h3>
    <p>&raquo; <b>标题:</b> <a href="./?post=<?php echo $logid; ?>" title="Permanent Link: <?php echo $log_title; ?>"><?php echo $log_title; ?></a><br />&raquo; <b>时间:</b> <?php echo date('F jS, Y',$date); ?><br />&raquo; <b>作者:</b> <?php blog_author($author); ?><br />
      	<?php
  		if($log_cache_sort[$logid]):
  		?>
      &raquo; <b>分类:</b> <a href="./?sort=<?php echo $sort; ?>"><?php echo $log_cache_sort[$logid]; ?></a></p>
      	<?php endif;?>
     <?php $responsenum = count($tb)+count($comments);
        switch($responsenum)
        {
        	case 0:$response = "一个评论都没有";break;
        	case 1:$response = "只有一个评论";break;
        	default:$response = "共有 $responsenum 个评论";break;
        }
      ?>
    <p>&raquo; <?php echo $response;?></p>
    <p>&raquo;  查看 <a href="#comments">评论</a><?php if($tb):?>或者<a href="#tb">引用</a><?php endif;?></p>
    <?php if($allow_tb == 'y'):?>
    <p><span id="trackback">&raquo; 
    <a href="<?php echo BLOG_URL;?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>" title="复制引用通告地址以引用此日志" rel="nofollow">引用</a></span></p>
    <?php endif;?>
  </div>
  <div class="sidebar-bottom"><img src="<?php echo CERTEMPLATE_URL; ?>/images/1pxtrans.gif" alt=" " /></div>
<?php
}
}
?>
<?php
//footer: category
function cats_insert (){
	include getViews('options');
	if($MenuOption == 1)
	{
		global $sort_cache,$navibar;
		$kid = count($navibar);
		foreach($sort_cache as $key => $value)
		{
			if($MenuKids == 1)
			{
				$kid++;
				$mover = 'onmouseover="mhov('.$value['sid'].','.$kid.')" ';
   		     	$mout = 'onmouseout="munhov()"';
   	    	}else{
   		     	$mover = $mout = '';
    	    }
     	   	$cla = 'class="cat-item cat-item-'.$key;
       	 	if(isset($_GET['sort']) && $_GET['sort'] == $value['sid'])
       	 		$cla .= ' current_page_item_tb';
        	$cla .= '"';
?>
		<li <?php echo $mover;?> <?php echo $mout;?> <?php echo $cla;?>><a href="./?sort=<?php echo $value['sid']; ?>" title="<?php echo $value['sortname']; ?>"><?php echo $value['sortname']; ?></a></li>
<?php
		}
	}
}
?>
<?php
//footer: kids
function insert_kids()
{
	include getViews('options');
	if($MenuKids == 1 && $MenuOption == 1)
	{
		global $sort_cache,$navibar,$DB;
		$navnum = count($navibar);
		echo ('<div style="position:fixed;bottom:33px;left:0;">');
		foreach($sort_cache as $key => $value)
		{
?>
		<div onmouseover="hovmhov();" onmouseout="unhovmhov();" class="mhov" id="hov<?php echo $key; ?>">
        <div class="mframe">
          <h4 style="text-align:center;"><a href="./?sort=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?></a></h4>
          <ul>
<?php
	$sql = "SELECT gid,title FROM ".DB_PREFIX."blog WHERE type='blog' AND hide='n' AND sortid=".$value['sid']." ORDER BY date DESC";
	$query = $DB->query($sql);
	while($row = $DB->fetch_array($query))
	{
?>
			<a href="./?post=<?php echo $row['gid']; ?>"><?php echo htmlspecialchars(trim($row['title']));?></a><br />
<?php
	}
?>
          </ul>
        </div>
        </div>
<?php
		}
		echo ('</div>');
	}
}
?>