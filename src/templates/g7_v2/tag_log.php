<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="post">
<div class="content">
	<h2><b><?php echo $tag;?></b></h2>
	<p><small>包含该标签的所有日志：</small></p>
<ul>
<?php
foreach($taglogs as $key=>$value){
?>
	<li><a href="index.php?action=showlog&gid=<?php echo $value['gid'];?>"><?php echo $value['title'];?></a> <?php echo $value['date'];?></li>
<?php
}?>
	</ul>
</div>
<?php
?>
</div>
</div>
</div>
<?php
include getViews('footer');
?>