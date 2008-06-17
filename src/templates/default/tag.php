<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}
//include getViews('side');
?>
<div class="content">
<p id="t"><b>标签</b></p>
<p>所有标签：（标签字体越大其包含的日志越多）</p>
<p id="tags">
<?php foreach($tags as $key=>$value): ?>
<span style="font-size:<?php echo $value['fontsize']; ?>px; height:30px;"><a href="./?action=taglog&tag=<?php echo $value['tagurl']; ?>"><?php echo $value['tag']; ?></a></span>&nbsp;
<?php endforeach; ?>
<?php echo $tagmsg; ?>
</p>
</div>
<?php include getViews('footer'); ?>