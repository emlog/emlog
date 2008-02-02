<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
foreach($logs as $value){
//$value[att_img] = getAttachment($value[att_img],200,120);
echo <<<EOT
-->
<div class="content">
            <div class="post" id="post-$value[logid]">
                <h2>$value[toplog]<a href="?action=showlog&gid=$value[logid]">$value[log_title]</a></h2>
			</div>

				<div class="date">
					<span class="postdate">Posted on $value[post_time]</span>
				</div>
<div class="mypost">

				$value[log_description]
				<p>$value[att_img]</p>
				<p>$value[attachment]</p>
				<p>$value[tag]</p>
				<p class="postinfo">				  
				 <a href="?action=showlog&gid=$value[com_url]">评论($value[comnum])</a>
				 <a href="?action=showlog&gid=$value[tb_url]">引用($value[tbcount])</a> 
				 <a href="?action=showlog&gid=$value[logid]">浏览($value[views])</a>
				</p>				

</div>
</div>
<!--
EOT;
}echo <<<EOT
-->
<div id="pagenavi"><div class="wp-pagenavi">
<span class="mypost">$page_url</span>
</div>
</div>
<!--
EOT;
echo <<<EOT
-->
</div>
EOT;
include getViews('side');
include getViews('footer');
?>