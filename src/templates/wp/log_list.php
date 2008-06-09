<?php
if(!defined('EMLOG_ROOT')) {exit('error!');}

foreach($logs as $value){
?>
<DIV class=post id=post-1>
<H2>
<?php echo $value['toplog'];?><a href="./?action=showlog&gid=<?php echo $value['logid'];?>"><?php echo $value['log_title'];?></a>
</H2>
<SMALL>| <?php echo $value['post_time'];?> </SMALL>
<DIV class=entry>
<P><?php echo $value['log_description'];?></P>
</DIV>
<p><?php echo $value['att_img'];?></p>
<p><?php echo $value['attachment'];?></p>
<p style="color: #FF0000;"><?php echo $value['tag'];?></p>
<P class=postmetadata>  
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#comment">评论(<?php echo $value['comnum'];?>)</a>
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>#tb">引用(<?php echo $value['tbcount'];?>)</a> 
 	<a href="./?action=showlog&gid=<?php echo $value['logid'];?>">浏览(<?php echo $value['views'];?>)</a>
</P>
</DIV>
<?php
}?>
<div id="pageurl"> <?php echo $page_url;?></div>
<?php
include getViews('footer');
?>