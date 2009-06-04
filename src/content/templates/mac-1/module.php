<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<?php
//widget：blogger
function widget_blogger($title){
	global $user_cache; 
	$name = $user_cache[1]['mail'] != '' ? "<a href=\"mailto:".$user_cache[1]['mail']."\">".$user_cache[1]['name']."</a>" : $user_cache[1]['name'];?>
	<div id="categories" class="dbx-box">
	<h3 class="dbx-handle" onclick="showhidediv('blogger')"><?php echo $title; ?></h3>
	<div class="dbx-content" id="blogger">
	<ul>
		<p align="center">
		<?php if (!empty($user_cache[1]['photo']['src'])): ?>
		<img src="<?php echo $user_cache[1]['photo']['src']; ?>" width="<?php echo $user_cache[1]['photo']['width']; ?>" height="<?php echo $user_cache[1]['photo']['height']; ?>" alt="blogger" />
		<?php endif;?>
		</p>
		<li><span id="bloggerdes"><?php echo $user_cache[1]['des']; ?></span>
		<?php if(ROLE == 'admin'): ?>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes','bdes')">
		<img src="<?php echo CERTEMPLATE_URL; ?>/images/modify.gif" align="absmiddle" alt="修改我的状态"/></a></li>
		<li id='modbdes' style="display:none;">
		<textarea name="bdes" class="input" id="bdes" style="overflow-y: hidden;width:150px;height:50px;"><?php echo $user_cache[1]['des']; ?></textarea>
		<br />
		<a href="javascript:void(0);" onclick="postinfo('./admin/blogger.php?action=update&flg=1','bdes','bloggerdes');">提交</a>
		<a href="javascript:void(0);" onclick="showhidediv('modbdes')">取消</a>
		<?php endif; ?>
		</li>
	 </ul>
	</div>
	</div>
<?php }?>
<?php
//widget：日历
function widget_calendar($title){
	global $calendar_url; ?>
      <div id="archives" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('calendar')"><?php echo $title; ?></h3>
        <div class="dbx-content">
          <ul>
            <div id="calendar"></div>
          </ul>
        </div>
      </div>
	  <script>sendinfo('<?php echo $calendar_url;?>','calendar');</script>
<?php }?>
<?php
//widget：标签
function widget_tag($title){
	global $tag_cache; ?>
      <div id="links" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('tags')"><?php echo $title; ?></h3>
        <div class="dbx-content" id="tags">
          <ul>
			<?php foreach($tag_cache as $value): ?>
			<span style="font-size:<?php echo $value['fontsize'];?>pt; height:30px;"><a href="./?tag=<?php echo $value['tagurl'];?>"><?php echo $value['tagname'];?></a></span>&nbsp;
			<?php endforeach; ?>
          </ul>
        </div>
      </div>
<?php }?>
<?php
//widget：分类
function widget_sort($title){
	global $sort_cache; ?>
      <div id="recent-comments" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('sort')"><?php echo $title; ?></h3>
        <div class="dbx-content" id="sort">
          <ul>
			<?php foreach($sort_cache as $value): ?>
			<li>
			<a href="./?sort=<?php echo $value['sid']; ?>"><?php echo $value['sortname']; ?>(<?php echo $value['lognum'] ?>)</a>
			<a href="./rss.php?sort=<?php echo $value['sid']; ?>"><img align="absmiddle" src="<?php echo CERTEMPLATE_URL; ?>/images/icon_rss.gif" alt="订阅该分类"/></a>
			</li>
			<?php endforeach; ?>
          </ul>
        </div>
      </div>
<?php }?>
<?php
//widget：twitter
function widget_twitter($title){
	global $tw_cache,$index_twnum,$localdate; ?>
	<?php if($index_twnum>0): ?>
	<div id="meta" class="dbx-box">
	<h3 onclick="showhidediv('twitter')" class="dbx-handle"><?php echo $title; ?></h3>
	<div class="dbx-content">
	<ul id="twitter">
	<?php  if(isset($tw_cache) && is_array($tw_cache)):
	$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('./twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
	foreach (array_slice($tw_cache,0,$index_twnum) as $value):
		$delbt = ROLE == 'admin'?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
		$value['date'] = smartyDate($localdate,$value['date']);
	?>
	<li> <?php echo $value['content'];?> <?php echo $delbt;?><br><span><?php echo $value['date'];?></span></li>
	<?php  endforeach; ?>
	<?php echo $morebt; ?>
	<?php endif; ?>
	</ul>
	<?php if(ROLE == 'admin'): ?>
	<ul>
	<li><a href="javascript:void(0);" onclick="showhidediv('addtw','tw')">我要唠叨</a></li>
	<li id='addtw' style="display: none;">
	<textarea name="tw" id="tw" style="overflow-y: hidden;width:160px;height:70px;" class="input"></textarea>
	<a href="javascript:void(0);" onclick="postinfo('./twitter.php?action=add','tw','twitter');">提交</a>
	<a href="javascript:void(0);" onclick="showhidediv('addtw')">取消</a>
	</li>
	</ul>
	<?php endif; ?>
	</div>
	</div>
	<?php endif; ?>
<?php } ?>
<?php 
//widget：音乐
function widget_music($title){
	global $musicdes,$musicurl,$autoplay; ?>
		  <div id="meta" class="dbx-box">
			<h3 class="dbx-handle" onclick="showhidediv('music')"><?php echo $title; ?></h3>
			<div class="dbx-content" id="music">
			  <ul>
	 <?php echo $musicdes;?><object type="application/x-shockwave-flash" data="<?php echo CERTEMPLATE_URL; ?>/images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" width="180" height="20"><param name="movie" value="<?php echo CERTEMPLATE_URL; ?>/images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" /></object>
	</p>
			  </ul>
			</div>
		  </div>
<?php }?>
<?php
//widget：最新评论
function widget_newcomm($title){
	global $com_cache; ?>
      <div id="recent-comments" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('comm')"><?php echo $title; ?></h3>
        <div class="dbx-content" id="comm">
          <ul>	
		  	<?php 
			foreach($com_cache as $value): 
			$value['url'] = $value['url'];
			?>
			<li><?php echo $value['name'];?>
			<?php if($value['reply']): ?>
				<a href="<?php echo $value['url']; ?>" title="博主回复：<?php echo $value['reply']; ?>">
				<img src="<?php echo CERTEMPLATE_URL; ?>/images/comments.gif" align="absmiddle"/>
				</a>
			<?php endif;?>
			<br /><a href="<?php echo $value['url'];?>"><?php echo $value['content'];?></a></li>
			<?php endforeach; ?>
          </ul>
        </div>
      </div>
<?php }?>
<?php
//widget：最新日志
function widget_newlog($title){
	global $newLogs_cache; ?>
      <div id="recent-comments" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('newlog')"><?php echo $title; ?></h3>
        <div class="dbx-content" id="newlog">
          <ul>
			<?php foreach($newLogs_cache as $value): ?>
			<li><a href="./?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
			<?php endforeach; ?>
          </ul>
        </div>
      </div>
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
      <div id="recent-comments" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('randlog')"><?php echo $title; ?></h3>
        <div class="dbx-content" id="randlog">
          <ul>
			<?php foreach($randLogs as $value): ?>
			<li><a href="./?post=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a></li>
			<?php endforeach; ?>
          </ul>
        </div>
      </div>
<?php }?>
<?php
//widget：归档
function widget_archive($title){
	global $dang_cache; ?>
      <div id="archives" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('dang')"><?php echo $title; ?></h3>
        <div class="dbx-content" id="dang">
          <ul>
			<?php foreach($dang_cache as $value): ?>
					<li><a href="./<?php echo $value['url']; ?>"><?php echo $value['record']; ?>(<?php echo $value['lognum']; ?>)</a></li>
			<?php endforeach; ?>	
          </ul>
        </div>
      </div>
<?php } ?>
<?php
//widget：自定义组件
function widget_custom_text($title, $content, $id){ ?>
      <div id="links" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('<?php echo $id; ?>')"><?php echo $title; ?></h3>
        <div class="dbx-content" id="<?php echo $id; ?>">
          <ul>
			<p><?php echo $content; ?></p>
          </ul>
        </div>
      </div>
<?php } ?>
<?php
//widget：链接
function widget_link($title){
	global $link_cache; ?>
      <div id="links" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('blogroll')"><?php echo $title; ?></h3>
        <div class="dbx-content" id="blogroll">
          <ul>
			<?php foreach($link_cache as $value): ?>     	
					<li><a href="<?php echo $value['url'];?>" title="<?php echo $value['des'];?>" target="_blank"><?php echo $value['link'];?></a></li>
			<?php endforeach; ?>
          </ul>
        </div>
      </div>
<?php }?>
<?php
//widget：博客信息
function widget_bloginfo($title){
	global $sta_cache,$viewcount_day,$viewcount_all; ?>
      <div id="meta" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('qita')"><?php echo $title; ?></h3>
        <div class="dbx-content" id="qita">
          <ul>
			<li>日志数量：<?php echo $sta_cache['lognum'];?></li>
			<li>评论数量：<?php echo $sta_cache['comnum'];?></li>
			<li>引用数量：<?php echo $sta_cache['tbnum'];?></li>
			<li>今日访问：<?php echo $viewcount_day;?></li>
			<li>总访问量：<?php echo $viewcount_all;?></li>
          </ul>
        </div>
      </div>
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
	<p class="info">
	<h2 id="comments">引用：</h2>
	<?php echo BLOG_URL;?>tb.php?sc=<?php echo $tbscode;?>&amp;id=<?php echo $logid;?>
	<a name="tb"></a></h2>
	</p>
	<?php endif; ?>	
	<ol class="commentlist">
	<?php foreach($tb as $key=>$value): ?>
		
			<li class="alt" id="comment-2"><a name="<?php echo $value['cid'];?>"></a>
				<strong>Trackback by:</strong><cite><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></cite>
							<br />
	
				<small class="commentmetadata"> <?php echo $value['date'];?> </small>
	
				<p><a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a><br/>
		<?php echo $value['excerpt'];?></p>
	
			</li>	
	<?php endforeach; ?>	
	</ol>	
<?php }?>
<?php
//blog：博客评论列表
function blog_comments(){
	global $comments; ?>
	<ol class="commentlist">
	<?php
	foreach($comments as $key=>$value):
	$reply = $value['reply']?"<span style=\"color:#669900;\"><b>博主回复</b>：{$value['reply']}</span>":'';
	?>
		
			<li class="alt" id="comment-2"><a name="<?php echo $value['cid'];?>"></a>
				<cite><?php echo $value['poster'];?></cite>
						<?php if($value['mail']):?>
							<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
						<?php endif;?>
						<?php if($value['url']):?>
							<a href="<?php echo $value['url']; ?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">主页</a>
						<?php endif;?>
				 说：
							<br />
				<small class="commentmetadata"> <?php echo $value['date'];?> </small>
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
			</li>	
	<?php  endforeach; ?>	
	</ol>
<?php }?>
<?php
//blog：发表评论表单
function blog_comments_post(){
	global $logid,$ckname,$ckmail,$ckurl,$cheackimg,$allow_remark; ?>
	<?php if($allow_remark == 'y'): ?>
	<h3 id="respond">发布评论</h3>
	<form method="post" name="commentform" action="./index.php?action=addcom" id="commentform">
	<p><input type="text" name="comname" id="comname" value="<?php echo $ckname;?>" size="22" tabindex="1" class="input2"/>
	<label for="author">姓名</label>
	</p>
	
	<p><input type="text" name="commail" id="commail" value="<?php echo $ckmail;?>" size="22" tabindex="2" class="input2"/>
	<label for="email">电子邮件地址 (选填)</label>
	</p>
	
	<p><input type="text" name="comurl" id="commail" value="<?php echo $ckurl;?>" size="22" tabindex="2" class="input2"/>
	<label for="email">个人主页 (选填)</label>
	</p>
	
	<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>
	
	<p><?php echo $cheackimg;?><input name="submit" type="submit" id="submit" tabindex="5" value="发布我的评论" onclick="return checkform()"  />
	<input type="hidden" name="gid" value="<?php echo $logid;?>" />
	</p>
	</form>
	<?php endif; ?>
<?php }?>