<?php
/**
 * 自建页面模板
 */
if (!defined('EMLOG_ROOT')) {
	exit('error!');
}
?>	
	 <style type="text/css">
        .page{
			background-color: #ffffff;
			border-radius: 10px;
			padding: 30px;
			margin-bottom: 29px;
		}
		
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-8 page">
                <h2><?php echo $log_title; ?></h2>
				<?php echo $log_content; ?>
				<?php blog_comments($comments); ?>
				<?php blog_comments_post($logid, $ckname, $ckmail, $ckurl, $verifyCode, $allow_remark); ?>
            </div>
			<?php
			include View::getView('side');
			?>
        </div>
    </div>
<?php
include View::getView('footer');
?>
