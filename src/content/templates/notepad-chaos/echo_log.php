<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="container">
  <div id="search">
    <form method="get" name="keyform" id="searchform" action="index.php">
      <input type="text" value="" name="keyword" id="s" class="txtField" />
      <input type="submit" id="searchsubmit" class="btnSearch" value="Find It &raquo;"onclick="return keyw()" />
    </form>
  </div>
  <div id="menu-holder">
  <ul id="menu">
  <li id="home"><a href="./">Home</a></li>
  <li id="about"><a href="http://www.emlog.net" target="_blank">emlog</a></li>
  <li id="archives"><a href="/rss.php">Rss</a></li>
  </ul>
  </div>
  <div id="title">
    <h2><a href="./"><?php echo $blogname; ?></a></h2>
    <?php echo $bloginfo; ?></div>
</div>
<div id="content">
  <div class="col01">
    <div class="post" id="post-<?php echo $logid; ?>">
      <h3><a href="./?action=showlog&gid=<?php echo $logid; ?>" rel="bookmark" title="Permanent Link to <?php echo $log_title; ?>"><?php echo $log_title; ?></a></h3>
      <div class="post-inner">
        <div class="date-tab"><span class="month"><?php echo date('n月',$show_log['date']); ?></span><span class="day"><?php echo date('j',$show_log['date']); ?></span></div>
        <div class="thumbnail"></div>
		<?php echo $log_content; ?>
		<p><?php echo $att_img; ?></p>
		<p><?php echo $attachment; ?></p>
      </div>
	<div class="meta"><?php echo $tag; ?></div>
    </div>
    <div class="post-nav">
	<?php if($nextLog):?>
    <span class="previous"><a href="./?action=showlog&gid=<?php echo $nextLog['gid']; ?>"></a></span>
    <?php endif;?>
    <?php if($previousLog):?>
    <span class="next"><a href="./?action=showlog&gid=<?php echo $previousLog['gid']; ?>"></a></span>
    <?php endif;?>
    </div>
    <?php if($allow_tb == 'y'):?>	
	<p><b>引用地址：</b><input type="text" style="width:300px" style="border:1px solid #939393;" value="<?php echo $blogurl; ?>tb.php?sc=<?php echo $tbscode; ?>&amp;id=<?php echo $logid; ?>"><a name="tb"></a></p>
	<?php endif; ?>
	<?php foreach($tb as $key=>$value):?>
	<div class="trackback">
		<li>来自: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['blog_name'];?></a></li>
    	<li>标题: <a href="<?php echo $value['url'];?>" target="_blank"><?php echo $value['title'];?></a> </li>
    	<li>摘要:<?php echo $value['excerpt'];?></li>
		<li>引用时间:<?php echo $value['date'];?></li>
	</div>
	<?php endforeach; ?>
	<ol class="commentlist">
	<a name="comment"></a>
		<?php
		foreach($com as $key=>$value):
		$reply = $value['reply']?"<span><b>博主回复</b>：{$value['reply']}</span>":'';
		?>
		<li class="alt">
			<a name="<?php echo $value['cid']; ?>"></a>
			<span class="commentdate"><a href="#<?php echo $value['cid']; ?>" title=""><?php echo $value['addtime']; ?></a> </span>
            <cite><?php echo $value['poster']; ?>
            <?php if($value['mail']):?>
			<a href="mailto:<?php echo $value['mail']; ?>" title="发邮件给<?php echo $value['poster']; ?>">Email</a>
			<?php endif;?>
			<?php if($value['url']):?>
            <a href="<?php echo $value['url'];?>" title="访问<?php echo $value['poster']; ?>的主页" target="_blank">Home</a>
            <?php endif;?>
            </cite> Says:
			<?php echo $value['content'];?>
			<div id="replycomm<?php echo $value['cid']; ?>"><?php echo $reply; ?></div>
			<?php if(ISLOGIN === true): ?>	
			<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>','reply<?php echo $value['cid']; ?>')">回复</a>
			<div id='replybox<?php echo $value['cid']; ?>' style="display:none;">
			<textarea name="reply<?php echo $value['cid']; ?>" class="input" id="reply<?php echo $value['cid']; ?>" style="overflow-y: hidden;width:360px;height:50px;"><?php echo $value['reply']; ?></textarea>
			<br />
			<a href="javascript:void(0);" onclick="postinfo('./adm/comment.php?action=doreply&cid=<?php echo $value['cid']; ?>&flg=1','reply<?php echo $value['cid']; ?>','replycomm<?php echo $value['cid']; ?>');">提交</a>
			<a href="javascript:void(0);" onclick="showhidediv('replybox<?php echo $value['cid']; ?>')">取消</a>
			</div>
			<?php endif; ?>
		</li>
		<?php endforeach; ?>
	</ol>
    <form action="index.php?action=addcom" method="post" id="commentform">
    <input type="hidden" name="gid" value="<?php echo $logid; ?>" />
	<p><label for="author"><span class="name">Name:</span></label><input type="text" name="comname" id="author" value="<?php echo $ckname; ?>" size="22" tabindex="2" class="comment-field" /></p>
	<p><label for="email"><span class="email">Email:</span></label><input type="text" name="commail" id="email" value="<?php echo $ckmail; ?>" size="22" tabindex="3" class="comment-field" /></p>
	<p><label for="url"><span class="website">Website Address:</span></label><input type="text" name="comurl" id="url" value="<?php echo $ckurl; ?>" size="22" tabindex="4" class="comment-field" />
	<span class="txt-website-example">Website example</span></p>
	<p><span class="comments">Your Comment:</span><textarea name="comment" id="comment" rows="10" tabindex="1" class="comment-box"></textarea></p>
	<p><input name="submit" type="submit" id="submit" class="btnComment" tabindex="5" value="Add Comment &raquo;" /><?php echo $cheackimg; ?><input type="checkbox" name="remember" value="1" checked="checked" />Remember me
	</p>
	</form>

  </div>
  <div class="col02">
    <div class="recent-posts">
    <?php
    	$topquery = $DB->query("SELECT * FROM {$db_prefix}blog WHERE hide='n' ORDER BY date DESC  LIMIT 5");
		while($toplogs = $DB->fetch_array($topquery)):
			$toplogs['post_time'] = date('Y-n-j G:i l',$toplogs['date']);
			$toplogs['title'] = htmlspecialchars(trim($toplogs['title']));
	?>
    <ul>
    <li><a href="./?action=showlog&gid=<?php echo $toplogs['gid']; ?>"><?php echo $toplogs['title']; ?><br />
    <span class="listMeta"><?php echo $toplogs['post_time']; ?></span></a></li>
    </ul>
    <?php endwhile;?>
    </div>
    <div class="postit-bottom"></div>
    <?php include getViews('side'); ?>
  </div>
  <br clear="all" />
</div>
<?php include getViews('footer'); ?>