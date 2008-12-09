<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
      <div id="nav">
        <ul>
          <li class="page_item current_page_item"><a href="./index.php" title="Home">Home</a></li>
        </ul>
      </div>
  <div id="content">
<?php
foreach($logs as $value):
$datetime = explode("-",$value['post_time']);
$year = $datetime['0']."/".$datetime['1'];
$day = substr($datetime['2'],0,2);
$topFlg = $value['toplog'] == 'y' ? "<img src=\"{$em_tpldir}images/import.gif\" align=\"absmiddle\"  alt=\"推荐日志\" />" : '';
?>
        <div class="post" id="post-<?php echo $value['logid'];?>">
		  <div class="date"><span><?php echo $year;?></span><?php echo $day?></div>
		  <div class="title">
<h2>
<?php echo $topFlg; ?><a href="./?action=showlog&gid=<?php echo $value['logid'];?>"><?php echo $value['log_title'];?></a>
</h2>
          <div class="postdata"><span class="comments"><a href="./?action=showlog&gid=<?php echo $value['logid'];?>#comment" title="<?php echo $value['log_title'];?> 的评论"><?php echo $value['comnum'];?> Comments &#187;</a></span></div>

		  </div>
          <div class="entry">
<?php echo $value['log_description'];?>
<p><?php echo $value['att_img'];?></p>
<p><?php echo $value['attachment'];?></p>
<p><?php echo $value['tag'];?></p>

<p class="info">
<em class="caty">
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>
</em>
</p>
          </div>

	</div>
<?php endforeach; ?>
<p><?php echo $page_url;?></p>

</div>
<div id="footer">Powered by <a href="http://www.emlog.net" title="emlog <?php echo EMLOG_VERSION;?>">emlog</a> Theme by <a href="http://www.ndesign-studio.com/">Nick La</a> </div>
</div>
<?php
include getViews('side');
?>