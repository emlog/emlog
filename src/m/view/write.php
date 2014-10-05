<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="m">
<form action="./index.php?action=savelog" method="post">
<!--vot--><?=lang('title')?>:<br /><input type="text" name="title" value="<?php echo $title; ?>" /><br />
<!--vot--><?=lang('category')?>:<br />
	      <select name="sort" id="sort">
			<?php
/*vot*/			$sorts[] = array('sid'=>-1, 'sortname'=>lang('category_select'));
			foreach($sorts as $val):
			$flg = $val['sid'] == $sortid ? 'selected' : '';
			?>
			<option value="<?php echo $val['sid']; ?>" <?php echo $flg; ?>><?php echo $val['sortname']; ?></option>
			<?php endforeach; ?>
	      </select>
<br />
<!--vot--><?=lang('content')?>:<br /><textarea name="content" class="texts"><?php echo $content; ?></textarea><br />
<!--vot--><?=lang('summary')?>:<br /><textarea name="excerpt" class="excerpt"><?php echo $excerpt; ?></textarea><br />
<!--vot--><?=lang('tags')?>:<br /><input type="text" name="tag" value="<?php echo $tagStr; ?>" /><br />
<input type="hidden" name="gid" value=<?php echo $logid; ?> />
<input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
<input type="hidden" name="author" value=<?php echo $author; ?> />
<input name="date" type="hidden" value="<?php print !empty($date) ? gmdate('Y-m-d H:i:s', $date) : ''; ?>" />
<!--vot--><input type="submit" value="<?=lang('post_publish')?>" class="button" />
</form>
</div>
