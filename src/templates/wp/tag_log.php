<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<DIV class=post id=post-1>
	<h2><?php echo $tag;?></h2>
	<p>包含该标签的所有日志</p>
<ul class="taglog">
<?php foreach($taglogs as $key=>$value): ?>
	<li><a href="index.php?action=showlog&gid=<?php echo $value['gid'];?>"><?php echo $value['title'];?></a> <?php echo $value['date'];?></li>
<?php endforeach; ?>
	</ul>
</div>
<?php
include getViews('footer');
?>