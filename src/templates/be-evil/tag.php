<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
include getViews('side');
?>
<div class="logcontent" onmouseover="this.style.backgroundColor='#F3FAFF'" onmouseout="this.style.backgroundColor='#FFF'">
<p id="t"><h2><?php echo $blogname;?>的标签</h2></p>
<p>所有标签：（标签字体越大其包含的日志越多）</p>
<p id="tags">
</p>
<?php foreach($tags as $key=>$value): ?>
<span style="font-size:<?php echo $value['fontsize']; ?>px; height:30px;"><a href="./?action=taglog&tag=<?php echo $value['tagurl']; ?>"><?php echo $value['tag']; ?></a></span>&nbsp;
<?php  endforeach; ?>
<?php echo $tagmsg;?>
</p>
</div>
<?php
include getViews('footer');
?>