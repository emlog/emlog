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
	<div><b><?php echo $tag;?></b></p><small>(包含该标签的所有日志)</small></div>
<div class="entry">
<?php foreach($taglogs as $key=>$value): ?>
	<p><a href="index.php?action=showlog&gid=<?php echo $value['gid'];?>"><?php echo $value['title'];?></a> <?php echo $value['date'];?></p>
<?php endforeach; ?>
<?php echo $tagmsg;?>
</div>
</div>
<div id="footer">Powered by <a href="http://www.emlog.net" title="emlog <?php echo $edition;?>">emlog</a> Theme by <a href="http://www.ndesign-studio.com/">Nick La</a> </div>
</div>
<?php
include getViews('side');
?>