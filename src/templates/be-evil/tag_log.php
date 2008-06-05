<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
?>
<div class="logcontent" onmouseover="this.style.backgroundColor='#F3FAFF'" onmouseout="this.style.backgroundColor='#FFF'">
	<ul id="t">
		<li><h2>标签：<?=$tag?></h2></li>
	</ul>
	<ul class="taglog">
	<?php
	foreach($taglogs as $key=>$value){
	?>
	<li><a href="index.php?action=showlog&gid=<?=$value['gid']?>"><?=$value['title']?></a><?=$value['date']?></li>
<?php }?>
	</ul>
</div>
<?php
include getViews('footer');
?>
