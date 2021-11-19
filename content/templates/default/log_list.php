<?php
/**
 * 首页模板
 */
if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-8">
			<?php
			doAction('index_loglist_top');
			if (!empty($logs)):
				foreach ($logs as $value):
					?>
                    <div class="row loglist_body no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                        <div class="col p-3 d-flex flex-column position-static">
                            <h3 class="mb-0">
                                <a href="<?php echo $value['log_url']; ?>" class="loglist_title"><?php echo $value['log_title']; ?></a>
								<?php topflg($value['top'], $value['sortop'], isset($sortid) ? $sortid : ''); ?>
                            </h3>
                            <div class="text-muted mt-1"><?php blog_author($value['author']); ?> 发布于 <?php echo date('Y-m-d H:i', $value['date']); ?></div>
                            <div class="loglist_content markdown"><?php echo subContent($value['log_description'],280); ?></div>
                            <div class="tag loglist_tag"><?php blog_tag($value['logid']); ?></div>
                            <div class="mt-2">
                                <a href="<?php echo $value['log_url']; ?>#comments">评论(<?php echo $value['comnum']; ?>)</a>
                                <a href="<?php echo $value['log_url']; ?>">浏览(<?php echo $value['views']; ?>)</a>
                            </div>
                        </div>
						<?php if (!empty($value['log_cover'])) : ?>
                            <div class="col-auto d-none d-lg-block">
                                <a href="<?php echo $value['log_url']; ?>">
                                    <img class="rounded m-2" width="300" height="200" src="<?php echo $value['log_cover']; ?>">
                                </a>
                            </div>
						<?php endif; ?>
                    </div>
				<?php
				endforeach;
			else:
				?>
                <p>抱歉，暂时还没有内容。</p>
			<?php endif; ?>
            <ul class="pagination justify-content-center">
				<?php echo $page_url; ?>
            </ul>
        </div>
		<?php include View::getView('side'); ?>
    </div>
</div>
<?php include View::getView('footer'); ?>
