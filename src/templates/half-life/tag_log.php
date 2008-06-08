<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
	<div class="narrowcolumn">
	<div class="post">
	<ul id="t">
		<p><b><?php echo $tag;?></b></p><small>(包含该标签的所有日志)</small>
	</ul>
<ul class="taglog">
<?php
foreach($taglogs as $key=>$value){
?>
	<p><a href="index.php?action=showlog&gid=<?php echo $value['gid'];?>"><?php echo $value['title'];?></a> <?php echo $value['date'];?></p>
<?php
}?>
	</ul>
</div>
</div>
<?php
include getViews('obar');
include getViews('footer');
?>