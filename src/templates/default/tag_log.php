<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
//include getViews('side');
?>
<div class="content">
<ul id="t">
<li>标签： <b><?php echo $tag; ?></b></li>
</ul>
<ul class="taglog">
<?php foreach($taglogs as $key=>$value): ?>
	<li><a href="index.php?action=showlog&gid=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a> <?php echo $value['date']; ?></li>
<?php endforeach; ?>
</ul>
</div>
<?php include getViews('footer'); ?>