<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
      <div id="nav">
        <ul>
          <li class="page_item current_page_item"><a href="./index.php" title="Home">Home</a></li>
        </ul>
      </div>
  <div id="content">
<!--
EOT;
foreach($logs as $value){
//$value[att_img] = getAttachment($value[att_img],200,120);
$datetime = explode("-",$value['post_time']);
$year = $datetime[0]."/".$datetime[1];
$day = substr($datetime[2],0,2);
echo <<<EOT
-->
        <div class="post" id="post-$value[logid]">
		  <div class="date"><span>$year</span>$day</div>
		  <div class="title">
<h2>
		  <!--
EOT;
if($isurlrewrite=='n'){
echo <<<EOT
-->
{$value['toplog']}<a href="?action=showlog&gid={$value['logid']}">{$value['log_title']}</a>
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
          <div class="postdata"><span class="comments"><a href="?action=showlog&gid=$value[com_url]" title="$value[log_title] 的评论">$value[comnum] Comments &#187;</a></span></div>

		  </div>
          <div class="entry">
$value[log_description]
<p>$value[att_img]</p>
<p>$value[attachment]</p>
<p>$value[tag]</p>

<p class="info">
<em class="caty">
  
<!--
EOT;
if($isurlrewrite=='n'){
echo <<<EOT
-->
 	<a href="?action=showlog&gid={$value['logid']}#comment">评论({$value['comnum']})</a>
 	<a href="?action=showlog&gid={$value['logid']}#tb">引用({$value['tbcount']})</a> 
 	<a href="?action=showlog&gid={$value['logid']}">浏览({$value['views']})</a>
<!--
EOT;
}else{
echo <<<EOT
-->
	<a href="showlog-{$value['logid']}.html#comment">评论({$value['comnum']})</a>
	<a href="showlog-{$value['logid']}.html#tb">引用({$value['tbcount']})</a> 
	<a href="showlog-{$value['logid']}.html">浏览({$value['views']})</a>
<!--
EOT;
}
echo <<<EOT
-->	</em>
</p>
          </div><!--/entry -->

	</div><!--/post -->
<!--
EOT;
}echo <<<EOT
-->
<p>$page_url</p>

</div><!--/content -->
<div id="footer">&copy; 2007 <a href="http://www.emlog.net" target="_blank">emlog</a> Theme by <a href="http://www.ndesign-studio.com/">Nick La</a> </div>
</div>
EOT;
include getViews('side');
?>