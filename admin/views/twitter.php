<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_t'])): ?>
    <div class="actived">发布成功</div><?php endif; ?>
<?php if (isset($_GET['active_set'])): ?>
    <div class="actived">设置保存成功</div><?php endif; ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="actived">笔记删除成功</div><?php endif; ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="error">笔记内容不能为空</div><?php endif; ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">笔记</h1>
</div>
<form method="post" action="twitter.php?action=post">
    <div class="form-group">
        <textarea class="form-control" id="t" name="t" rows="3" placeholder="记录你的想法" required></textarea>
    </div>
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
    <button type="submit" class="btn btn-primary">保存笔记</button>
</form>
<div class="card-columns">
	<?php
	foreach ($tws as $val):
		$author = $user_cache[$val['author']]['name'];
		$avatar = empty($user_cache[$val['author']]['avatar']) ? './views/images/avatar.jpg' : '../' . $user_cache[$val['author']]['avatar'];
		$tid = (int)$val['id'];
		$img = empty($val['img']) ? "" : BLOG_URL . $val['img'];
		?>
        <div class="card" style="min-height: 280px;">
            <div class="card-body">
                <p class="card-text text-muted small">
					<?php echo $val['t']; ?><br>
                </p>
            </div>
            <p class="card-text">
                <a href="javascript: em_confirm(<?php echo $tid; ?>, 'tw', '<?php echo LoginAuth::genToken(); ?>');" class="care">删除</a>
            </p>
        </div>
	<?php endforeach; ?>
</div>
<div class="page my-5"><?php echo $pageurl; ?> (有<?php echo $twnum; ?>条笔记)</div>

<script>
    $("#menu_twitter").addClass('active');
    setTimeout(hideActived, 3600);
</script>
