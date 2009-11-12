<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./" id="active">日志</a> 
<a href="./?action=tw">碎语</a> 
<a href="./?action=com">评论</a> 
<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
<a href="./?action=write">写日志</a> 
<a href="./?action=writet">写碎语</a> 
<a href="./?action=logout">退出</a>
<?php else:?>
<a href="./?action=login">登录</a>
<?php endif;?>
</div>
<div id="post">
	<div class="posttitle"><?php echo $log_title; ?></div>
	<div class="postinfo"><?php echo date('Y-n-j G:i', $date); ?></div>
	<div class="postcont"><?php echo $log_content; ?></div>

	<div class="t">评论：</div>
	<div class="c">
		<?php foreach($comments as $key=>$value):
			$reply = $value['reply']?"<span>博主回复：{$value['reply']}</span>":'';
			$value['poster'] = $value['url'] ? '<a href="'.$value['url'].'" target="_blank">'.$value['poster'].'</a>' : $value['poster'];
		?>
			<div class="l">
			<b><?php echo $value['poster']; ?> </b>
			<div class="comdate"><?php echo $value['date']; ?></div>
			<div class="comcont">
			<?php echo $value['content']; ?>
			</div>
			</div>
		<?php endforeach; ?>
	</div>
	<div class="t">发表评论：</div>
	<div class="c">
		<form method="post" action="./?action=addcom&gid=<?php echo $logid; ?>">
		<div><input type="text" name="comname" value="" /> 昵称</div>
		<div><input type="text" name="commail" value="" /> 邮件地址 (选填)</div>
		<div><input type="text" name="comurl" value="" /> 个人主页 (选填)</div>
		<div><textarea name="comment" id="comment" rows="10"></textarea></div>
		<div><?php echo $cheackimg; ?><input name="Submit" type="submit" id="comment_submit" value="发表评论" onclick="return checkform()" /></div>
		</form>
	</div>
</div>