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
<div class="entry">
<p id="t"><?php echo $search_info; ?></p>
<?php foreach($slog as $key=>$value): ?>
<p><a href="./?action=showlog&gid=<?php echo $value['gid'];?>"><?php echo $value['title'];?></a> (<?php echo $value['date'];?>)</p>
<?php endforeach; ?>
</div>
</div>
</div>
<div id="footer">Powered by <a href="http://www.emlog.net" title="emlog <?php echo $edition;?>">emlog</a> Theme by <a href="http://www.ndesign-studio.com/">Nick La</a> </div>
</div>
<?php
include getViews('side');
?>