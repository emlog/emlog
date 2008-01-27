<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
print <<<EOT
-->
<div class="dbx-group" id="sidebar">

      <!--sidebox start -->
      <div id="categories" class="dbx-box">
        <h3 class="dbx-handle">个人档</h3>
        <div class="dbx-content">
          <ul>
            		<p align="center">$photo</p>
					<li><b>$name</b> $blogger_des</li>
          </ul>
        </div>
      </div>
      <!--sidebox end -->

      <!--sidebox start -->
      <div id="archives" class="dbx-box">
        <h3 class="dbx-handle">日历</h3>
        <div class="dbx-content">
          <ul>
            <p id="calendar"></p>
          </ul>
        </div>
      </div>
      <!--sidebox end -->

      <!--sidebox start -->
      <div id="links" class="dbx-box">
        <h3 class="dbx-handle">标签</h3>
        <div class="dbx-content">
          <ul>
<!--
EOT;
foreach($tag_cache as $value){
print <<<EOT
-->
<span style="font-size:$value[fontsize]px; height:30px;"><a href="?action=taglog&tag=$value[tagurl]">$value[tagname]</a></span>&nbsp;
<!--
EOT;
}print <<<EOT
-->
		<a href="./index.php?action=tag" title="更多标签" >&gt;&gt;</a>
          </ul>
        </div>
      </div>
      <!--sidebox end -->

      <!--sidebox start -->
	  <!--
EOT;
if($ismusic){
print <<<EOT
-->
      <div id="meta" class="dbx-box">
        <h3 class="dbx-handle">音乐</h3>
        <div class="dbx-content">
          <ul>
 <p><object type="application/x-shockwave-flash" data="./images/player.swf?son=$music{$autoplay}&autoreplay=1" width="180" height="20"><param name="movie" value="./images/player.swf?son=$music{$autoplay}&autoreplay=1" /></object>
</p>
          </ul>
        </div>
      </div>
	  <!--
EOT;
}
print <<<EOT
-->
      <!--sidebox end -->
      <!--sidebox start -->
      <div id="recent-comments" class="dbx-box">
        <h3 class="dbx-handle">评论</h3>
        <div class="dbx-content">
          <ul>
<!--
EOT;
foreach($com_cache as $value){
print <<<EOT
-->
		<li>$value[name]<br /><a href="$value[url]">$value[content]</a></li>
<!--
EOT;
}print <<<EOT
-->
          </ul>
        </div>
      </div>
      <!--sidebox end -->
	        <!--sidebox start -->
      <div id="archives" class="dbx-box">
        <h3 class="dbx-handle">存档</h3>
        <div class="dbx-content">
          <ul>
<!--
EOT;
foreach($dang_cache as $value){
print <<<EOT
-->
		<li><a href="$value[url]">$value[record]($value[lognum])</a></li>
<!--
EOT;
}print <<<EOT
-->	
          </ul>
        </div>
      </div>
      <!--sidebox end -->
	        <!--sidebox start -->
      <div id="links" class="dbx-box">
        <h3 class="dbx-handle">Blogroll</h3>
        <div class="dbx-content">
          <ul>
<!--
EOT;
foreach($link_cache as $value){
print <<<EOT
-->     	
		<li><a href="$value[url]" title="$value[des]" target="_blank">$value[link]</a></li>
<!--
EOT;
}print <<<EOT
-->
          </ul>
        </div>
      </div>
      <!--sidebox end -->
	        <!--sidebox start -->
      <div id="meta" class="dbx-box">
        <h3 class="dbx-handle">统计</h3>
        <div class="dbx-content">
          <ul>
		<li>日志数量：$sta_cache[lognum]</li>
		<li>评论数量：$sta_cache[comnum]</li>
		<li>引用数量：$sta_cache[tbnum]</li>
		<li>今日访问：$sta_cache[day_view_count]</li>
		<li>总访问量：$sta_cache[view_count]</li>
		<li><a href="./adm/">登录</a></li>
		<li class="rss"><a href="./rss.php">Rss Feed</a></li>
          </ul>
        </div>
      </div>
      <!--sidebox end -->
	  $exarea
</div><!--/sidebar -->
    <hr class="hidden" />

  </div><!--/wrapper -->

</div><!--/page -->

</body>
</html>
<!--
EOT;
?>-->