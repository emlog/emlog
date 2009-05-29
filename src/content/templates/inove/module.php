<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<?php
//widget：blogger
function widget_blogger($title){
	global $user_cache; 
	$name = $user_cache[1]['mail'] != '' ? "<a href=\"mailto:".$user_cache[1]['mail']."\">".$user_cache[1]['name']."</a>" : $user_cache[1]['name'];?>
	<div class="widget"><span onclick="showhidediv('bloggerinfo')"><?php echo $title; ?></span>
	<ul style="text-align:center" id="bloggerinfo">
		<li>
		<?php if (!empty($user_cache[1]['photo']['src'])): ?>
		<img src="<?php echo BLOG_URL.$user_cache[1]['photo']['src']; ?>" width="<?php echo $user_cache[1]['photo']['width']; ?>" height="<?php echo $user_cache[1]['photo']['height']; ?>" alt="blogger" />
		<?php endif;?>
		</li>
		<li><b><?php echo $name; ?></b></li>
		<li><span id="bloggerdes"><?php echo $user_cache[1]['des']; ?></span>
		<?php if(ROLE == 'admin'): ?>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
		<img src="<?php echo CERTEMPLATE_URL; ?>/images/modify.gif" align="absmiddle" alt="修改我的状态"/></a></li>
		<li id='modbdes' style="display:none;">
		<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:190px;height:60px;"><?php echo $user_cache[1]['des']; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('<?php echo BLOG_URL; ?>admin/blogger.php?action=update&flg=1','bdes','bloggerdes');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
		<?php endif; ?>
		</li>
	</ul>
	</div>
<?php }?>
<?php
//widget：日历
function widget_calendar($title){
	global $calendar_url; ?>
	<div class="widget"><span onclick="showhidediv('calendar')"><?php echo $title; ?></span>
	<div id="calendar">
	</div>
	</div>
	<script>sendinfo('<?php echo $calendar_url; ?>','calendar');</script>
<?php }?>

<?php
//widget：标签
function widget_tag($title){
	global $tag_cache; ?>
	<div id="tag_cloud" class="widget"><span onclick="showhidediv('blogtags')"><?php echo $title; ?></span>
	<ul id="blogtags">
	<li>
	<?php foreach($tag_cache as $value): ?>
		<span style="font-size:<?php echo $value['fontsize']; ?>pt; height:30px;">
		<a href="<?php echo BLOG_URL; ?>?tag=<?php echo $value['tagurl']; ?>" title="<?php echo $value['usenum']; ?> 篇日志"><?php echo $value['tagname']; ?></a></span>
	<?php endforeach; ?>
	</li>
	</ul></div>
<?php }?>
<?php
//widget：分类
function widget_sort($title){
	global $sort_cache; ?>
	<div class="widget"><span onclick="showhidediv('blogsort')"><?php echo $title; ?></span>
	<ul id="blogsort">
	<?php foreach($sort_cache as $value): ?>
	<li>
	<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
	<a href="<?php echo BLOG_URL; ?>rss.php?sort=<?php echo $value['sid']; ?>"><img align="absmiddle" src="<?php echo CERTEMPLATE_URL; ?>/images/icon_rss.gif" alt="订阅该分类"/></a>
	</li>
	<?php endforeach; ?>
	</ul></div>
<?php }?>

