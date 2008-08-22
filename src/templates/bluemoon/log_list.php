<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>

<div id="content">
	<div class="left"><div class="lpadding">
		<?php include getViews('side'); ?>
	</div></div>
	<div class="right">
		<?php foreach($logs as $value):?>
		<div class="title">
			<h1><a href="./?action=showlog&gid=<?php echo $value['logid']; ?>" target="_self"><?php echo $value['log_title']; ?></a></h1>
			<h4><?php echo $value['tag']; ?> by <?php echo $value['name']; ?> on <?php echo $value['post_time']; ?></h4>
		</div>
		<div class="logdes">
		<?php echo $value['log_description']; ?>
		<p><?php echo $value['att_img']; ?></p>
		<p><?php echo $value['attachment']; ?></p>
		</div>
		<div class="clear"></div>
		<div class="permalink">
		<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#comment">评论(<?php echo $value['comnum']; ?>)</a>|
		<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>#tb">引用(<?php echo $value['tbcount']; ?>)</a>|
		<a href="./?action=showlog&gid=<?php echo $value['logid']; ?>">浏览(<?php echo $value['views']; ?>)</a>
		</div>
		<div class="div1"></div>
		<?php endforeach; ?>
		<div id="pageurl"><?php echo $page_url;?></div>
	</div>
	
	<div class="clear"></div>
</div>
<?php include getViews('footer'); ?>
