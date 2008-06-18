<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="post">
	<p><b><?php echo $tag;?></b></p>
	<p><small>包含该标签的所有日志：</small></p>
<ul class="taglog">
<?php foreach($taglogs as $key=>$value): ?>
	<li><a href="index.php?action=showlog&gid=<?php echo $value['gid'];?>"><?php echo $value['title'];?></a> <?php echo $value['date'];?></li>
<?php endforeach; ?>
	</ul>
</div>
<?php
?>
</div>
<?php
include getViews('side');
include getViews('footer');
?>