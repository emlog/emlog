<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value){
	$value['att_img'] = getAttachment($value['att_img'],200,120);
	$datetime = explode("-",$value['post_time']);
	$year = $datetime['0'] . "/" .$datetime['1'];
	$day = substr($datetime['2'],0,2);
	?>
<div class="post">
	<div class="postdate">
	  <p class="date"><?php echo $day;?>th</p>
	  <p class="year"><?php echo $year;?></p>
	</div>
	<div class="posttitle">
    <h2>
<?php echo $value['toplog'];?><a href="./?action=showlog&gid=<?php echo $value['logid'];?>"><?php echo $value['log_title'];?></a>
	</h2>
      <p class="postmeta">
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#tb">引用通告(<?php echo $value['tbcount'];?>)</a> 
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>">浏览人次(<?php echo $value['views'];?>)</a>
	  <span class="comment"><a href="./?action=showlog&gid=<?php echo $value['logid'];?>#comment">评论:<?php echo $value['comnum'];?></a></span>
</p>
    </div>

	<div class="content">
				<p><?php echo $value['log_description'];?></p>
				<p><?php echo $value['att_img'];?></p>
				<p><?php echo $value['attachment'];?></p>
				<p><?php echo $value['tag'];?></p>
				<p class="postinfo">			
	</div>
<p>
	
</p>				

</div>
<?php
}?>
<div class="nav">
<p><?php echo $page_url;?></p>
</div>
</div>
</div>
<?php
include getViews('footer');
?>