<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['active_t'])): ?>
          <div class="alert alert-success"><?= lang('published_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_set'])): ?>
          <div class="alert alert-success"><?= lang('settings_saved_ok') ?></div><?php endif ?>
<?php if (isset($_GET['active_del'])): ?>
          <div class="alert alert-success"><?= lang('twitter_del_ok') ?></div><?php endif ?>
<?php if (isset($_GET['error_a'])): ?>
          <div class="alert alert-danger"><?= lang('twitter_empty') ?></div><?php endif ?>
          <h1 class="h3 mb-2 text-gray-800"><?= lang('twitter_add') ?></h1>
          <p class="mb-4"><?= lang('twitter_prompt') ?></p>
<form method="post" action="twitter.php?action=post">
    <div class="form-group">
        <textarea class="form-control" id="t" name="t" rows="4" placeholder="" autofocus required></textarea>
    </div>
    <input name="token" id="token" value="<?= LoginAuth::genToken() ?>" type="hidden"/>
          <button type="submit" class="btn btn-sm btn-success"><?= lang('twitter_save') ?></button>
</form>
<div class="card-columns mt-5">
	<?php
	foreach ($tws as $val):
		$tid = (int)$val['id'];
		?>
        <div class="card p-3">
            <blockquote class="blockquote mb-0 card-body">
                <p><?= $val['t'] ?></p>
                <footer class="blockquote-footer">
                    <small class="text-muted">
          				<?= $val['date'] ?> | <a href="javascript: em_confirm(<?= $tid ?>, 'tw', '<?= LoginAuth::genToken() ?>');" class="care"><?= lang('delete') ?></a>
                    </small>
                </footer>
            </blockquote>
        </div>
	<?php endforeach ?>
</div>
          <div class="page my-5"><?= $pageurl ?> (<?= lang('have') ?> <?= $twnum ?><?= lang('_twitters') ?>)</div>

<script>
    $("#menu_twitter").addClass('active');
    setTimeout(hideActived, 3600);

    var textarea = document.querySelector('#t');
    textarea.addEventListener('input', (e) => {
        textarea.style.height = '98px';
        textarea.style.height = e.target.scrollHeight + 'px';
    });
</script>
