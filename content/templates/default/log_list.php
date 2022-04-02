<?php
/**
 * 首页模板
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
                            <h4 class="card-title">
                                <a href="<?= $value['log_url'] ?>" class="loglist-title"><?= $value['log_title'] ?></a>
								<?php topflg($value['top'], $value['sortop'], isset($sortid) ? $sortid : '') ?>
                                <?php bloglist_sort($value['logid']) ?>
                            </h4>
                            <summary class="loglist-content markdown"><?= $value['log_description'] ?></summary>
                            <div class="loglist-tag"><?php blog_tag($value['logid']) ?></div>
                        </div>
                        <hr class="list-line"/>
                        <div class="row info-row">
                            <div class="log-info">
								<?php blog_author($value['author']) ?>&nbsp;发布于&nbsp;<?= date('Y-n-j', $value['date']) ?>&nbsp;<span class="mh"><?= date('H:i', $value['date']) ?></span>
                            </div>
                            <div class="log-count">
                                <a href="<?= $value['log_url'] ?>#comments">评论(<?= $value['comnum'] ?>)&nbsp;</a>
                                <a href="<?= $value['log_url'] ?>">浏览(<?= $value['views'] ?>)</a>
                            </div>
                        </div>
                    </div>
				<?php
				endforeach;
			else:
				?>
                <p>抱歉，暂时还没有内容。</p>
			<?php endif ?>
            <ul class="pagination bottom-5">
				<?= $page_url ?>
            </ul>
        </div>
		<?php include View::getView('side') ?>
    </div>
</main>

<?php include View::getView('footer') ?>
 
