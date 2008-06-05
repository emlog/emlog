<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
?>
<div class="content">
	<p id="t">$search_info</p>
	<div id="t_search">
	<?php
	foreach($slog as $key=>$value){
	?>
	<li><a href="./?action=showlog&gid=<?=$value['gid']?>"><?=$value['title']?></a><?={$value['date']}?></li>
	<?php }?>	
	</div>
</div>
<?php
include getViews('footer');
?>