<!--<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
echo <<<EOT
-->
<div class="dbx-group" id="sidebar">

      <!--sidebox start -->
      <div id="categories" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('blogger')">个人档</h3>
        <div class="dbx-content" id="blogger">
          <ul>
            		<p align="center">$photo</p>
					<li><b>$name</b> $blogger_des</li>
          </ul>
        </div>
      </div>
      <!--sidebox end -->

      <!--sidebox start -->
      <div id="archives" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('calendar')">日历</h3>
        <div class="dbx-content">
          <ul>
            <div id="calendar"></div>
          </ul>
        </div>
      </div>
	  <script>sendinfo('$calendar_url','calendar');</script>
      <!--sidebox end -->

      <!--sidebox start -->
      <div id="links" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('tags')">标签</h3>
        <div class="dbx-content" id="tags">
          <ul>
<!--
EOT;
foreach($tag_cache as $value){
echo <<<EOT
-->
<span style="font-size:$value[fontsize]px; height:30px;"><a href="./?action=taglog&tag=$value[tagurl]">$value[tagname]</a></span>&nbsp;
<!--
EOT;
}echo <<<EOT
-->
		<a href="./index.php?action=tag" title="更多标签" >&gt;&gt;</a>
          </ul>
        </div>
      </div>
<!--
EOT;
if($index_twnum>0){
echo <<<EOT
-->
<div id="meta" class="dbx-box">
<h3 onclick="showhidediv('twitter')" class="dbx-handle">twitter</h3>
<div class="dbx-content">
<ul id="twitter">
<!--
EOT;
$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
foreach (array_slice($tw_cache,0,$index_twnum) as $value)
{
	$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
	$value['date'] = SmartyDate($localdate,$value['date']);
echo <<<EOT
-->
<li> {$value['content']} $delbt<br><span>{$value['date']}</span></li>
<!--
EOT;
}
echo <<<EOT
-->
$morebt
</ul>
<!--
EOT;
if(ISLOGIN === true)
{
echo <<<EOT
-->
<ul>
<li><a href="javascript:void(0);" onclick="showhidediv('addtw')">我要唠叨</a></li>
<li id='addtw' style="display: none;">
<textarea name="tw" id="tw" style="width:150px;" style="height:50px;"></textarea><br />
<input type="button" onclick="postinfo('./twitter.php?action=add','twitter');" value="提交">
</li>
</ul>
<!--
EOT;
}
echo <<<EOT
-->
</div>
</div>
<!--
EOT;
}
if($ismusic){
echo <<<EOT
-->
      <div id="meta" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('music')">音乐</h3>
        <div class="dbx-content" id="music">
          <ul>
 <p>$musicdes<object type="application/x-shockwave-flash" data="./images/player.swf?son=$music{$autoplay}&autoreplay=1" width="180" height="20"><param name="movie" value="./images/player.swf?son=$music{$autoplay}&autoreplay=1" /></object>
</p>
          </ul>
        </div>
      </div>
	  <!--
EOT;
}
echo <<<EOT
-->
      <!--sidebox end -->
      <!--sidebox start -->
      <div id="recent-comments" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('comm')">评论</h3>
        <div class="dbx-content" id="comm">
          <ul>
<!--
EOT;
foreach($com_cache as $value){
echo <<<EOT
-->
		<li>$value[name]<br /><a href="$value[url]">$value[content]</a></li>
<!--
EOT;
}echo <<<EOT
-->
          </ul>
        </div>
      </div>
      <!--sidebox end -->
	        <!--sidebox start -->
      <div id="archives" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('dang')">存档</h3>
        <div class="dbx-content" id="dang">
          <ul>
<!--
EOT;
foreach($dang_cache as $value){
echo <<<EOT
-->
		<li><a href="$value[url]">$value[record]($value[lognum])</a></li>
<!--
EOT;
}echo <<<EOT
-->	
          </ul>
        </div>
      </div>
      <!--sidebox end -->
	        <!--sidebox start -->
      <div id="links" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('blogroll')">Blogroll</h3>
        <div class="dbx-content" id="blogroll">
          <ul>
<!--
EOT;
foreach($link_cache as $value){
echo <<<EOT
-->     	
		<li><a href="$value[url]" title="$value[des]" target="_blank">$value[link]</a></li>
<!--
EOT;
}echo <<<EOT
-->
          </ul>
        </div>
      </div>
      <!--sidebox end -->
	        <!--sidebox start -->
      <div id="meta" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('qita')">其他</h3>
        <div class="dbx-content" id="qita">
          <ul>
		<li>日志数量：$sta_cache[lognum]</li>
		<li>评论数量：$sta_cache[comnum]</li>
		<li>引用数量：$sta_cache[tbnum]</li>
		<li>今日访问：$sta_cache[day_view_count]</li>
		<li>总访问量：$sta_cache[view_count]</li>
<!--
EOT;
if(ISLOGIN === false){
	$login_code=='y'?
	$ckcode = "验证码:<br />
				<input name=\"imgcode\" type=\"text\" class=\"INPUT\" size=\"5\">&nbsp&nbsp\n
				<img src=\"./lib/C_checkcode.php\" align=\"absmiddle\"></td></tr>\n":
	$ckcode = '';
echo <<<EOT
--> 
<li><span onclick="showlogin('loginfm')" style="cursor:pointer;">登录</span></li>
<div id="loginfm" style="display: none;">
<form name="f" method="post" action="index.php?action=login" id="commentform">
用户名:<br>
<input name="user" type="text"><br />
密  码:<br>
<input name="pw" type="password"><br>
$ckcode <br>
<input type="submit" value=" 登录">
</form>
</div>
<!--
EOT;
}else{
echo <<<EOT
-->
	<li>---------------------</li>
	<li><a href="./adm/add_log.php">写日志</a></li>
	<li><a href="./adm/">管理中心</a></li>
	<li><a href="./index.php?action=logout">退出</a></li>
<!--
EOT;
}
echo <<<EOT
-->
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