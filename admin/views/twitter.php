<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_t'])): ?>
    <div class="alert alert-success">发布成功</div><?php endif ?>
<?php if (isset($_GET['active_set'])): ?>
    <div class="alert alert-success">设置保存成功</div><?php endif ?>
<?php if (isset($_GET['active_del'])): ?>
    <div class="alert alert-success">笔记删除成功</div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
    <div class="alert alert-danger">笔记内容不能为空</div><?php endif ?>
<h1 class="h3 mb-2 text-gray-800">卡片笔记</h1>
<p class="mb-4">快速记录想法，帮你方便的捕捉灵感，积累知识的复利</p>
<form method="post" action="twitter.php?action=post">
    <div class="form-group">
        <textarea class="form-control" id="t" name="t" rows="4" placeholder="" autofocus required></textarea>
    </div>
    <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
    <button type="submit" class="btn btn-sm btn-success">保存笔记</button>
</form>
<div class="card-columns mt-5">
	<?php
	foreach ($tws as $val):
		$tid = (int)$val['id'];
		$author = $user_cache[$val['author']]['name'];
		?>
        <div class="card p-3">
            <blockquote class="blockquote mb-0 card-body">
                <p><?= $val['t'] ?></p>
                <footer>
                    <p class="text-muted small card-text d-flex justify-content-between">
						<?= $val['date'] ?> | by <?= $author ?>
                        <a href="javascript: em_confirm(<?= $tid ?>, 'tw', '<?= LoginAuth::genToken() ?>');" class="care">删除</a>
                    </p>
                </footer>
            </blockquote>
        </div>
	<?php endforeach ?>
</div>
<div class="page my-5"><?= $pageurl ?> (有<?= $twnum ?>条笔记)</div>

<script>
    $("#menu_twitter").addClass('active');
    setTimeout(hideActived, 3600);

    var textarea = document.querySelector('#t');
    textarea.addEventListener('input', (e) => {
        textarea.style.height = '98px';
        textarea.style.height = e.target.scrollHeight + 'px';
    });
</script>