<?php
//widget：twitter
function widget_twitter($title){
	global $tw_cache,$index_twnum,$localdate; ?>
	<?php if($index_twnum>0): ?>
		<div class="widget"><span onclick="showhidediv('twitter')"><?php echo $title; ?></span>
		<ul id="twitter">
		<?php
		if(isset($tw_cache) && is_array($tw_cache)):
		$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('".BLOG_URL."twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
		foreach (array_slice($tw_cache,0,$index_twnum) as $value):
		$delbt = ROLE == 'admin'?"<a href=\"javascript:void(0);\" onclick=\"isdel('".BLOG_URL."','{$value['id']}','twitter')\">删除</a>":'';
		$value['date'] = smartyDate($localdate,$value['date']);
		?>
		<li> <?php echo $value['content']; ?> <?php echo $delbt; ?><br><span><?php echo $value['date']; ?></span></li>
		<?php endforeach;?>
		<?php echo $morebt;?>
		<?php endif;?>
		</ul>
		<?php if(ROLE == 'admin'): ?>
		<ul>
		<li><a href="javascript:void(0);" onclick="showhidediv('addtw','tw')">我要唠叨</a></li>
		<li id='addtw' style="display: none;">
		<textarea name="tw" id="tw" style="overflow-y: hidden;width:210px;height:70px;" class="input"></textarea><br>
		<a href="javascript:void(0);" onclick="postinfo('<?php echo BLOG_URL; ?>twitter.php?action=add','tw','twitter');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('addtw')">取消</a>
		</li>
		</ul>
		<?php endif;?>
	<?php endif;?></div>
<?php } ?>
<?php 
//widget：音乐
function widget_music($title){
	global $musicdes,$musicurl,$autoplay; ?>
	<div class="widget"><span onclick="showhidediv('blogmusic')"><?php echo $title; ?></span>
	<ul id="blogmusic">
	<li><?php echo $musicdes; ?><object type="application/x-shockwave-flash" data="<?php echo CERTEMPLATE_URL; ?>/images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" width="180" height="20"><param name="movie" value="<?php echo CERTEMPLATE_URL; ?>/images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" /></object>
	</li>
	</ul></div>	
<?php }?>
<?php
//widget：最新评论
function widget_newcomm($title){
	global $com_cache; ?>
	<div style="padding:10px 15px 5px;"><span onclick="showhidediv('newcomment')"><?php echo $title; ?></span></div>
	<ul id="newcomment">
	<?php 
	foreach($com_cache as $value): 
	$value['url'] = BLOG_URL.$value['url'];
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
	<div class="widget p-10" ></div>
<?php }?>
<?php
//widget：最新日志
function widget_newlog($title){
	global $newLogs_cache; ?>
	<div class="widget"><span onclick="showhidediv('newlog')"><?php echo $title; ?></span>
	<ul id="newlog">
	<?php foreach($newLogs_cache as $value): ?>
	<li><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>
	</ul></div>
<?php }?>
<?php
//widget：随机日志
function widget_random_log($title){
	global $index_randlognum, $emBlog;
	if (!isset($emBlog))
	{
		global $DB;
		require_once(EMLOG_ROOT.'/model/C_blog.php');
		$emBlog = new emBlog($DB);
	}
	$randLogs = $emBlog->getRandLog($index_randlognum);?>
	<div class="widget"><span onclick="showhidediv('randlog')"><?php echo $title; ?></span>
	<ul id="randlog">
	<?php foreach($randLogs as $value): ?>
	<li><a href="<?php echo BLOG_URL; ?>?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>
	</ul></div>
<?php }?>
<?php
//widget：归档
function widget_archive($title){
	global $dang_cache; ?>
	<div class="widget"><span onclick="showhidediv('record')"><?php echo $title; ?></span>
	<ul id="record">
	<?php foreach($dang_cache as $value): ?>
	<li><a href="<?php echo BLOG_URL; ?><?php echo $value['url']; ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
	<?php endforeach; ?>		
	</ul></div>
<?php } ?>
<?php
//widget：自定义组件
function widget_custom_text($title, $content, $id){ ?>
	<div class="widget"><span onclick="showhidediv('<?php echo $id; ?>')"><?php echo $title; ?></span>
	<ul id="<?php echo $id; ?>">
	<li><?php echo $content; ?></li>
	</ul></div>
<?php } ?>
<?php
//widget：链接
function widget_link($title){
	global $link_cache; ?>
	<div class="widget"><span onclick="showhidediv('link')"><?php echo $title; ?></span>
	<ul id="link">
	<?php foreach($link_cache as $value): ?>     	
	<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
	<?php endforeach; ?>
	</ul></div>
<?php }?>
<?php
//widget：博客信息
function widget_bloginfo($title){
	global $sta_cache,$viewcount_day,$viewcount_all; ?>
	<div class="widget"><span onclick="showhidediv('bloginfo')"><?php echo $title; ?></span>
	<ul id="bloginfo">
	<li>日志数量：<?php echo $sta_cache['lognum']; ?></li>
	<li>评论数量：<?php echo $sta_cache['comnum']; ?></li>
	<li>引用数量：<?php echo $sta_cache['tbnum']; ?></li>
	<li>今日访问：<?php echo $viewcount_day; ?></li>
	<li>总访问量：<?php echo $viewcount_all; ?></li>
	</ul></div>
<?php }?>
<?php
//blog：置顶
function topflg($istop){
	global $log_cache_sort; 
	$topflg = $istop == 'y' ? "<img src=\"".CERTEMPLATE_URL."/images/import.gif\" align=\"absmiddle\"  title=\"置顶日志\" /> " : '';
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
	<a href="<?php echo BLOG_URL; ?>?sort=<?php echo $sort; ?>"><?php echo $log_cache_sort[$blogid]; ?></a>
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
			$tag .= "	<a href=\"".BLOG_URL."?tag=".urlencode($value['tagname'])."\">".$value['tagname'].'</a>';
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
	<div id="tb_list">
	<p><b>引用地址：</b>
	<input class="textfield" type="text" style="width:350px" class="input" value="<?php echo BLOG_URL; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>"><a name="tb"></a></p>
	</div>
	<?php endif; ?>
	<?php 
	foreach($tb as $key=>$value):
	?>
	<ul style="list-style:none;">
		<li><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> </li>
		<li>BLOG: <?php echo $value['blog_name'];?></li>
		<li><?php echo $value['date'];?></li>
	</ul>
	<?php endforeach; ?>
	</div>	
<?php }?>
<?php
//blog：博客评论列表
function blog_comments(){
	global $comments; ?>
	<div id="commentlist">
	<?php
	foreach($comments as $key=>$value):
	$reply = $value['reply']?"<span><b>博主回复</b>：{$value['reply']}</span>":'';
	?>
		<!-- comments START -->
		<ol id="thecomments">
			<li class="comment regularcomment" id="comment-1">
			<div class="author">
				<div class="name">
				<a name="<?php echo $value['cid']; ?>"></a>
		<b><?php echo $value['poster']; ?> </b>
		<div style="font-size:12px; font-weight:300;">
		<?php if($value['mail']):?>
			<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
		<?php endif;?><br />
		<?php if($value['url']):?>
			<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
		<?php endif;?>
			
		</div>
								</div>
			</div>
	
			<div class="info">
				<div class="date">
				<?php echo $value['date']; ?>
				</div>
				<div class="act">
				
					<?php if(ISLOGIN === true): ?>
			<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>','reply<?php echo $value['cid']; ?>')">回复</a>
			<div id='replybox<?php echo $value['cid']; ?>' style="display:none;">
			<textarea name="reply<?php echo $value['cid']; ?>" class="input" id="reply<?php echo $value['cid']; ?>" style="overflow-y: hidden;width:360px;height:50px;"><?php echo $value['reply']; ?></textarea>
			<br />
			<a href="javascript:void(0);" onclick="postinfo('<?php echo BLOG_URL; ?>admin/comment.php?action=doreply&cid=<?php echo $value['cid']; ?>&flg=1','reply<?php echo $value['cid']; ?>','replycomm<?php echo $value['cid']; ?>');">提交</a>
			<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>')">取消</a>
			</div>
		<?php endif; ?>
								</div>
				<div class="fixed"></div>
				<div class="content">
					
					<div id="commentbody-1">
						<?php echo $value['content']; ?>
			<div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply; ?></div>
		
					</div>
				</div>
			</div>
			<div class="fixed"></div>
		</li>
	</li>
		</ol>
		<?php endforeach; ?>
		<!-- comments END -->
	</div>
<?php }?>
<?php
//blog：发表评论表单
function blog_comments_post(){
	global $logid,$ckname,$ckmail,$ckurl,$cheackimg,$allow_remark; ?>
	<?php if($allow_remark == 'y'): ?>
	<p style="margin:10px 0px 3px;"><b>评论:</b></p>
	<form  method="post"  name="commentform" action="<?php echo BLOG_URL; ?>?action=addcom">
		<div id="respond">
				<div id="author_info">
					<div class="row">
						<input type="hidden" name="gid" value="<?php echo $logid; ?>" />
						<input type="text" name="comname" id="author" class="textfield" value="<?php echo $ckname; ?>" size="24" tabindex="1" />
						<label for="author" class="small">昵称 (必填)</label>
					</div>
					<div class="row">
						<input type="text" name="commail" id="email" class="textfield" value="<?php echo $ckmail; ?>" size="24" tabindex="2" />
						<label for="email" class="small">电子邮箱 (我们会为您保密)</label>
					</div>
					<div class="row">
						<input type="text" name="comurl" id="url" class="textfield" value="<?php echo $ckurl; ?>" size="24" tabindex="3" />
						<label for="url" class="small">网址</label>
					</div>
				</div>
			<div class="row">
				<textarea name="comment"  id="comment" tabindex="4" rows="8" cols="50"></textarea>
			</div>
			<div id="submitbox">
				<div class="submitbutton">
					<?php echo $cheackimg; ?><input name="Submit" id="submit" class="button" type="submit" value="发表评论" onclick="return checkform()" />
				</div>
							<input type="hidden" name="comment_post_ID" value="1" />
				<div class="fixed"></div>
			</div>
	
		</div>
		</form>
	<?php endif; ?>
<?php }?>