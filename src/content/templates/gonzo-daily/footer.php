<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
	<div id="sidebarFrame">	

	<?php
		include getViews('sidebar_top');
		include getViews('sidebar_left');
		include getViews('sidebar_right');
	?>
	</div>

	<div id="footer">
		<p>
		Powered by <a href="http://www.emlog.net" title="emlog <?php echo EMLOG_VERSION;?>">emlog</a>.
		<a href="http://greatgonzo.net/projects/gonzodaily">GonzoDaily</a> theme by <a href="http://greatgonzo.net">Gonzo</a>.
		 <a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a>
		</p>
		<p>
		<a href="<?php echo BLOG_URL; ?>rss.php">Entries <abbr title="Really Simple Syndication">RSS</abbr></a>
		</p>
<?php doAction('index_footer'); ?>

	</div>
	
</body>
</html>