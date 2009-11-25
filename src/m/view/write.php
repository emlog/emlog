<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./"  id="active">日志</a> 
<a href="./?action=tw">碎语</a> 
<a href="./?action=com">评论</a> 
<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
<a href="./?action=logout">退出</a>
<?php else:?>
<a href="<?php echo BLOG_URL; ?>m/?action=login">登录</a>
<?php endif;?>
</div>
<div id="m">
<form action="./?action=savelog" method="post">
标题：<br /><input type="text" name="title" value="<?php echo $title; ?>" /><br />
分类：<br />
	      <select name="sort" id="sort">
			<?php
			$sorts[] = array('sid'=>-1, 'sortname'=>'选择分类...');
			foreach($sorts as $val):
			$flg = $val['sid'] == $sortid ? 'selected' : '';
			?>
			<option value="<?php echo $val['sid']; ?>" <?php echo $flg; ?>><?php echo $val['sortname']; ?></option>
			<?php endforeach; ?>
	      </select>
<br />
内容：<br /><textarea name="content" class="texts"><?php echo $content; ?></textarea><br />
标签：<br /><input type="text" name="tag" value="<?php echo $tagStr; ?>" /><br />
<input type="hidden" name="gid" value=<?php echo $logid; ?> />
<input type="hidden" name="author" value=<?php echo $author; ?> />
<input name="date" type="hidden" value="<?php echo $date; ?>" >
<input type="submit" value="发布日志" />
</form>
</div>