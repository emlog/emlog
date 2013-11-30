<?php 
/*
* 自建页面模板
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<!-- Article begin -->
<div class="article">
	<div class="post single">
		<h2><?php echo $log_title; ?></h2>
		<!-- Entry begin -->
		<div class="entry">
		<?php echo $log_content; ?>
		</div>
		<!-- Entry end -->
		<div class="related">
			<div class="related_post">
				<h3>热门文章</h3>
				<ul>
				<?php
					$DB = MySql::getInstance();
					$sql = "SELECT gid,title FROM " . DB_PREFIX . "blog WHERE hide='n' AND type='blog' ORDER BY comnum DESC LIMIT 5";
					$query  = $DB->query($sql);
					while($row = $DB->fetch_array($query)) {
				?>
					<li><a href="<?php echo Url::log($row['gid']); ?>"><?php echo htmlspecialchars($row['title']); ?></a></li>
					<?php }?>
				</ul>
			</div>
			<div class="related_post">
				<h3>随机文章</h3>
				<ul>
				<?php
					$index_randlognum = Option::get('index_randlognum');
					$Log_Model = new Log_Model();
					$randLogs = $Log_Model->getRandLog($index_randlognum);?>
				<?php foreach($randLogs as $value): ?>
				<li><a href="<?php echo Url::log($value['gid']); ?>"><?php echo $value['title']; ?></a></li>
				<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<!-- Article end -->
<!-- Sidebar begin -->
	<?php  include View::getView('side'); ?>
<!-- Sidebar end -->
<?php include View::getView('footer'); ?>