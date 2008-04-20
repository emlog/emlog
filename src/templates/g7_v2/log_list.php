<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value){
//$value[att_img] = getAttachment($value[att_img],200,120);
$datetime = explode("-",$value['post_time']);
$year = $datetime[0]."/".$datetime[1];
$day = substr($datetime[2],0,2);
echo <<<EOT
-->
<div class="post">
	<div class="postdate">
	  <p class="date">{$day}th</p>
	  <p class="year">$year</p>
	</div>
	<div class="posttitle">
    <h2>
	<!--
EOT;
if($isurlrewrite=='n'){
echo <<<EOT
-->
{$value['toplog']}<a href="./?action=showlog&gid={$value['logid']}">{$value['log_title']}</a>
<!--
EOT;
}else{
echo <<<EOT
-->
{$value['toplog']}<a href="showlog-{$value['logid']}.html">{$value['log_title']}</a>
<!--
EOT;
}echo <<<EOT
-->
	</h2>
      <p class="postmeta">
	  
	  <!--
EOT;
if($isurlrewrite=='n'){
	echo <<<EOT
	-->
 	<a href="./?action=showlog&gid={$value['logid']}#tb">引用通告({$value['tbcount']})</a> 
 	<a href="./?action=showlog&gid={$value['logid']}">浏览人次({$value['views']})</a>
	<!--
EOT;
}else{
	echo <<<EOT
-->

	<a href="showlog-{$value['logid']}.html#tb">引用通告({$value['tbcount']})</a> 
	<a href="showlog-{$value['logid']}.html">浏览人次({$value['views']})</a>
<!--
EOT;
}
echo <<<EOT
-->
	  
	  <span class="comment"><a href="./?action=showlog&gid={$value['logid']}#comment">评论:{$value['comnum']}</a></span></p>
    </div>

	<div class="content">
				<p>$value[log_description]</p>
				<p>$value[att_img]</p>
				<p>$value[attachment]</p>
				<p>$value[tag]</p>
				<p class="postinfo">			
	</div>
<p>
	
</p>				

</div>
<!--
EOT;
}echo <<<EOT
-->
<div class="nav">
<p>$page_url</p>
</div>
</div>
</div>
EOT;
include getViews('footer');
?>