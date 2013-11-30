<?php 
/*
* 底部信息
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
	</div>
    <!-- Content end -->
    <div class="clear"></div>
    <!-- FriendLink begin -->
	<?php 
	global $CACHE; 
	$link_cache = $CACHE->readCache('link');
	?>
		<div class="friendlink">
			<h3>友情链接</h3>
			<ul>
				<?php foreach($link_cache as $value): ?>
				<li><a href="<?php echo $value['url']; ?>" title="<?php echo $value['des']; ?>" target="_blank"><?php echo $value['link']; ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
    <!-- FriendLink end -->
    <!-- Footer begin -->
    <div id="footer">
	<script src="<?php echo TEMPLATE_URL; ?>js/function.js" type="text/javascript"></script>
        <p>Copyright &copy; <?php echo date("Y"); ?> <a href="<?php echo BLOG_URL; ?>"><?php echo $blogname; ?></a> All rights reserved.</p>
        <p>Powered by <a href="http://www.emlog.net" title="emlog 3.5.2">emlog</a> | 主题设计: <a href="http://www.wpyou.com/"  target="_blank">WPYOU</a> <a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a> <?php doAction('index_footer'); ?></p>
    </div>
    <!-- Footer end -->
</div>
<!-- Container end -->
<div class="cbtm"></div>
</div>
<!-- Wrapper end -->
<!--[if lte IE 6]>
<script type="text/javascript" src="<?php echo TEMPLATE_URL; ?>/js/DD_belatedPNG.js"></script>
<script type="text/javascript">
	DD_belatedPNG.fix('#png,.png,.container,.ctop,.cbtm,.logo,.searchform,.navi,.featuredicon,.post h2,.readmore,.ptags,.pcomments,.friendlink h3');
</script>
<![endif]-->
</body>
</html>