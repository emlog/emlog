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
                                <a href="<?php echo $value['log_url']; ?>"></a>
                                <img src="<?php echo $value['log_cover']; ?>" class="rea-width" data-action="zoom">
                            </div>
                            <div class="clip"></div>
						<?php endif; ?>
                        <div class="card-padding loglist-body">
                            <h3 class="card-title">
                                <a href="<?php echo $value['log_url']; ?>" class="loglist-title"><?php echo $value['log_title']; ?></a>
								<?php topflg($value['top'], $value['sortop'], isset($sortid) ? $sortid : ''); ?>
                            </h3>
                            <summary class="loglist-content markdown"><?php echo $value['log_description']; ?></summary>
                            <div class="loglist-tag"><?php blog_tag($value['logid']); ?></div>
                        </div>
                        <hr class="list-line"/>
                        <div class="row info-row">
                            <div class="log-info">
<!--vot-->							<?php blog_author($value['author']); ?>&nbsp;<?=lang('post_time')?>&nbsp;<?php echo gmdate('Y-m-d', $value['date']); ?>&nbsp;<span class="mh"><?php echo gmdate('H:i', $value['date']); ?></span>
                            </div>
                            <div class="log-count">
<!--vot-->                      <a href="<?php echo $value['log_url']; ?>#comments"><?=lang('comments')?>: (<?php echo $value['comnum']; ?>)&nbsp;</a>
<!--vot-->                      <a href="<?php echo $value['log_url']; ?>"><?=lang('_views')?>: (<?php echo $value['views']; ?>)</a>
                            </div>
                        </div>
                    </div>
				<?php
				endforeach;
			else:
				?>
<!--vot-->          <p><?=lang('sorry_no_results')?></p>
			<?php endif; ?>
            <ul class="pagination bottom-5">
				<?php echo $page_url; ?>
            </ul>
        </div>
		<?php include View::getView('side'); ?>
    </div>
</main>

<?php include View::getView('footer'); ?>
 
