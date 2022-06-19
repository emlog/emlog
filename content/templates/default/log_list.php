<?php
/**
 * Homepage template
 */
if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>
<main class="container">
    <div class="row">
        <div class="column-big"> 
			<?php doAction('index_loglist_top');
			if (!empty($logs)):
				foreach ($logs as $value):
					?>
                    <div class="shadow-theme bottom-5">
						<?php if (!empty($value['log_cover'])) : ?>
                            <div class="loglist-cover">
                                <img src="<?= $value['log_cover'] ?>" class="rea-width" data-action="zoom">
                            </div>
						<?php endif ?>
                        <div class="card-padding loglist-body">
                            <h3 class="card-title">
                                <a href="<?= $value['log_url'] ?>" class="loglist-title"><?= $value['log_title'] ?></a>
								<?php topflg($value['top'], $value['sortop'], isset($sortid) ? $sortid : '') ?>
                                <?php bloglist_sort($value['logid']) ?>
                            </h3>
                            <div class="loglist-content markdown"><?= $value['log_description'] ?></div>
                            <div class="loglist-tag"><?php blog_tag($value['logid']) ?></div>
                        </div>
                        <hr class="list-line"/>
                        <div class="row info-row">
                            <div class="log-info">
<!--vot-->							<?php blog_author($value['author']) ?>&nbsp;<?=lang('post_time')?>&nbsp;<?= gmdate('Y-m-d', $value['date']) ?>&nbsp;<span class="mh"><?= date('H:i', $value['date']) ?></span>
                            </div>
                            <div class="log-count">
<!--vot-->                      <a href="<?= $value['log_url'] ?>#comments"><?=lang('comments')?>: (<?= $value['comnum'] ?>)&nbsp;</a>
<!--vot-->                      <a href="<?= $value['log_url'] ?>"><?=lang('_views')?>: (<?= $value['views'] ?>)</a>
                            </div>
                        </div>
                    </div>
				<?php
				endforeach;
			else:
				?>
<!--vot-->          <p><?=lang('sorry_no_results')?></p>
			<?php endif ?>
            <div class="pagination bottom-5">
				<?= $page_url ?>
            </div>
        </div>
		<?php include View::getView('side') ?>
    </div>
</main>

<?php include View::getView('footer') ?>
 
