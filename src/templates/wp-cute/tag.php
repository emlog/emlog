<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<DIV class=post id=post-1>
<p id="t"><b>标签(Tag)</b></p>
<p>所有标签：（标签字体越大其包含的日志越多）</p>
<ul class="tagul">
<li>
<?php foreach($tags as $key=>$value): ?>
<span style="font-size:<?php echo $value['fontsize'];?>px; height:30px;"><a href="./?action=taglog&tag=<?php echo $value['tagurl'];?>"><?php echo $value['tag'];?></a></span>&nbsp;
<?php  endforeach; ?>
</li>
<?php echo $tagmsg;?>
</ul>
</div>
<?php
include getViews('footer');
?>