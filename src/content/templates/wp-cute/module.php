<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<?php
//widget：blogger
function widget_blogger($title){
	global $user_cache; 
	$name = $user_cache[1]['mail'] != '' ? "<a href=\"mailto:".$user_cache[1]['mail']."\">".$user_cache[1]['name']."</a>" : $user_cache[1]['name'];?>
  <H2 onClick="showhidediv('bloggerinfo')"><?php echo $title; ?></H2>
   <ul id="bloggerinfo" >
	<li>
	<?php if (!empty($user_cache[1]['photo']['src'])): ?>
	<img src="<?php echo $user_cache[1]['photo']['src']; ?>" width="<?php echo $user_cache[1]['photo']['width']; ?>" height="<?php echo $user_cache[1]['photo']['height']; ?>" alt="blogger" />
	<?php endif;?>
	</li>
	<li><span id="bloggerdes"><?php echo $user_cache[1]['des']; ?></span>
	<?php if(ROLE == 'admin'): ?>
	<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
	<img src="<?php echo CERTEMPLATE_URL; ?>/images/modify.gif" align="absmiddle" alt="修改我的状态" border="0"/></a></li>
	<li id='modbdes' style="display:none;">
	<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:160px;height:50px;"><?php echo $user_cache[1]['des']; ?></textarea>
	<br />
	<a href="javascript:void(0);" onclick="postinfo('./admin/blogger.php?action=update&flg=1','bdes','bloggerdes');">提交</a>
	<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
	<?php endif; ?>
	</li>
	</ul>
<?php }?>
<?php
//widget：日历
function widget_calendar($title){
	global $calendar_url; ?>
  <H2 onClick="showhidediv('calendar')"><?php echo $title; ?></H2>
    	<div id="calendar">
		
		</div>
<script>sendinfo('<?php echo $calendar_url;?>','calendar');</script>
<?php }?>
<?php
//widget：标签
function widget_tag($title){
	global $tag_cache; ?>
	  <H2 onClick="showhidediv('tags')"><?php echo $title; ?></H2>
			<ul id="tags">
	<?php foreach($tag_cache as $key=>$value): ?>
	<span style="font-size:<?php echo $value['fontsize'];?>pt; height:30px;"><a href="./?tag=<?php echo $value['tagurl'];?>"><?php echo $value['tagname'];?></a></span>&nbsp;
	<?php endforeach; ?>
	</ul>
<?php }?>
<?php
//widget：分类
function widget_sort($title){
	global $sort_cache; ?>
	 <H2 onClick="showhidediv('sort')"><?php echo $title; ?></H2>
	<ul id="sort">
	<?php foreach($sort_cache as $value): ?>
	<li>
	<a href="./?sort=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
	<a href="./rss.php?sort=<?php echo $value['sid']; ?>"><img align="absmiddle" src="<?php echo CERTEMPLATE_URL; ?>/images/icon_rss.gif" alt="订阅该分类"/></a>
	</li>
	<?php endforeach; ?>	
	</ul>
<?php }?>
<?php
//widget：twitter
function widget_twitter($title){
	global $tw_cache,$index_twnum,$localdate; ?>
	<?php if($index_twnum>0): ?>
	<h2 onclick="showhidediv('twitter')"><?php echo $title; ?></h2>
	<ul id="twitter">
	<?php  if(isset($tw_cache) && is_array($tw_cache)):
	$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('./twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
	foreach (array_slice($tw_cache,0,$index_twnum) as $value):
		$delbt = ROLE == 'admin'?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
		$value['date'] = smartyDate($localdate,$value['date']);
	?>
	<li> <?php echo $value['content'];?> <?php echo $delbt;?><br><span><?php echo $value['date'];?></span></li>
	<?php endforeach; ?>
	<?php echo $morebt; ?>
	<?php endif; ?>
	</ul>
	<?php if(ROLE == 'admin'): ?>
	<ul>
	<li><a href="javascript:void(0);" onclick="showhidediv('addtw','tw')">我要唠叨</a></li>
	<li id='addtw' style="display: none;">
	<textarea name="tw" id="tw" style="overflow-y: hidden;width:180px;height:70px;" class="input"></textarea>
	<a href="javascript:void(0);" onclick="postinfo('./twitter.php?action=add','tw','twitter');">提交</a>
	<a href="javascript:void(0);" onclick="showhidediv('addtw')">取消</a>
	</li>
	</ul>
	<?php endif; ?>
	<?php endif; ?>
<?php } ?>
<?php 
//widget：音乐
function widget_music($title){
	global $musicdes,$musicurl,$autoplay; ?>
	  <H2 onClick="showhidediv('music')"><?php echo $title; ?></H2>
			<ul id="music">
			<li><?php echo $musicdes; ?><object type="application/x-shockwave-flash" data="<?php echo CERTEMPLATE_URL; ?>/images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" width="145" height="20"><param name="movie" value="<?php echo CERTEMPLATE_URL; ?>/images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" /></object>
	</li>
			</ul>
<?php }?>
<?php
//widget：最新评论
function widget_newcomm($title){
	global $com_cache; ?>
   <H2 onClick="showhidediv('newcomment')"><?php echo $title; ?></H2>
		<ul id="newcomment">
		<?php 
		foreach($com_cache as $value): 
		$value['url'] = $value['url'];
		?>
		<li id="comment"> &raquo; <?php echo $value['name'];?>
		<?php if($value['reply']): ?>
		<a href="<?php echo $value['url']; ?>" title="博主回复：<?php echo $value['reply']; ?>">
		<img src="<?php echo CERTEMPLATE_URL; ?>/images/reply.gif" align="absmiddle" border="0"/>
		</a>
		<?php endif;?>
		<br /></li>
		<li id="comment"><a href="<?php echo $value['url'];?>"><?php echo $value['content'];?></a></li>
<?php endforeach; ?>
		</ul>
<?php }?>
<?php
//widget：最新日志
function widget_newlog($title){
	global $newLogs_cache; ?>
	 <H2 onClick="showhidediv('newlog')"><?php echo $title; ?></H2>
	<ul id="newlog">
	<?php foreach($newLogs_cache as $value): ?>
	<li><a href="./?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>	
	</ul>
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
	 <H2 onClick="showhidediv('randlog')"><?php echo $title; ?></H2>
	<ul id="randlog">
	<?php foreach($randLogs as $value): ?>
	<li><a href="./?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
	<?php endforeach; ?>	
	</ul>
<?php }?>
<?php
//widget：搜索
function widget_search($title){ ?>
  <LI>
  	<form name="keyform" method="get" action="./"><p>
    <input name="keyword"  type="text" class="input" value="" size="12" maxlength="30" />
    <input type="submit" value="Search" class="button" onClick="return keyw()" /></p>
   </form>
  <LI>
<?php } ?>
<?php
//widget：归档
function widget_archive($title){
	global $dang_cache; ?>
	 <H2 onClick="showhidediv('record')"><?php echo $title; ?></H2>
	<ul id="record">
	<?php foreach($dang_cache as $key=>$value): ?>
		<li><a href="./<?php echo $value['url']; ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
	<?php endforeach; ?>	
	</ul>
<?php } ?>
<?php
//widget：自定义组件
function widget_custom_text($title, $content, $id){ ?>
	 <H2 onClick="showhidediv('<?php echo $id; ?>')"><?php echo $title; ?></H2>
	<ul id="<?php echo $id; ?>">
	<li><?php echo $content; ?></li>	
	</ul>
<?php } ?>
<?php
//widget：链接
function widget_link($title){
	global $link_cache; ?>
	 <H2 onClick="showhidediv('frlink')"><?php echo $title; ?></H2>
			<ul id="frlink">
	<?php foreach($link_cache as $key=>$value): ?>     	
			<li><a href="<?php echo $value['url'];?>" title="<?php echo $value['des'];?>" target="_blank"><?php echo $value['link'];?></a></li>
	<?php endforeach; ?>
			</ul>
<?php }?>
<?php
//widget：博客信息
function widget_bloginfo($title){
	global $sta_cache,$viewcount_day,$viewcount_all; ?>
	<H2 onClick="showhidediv('bloginfo')"><?php echo $title; ?></H2>
	<ul id="bloginfo">
	<li>日志数量：<?php echo $sta_cache['lognum']; ?></li>
	<li>评论数量：<?php echo $sta_cache['comnum']; ?></li>
	<li>引用数量：<?php echo $sta_cache['tbnum']; ?></li>
	<li>今日访问：<?php echo $viewcount_day; ?></li>
	<li>总访问量：<?php echo $viewcount_all; ?></li>	
	</ul>
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
	$editflg = ROLE == 'admin' || $author == UID ? '<a href="'.'./admin/write_log.php?action=edit&gid='.$logid.'">编辑</a>' : '';
	echo $editflg;
}
?>
<?php 
//blog：分类
function blog_sort($sort, $blogid){
	global $log_cache_sort; ?>
	<?php if($log_cache_sort[$blogid]): ?>
	[<a href="./?sort=<?php echo $sort; ?>"><?php echo $log_cache_sort[$blogid]; ?></a>]
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
			$tag .= "	<a href=\"./?tag=".$value['tagurl']."\">".$value['tagname'].'</a>';
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
	echo "<a href=\"./?author=$uid\" $title>$author</a>";
}
?>
<?php
//blog：相邻日志
function neighbor_log(){
	global $prevLog,$nextLog; ?>
	<?php if($prevLog):?>
	&laquo; <a href="./?post=<?php echo $prevLog['gid']; ?>"><?php echo $prevLog['title'];?></a>
	<?php endif;?>
	<?php if($nextLog && $prevLog):?>
		|
	<?php endif;?>
	<?php if($nextLog):?>
		 <a href="./?post=<?php echo $nextLog['gid']; ?>"><?php echo $nextLog['title'];?></a>&raquo;
	<?php endif;?>
<?php }?>
<?php
//blog：引用通告
function blog_trackback(){
	global $allow_tb,$tbscode,$logid,$tb; ?>
	<?php if($allow_tb == 'y'): ?>
	<h5>引用地址:<a name="tb"></a></h5>
	<input type="text" id="input" style="width:350px" value="<?php echo BLOG_URL;?>tb.php?sc=<?php echo $tbscode;?>&amp;id=<?php echo $logid;?>" /><a name="tb"></a>
	<?php endif; ?>
	<?php foreach($tb as $key=>$value): ?>
	<ul class="trackback">
		<li>来自: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></li>
		<li>标题: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> </li>
		<li>摘要: <?php echo $value['excerpt'];?></li>
		<li>引用时间: <?php echo $value['date'];?></li>
	</ul>
	<?php endforeach; ?>	
<?php }?>
<?php
//blog：博客评论列表
function blog_comments(){
	global $comments; ?>
	<h5>评论<a name="comment" id="comment"></a></h5>
	<?php
	foreach($comments as $key=>$value):
	$reply = $value['reply']?"<span style=\"color:green;\"><b>博主回复</b>：{$value['reply']}</span>":'';
	?>
	<p><a name="<?php echo $value['cid'];?>"></a></p>
	<div class="commentlist">
	<cite><?php echo $value['poster'];?></cite> 
	<?php if($value['mail']):?>
		<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
	<?php endif;?>
	<?php if($value['url']):?>
		<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
	<?php endif;?>
	Says:<br />
	<small class="commentmetadata"><?php echo $value['date'];?></small>
	<p><?php echo $value['content'];?></p>
	<p><div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply;?></div></p>
		<?php if(ISLOGIN === true): ?>	
			<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>','reply<?php echo $value['cid']; ?>')">回复</a>
			<div id='replybox<?php echo $value['cid']; ?>' style="display:none;">
			<textarea name="reply<?php echo $value['cid']; ?>" class="input" id="reply<?php echo $value['cid']; ?>" style="overflow-y: hidden;width:360px;height:50px;"><?php echo $value['reply']; ?></textarea>
			<br />
			<a href="javascript:void(0);" onclick="postinfo('./admin/comment.php?action=doreply&cid=<?php echo $value['cid']; ?>&flg=1','reply<?php echo $value['cid']; ?>','replycomm<?php echo $value['cid']; ?>');">提交</a>
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
	<h3 id=respond>参与评论</h3>
	<form  method="post"  name="commentform" action="./?action=addcom" onsubmit="return checkcomment(this)">
	<p>
	  <input type="hidden" name="gid" value="<?php echo $logid;?>" /><br />
	  <input name="comname"  type="text" value="<?php echo $ckname;?>" />
	  <font color="red">姓名</font><br />
	  <br />
	  <input name="commail" type="text" size="45" value="<?php echo $ckmail;?>" maxlength="100" />
	  电子邮件地址<br />      <br />
	  <input name="comurl" type="text" size="45" value="<?php echo $ckurl;?>" maxlength="100" />
	  个人主页<br /><br />
	  <textarea name="comment" cols="45" rows="10" ></textarea>
	  </p>
	  <p><br />
	  <?php echo $cheackimg;?>
	  <input name="Submit" type="submit" value="提交我的评论" onclick="return checkform()" />
	</p>
	</form>
	<?php endif; ?>
<?php }?>