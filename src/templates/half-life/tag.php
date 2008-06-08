<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
	<div class="narrowcolumn">
	<div class="post">
<p id="t"><b>标签</b></p>
<p>所有标签：（标签字体越大其包含的日志越多）</p>
<p id="tags">
<?php
foreach($tags as $key=>$value){
?>
<span style="font-size:<?php echo $value['fontsize'];?>px; height:30px;"><a href="./?action=taglog&tag=<?php echo $value['tagurl'];?>"><?php echo $value['tag'];?></a></span>&nbsp;
<?php
}?>
<?php echo $tagmsg;?>
</div>
</div>
<?php
include getViews('obar');
include getViews('footer');
?>