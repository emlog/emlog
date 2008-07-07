<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
?>
<div id="content">
<div id="tag"><p>标签：<b><?php echo $tag; ?></b></p>
<ul>
<?php foreach($taglogs as $key=>$value): ?>
	<li><a href="index.php?action=showlog&gid=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a> <?php echo $value['date']; ?></li>
<?php endforeach; ?>
</ul>
</div>
</div>
<?php include getViews('footer'); ?>