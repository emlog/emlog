<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div id="nav">
<ul>
<li class="page_item current_page_item"><a href="./index.php" title="Home">Home</a></li>
</ul>
</div>
  <div id="content">
  
<div class="post">
<div><b>所有标签：</b>（标签字体越大其包含的日志越多）</div>
<div class="entry">
<?php
foreach($tags as $key=>$value){
?>
<span style="font-size:<?php echo $value['fontsize'];?>px; height:30px;"><a href="./?action=taglog&tag=<?php echo $value['tagurl'];?>"><?php echo $value['tag'];?></a></span>&nbsp;
<?php
}?>
<?php echo $tagmsg;?>
</div>
</div>
<div id="footer">&copy; 2008 <a href="http://www.emlog.net" target="_blank">emlog</a> Theme by <a href="http://www.ndesign-studio.com/">Nick La</a> </div>
</div>
<?php
include getViews('side');
?>