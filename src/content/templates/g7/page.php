<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class="content">
		<div class="post" id="post-$logid">
		<h2>
		<?php echo $log_title;?>
		</div>
		</h2>
		<div class="mypost">
		<?php echo $log_content;?>
		<p><?php blog_att($logid); ?></p>
		</div>
</div>
	<?php if ($allow_remark == 'y'):?>
	<div id="comments"><div class="content_c">
	<?php
		blog_comments();
		blog_comments_post();
	?>
	</div></div>
	<?php endif;?>

</div>
<?php
include getViews('side');
include getViews('footer');
?>