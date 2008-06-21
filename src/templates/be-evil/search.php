<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
?>
<div class="content">
	<p id="t"><?php echo $search_info; ?></p>
	<div id="t_search">
	<?php foreach($slog as $key=>$value):?>
	<li><a href="./?action=showlog&gid=<?php echo $value['gid']; ?>"><?php echo $value['title']; ?></a><?php echo $value['date'];?></li>
	<?php endforeach; ?>	
	</div>
</div>
<?php
include getViews('footer');
?>