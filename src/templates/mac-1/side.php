<?php 
if(!defined('EMLOG_ROOT')) {exit('error!');}
?>
<div class="dbx-group" id="sidebar">

     
      <div id="categories" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('blogger')">个人档</h3>
        <div class="dbx-content" id="blogger">
          <ul>
            		<p align="center"><?php echo $photo;?></p>
					<li><b><?php echo $name;?></b> <?php echo $blogger_des;?></li>
          </ul>
        </div>
      </div>
     
      <div id="archives" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('calendar')">日历</h3>
        <div class="dbx-content">
          <ul>
            <div id="calendar"></div>
          </ul>
        </div>
      </div>
	  <script>sendinfo('<?php echo $calendar_url;?>','calendar');</script>
     
      <div id="links" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('tags')">标签</h3>
        <div class="dbx-content" id="tags">
          <ul>
<?php foreach($tag_cache as $value): ?>
<span style="font-size:<?php echo $value['fontsize'];?>px; height:30px;"><a href="./?action=taglog&tag=<?php echo $value['tagurl'];?>"><?php echo $value['tagname'];?></a></span>&nbsp;
<?php endforeach; ?>
		<a href="./index.php?action=tag" title="更多标签" >&gt;&gt;</a>
          </ul>
        </div>
      </div>
<?php if($index_twnum>0): ?>
<div id="meta" class="dbx-box">
<h3 onclick="showhidediv('twitter')" class="dbx-handle">twitter</h3>
<div class="dbx-content">
<ul id="twitter">
<?php  if(isset($tw_cache) && is_array($tw_cache)):
$morebt = count($tw_cache)>$index_twnum?"<li id=\"twdate\"><a href=\"javascript:void(0);\" onclick=\"sendinfo('twitter.php?p=2','twitter')\">较早的&raquo;</a></li>":'';
foreach (array_slice($tw_cache,0,$index_twnum) as $value):
	$delbt = ISLOGIN === true?"<a href=\"javascript:void(0);\" onclick=\"isdel('{$value['id']}','twitter')\">删除</a>":'';
	$value['date'] = smartyDate($localdate,$value['date']);
?>
<li> <?php echo $value['content'];?> <?php echo $delbt;?><br><span><?php echo $value['date'];?></span></li>
<?php  endforeach; ?>
<?php echo $morebt; ?>
<?php endif; ?>
</ul>
<?php if(ISLOGIN === true): ?>
<ul>
<li><a href="javascript:void(0);" onclick="showhidediv('addtw')">我要唠叨</a></li>
<li id='addtw' style="display: none;">
<textarea name="tw" id="tw" style="width:150px;" style="height:50px;"></textarea><br />
<input type="button" onclick="postinfo('./twitter.php?action=add','twitter');" value="提交">
</li>
</ul>
<?php endif; ?>
</div>
</div>
<?php endif; ?>
<?php if($ismusic): ?>
      <div id="meta" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('music')">音乐</h3>
        <div class="dbx-content" id="music">
          <ul>
 <?php echo $musicdes;?><object type="application/x-shockwave-flash" data="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" width="180" height="20"><param name="movie" value="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay;?>&autoreplay=1" /></object>
</p>
          </ul>
        </div>
      </div>
<?php endif; ?>
      
      <div id="recent-comments" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('comm')">评论</h3>
        <div class="dbx-content" id="comm">
          <ul>
<?php foreach($com_cache as $value): ?>
		<li><?php echo $value['name'];?><br /><a href="<?php echo $value['url'];?>"><?php echo $value['content'];?></a></li>
<?php endforeach; ?>
          </ul>
        </div>
      </div>
    
      <div id="archives" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('dang')">存档</h3>
        <div class="dbx-content" id="dang">
          <ul>
<?php foreach($dang_cache as $value): ?>
		<li><a href="<?php echo $value['url'];?>"><?php echo $value['record'];?>(<?php echo $value['lognum'];?>)</a></li>
<?php endforeach; ?>	
          </ul>
        </div>
      </div>
      <div id="links" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('blogroll')">Blogroll</h3>
        <div class="dbx-content" id="blogroll">
          <ul>
<?php foreach($link_cache as $value): ?>     	
		<li><a href="<?php echo $value['url'];?>" title="<?php echo $value['des'];?>" target="_blank"><?php echo $value['link'];?></a></li>
<?php endforeach; ?>
          </ul>
        </div>
      </div>
     
      <div id="meta" class="dbx-box">
        <h3 class="dbx-handle" onclick="showhidediv('qita')">其他</h3>
        <div class="dbx-content" id="qita">
          <ul>
		<li>日志数量：<?php echo $sta_cache['lognum'];?></li>
		<li>评论数量：<?php echo $sta_cache['comnum'];?></li>
		<li>引用数量：<?php echo $sta_cache['tbnum'];?></li>
		<li>今日访问：<?php echo $sta_cache['day_view_count'];?></li>
		<li>总访问量：<?php echo $sta_cache['view_count'];?></li>
<?php 
if(ISLOGIN === false):
	$login_code=='y'?
	$ckcode = "验证码:<br />
				<input name=\"imgcode\" type=\"text\" class=\"INPUT\" size=\"5\">&nbsp&nbsp\n
				<img src=\"./lib/C_checkcode.php\" align=\"absmiddle\"></td></tr>\n":
	$ckcode = '';
?> 
<li><span onclick="showhidediv('loginfm','user')" style="cursor:pointer;">登录</span></li>
<div id="loginfm" style="display: none;">
<form name="f" method="post" action="index.php?action=login" id="commentform">
用户名:<br>
<input name="user" id="user" type="text"><br />
密  码:<br>
<input name="pw" type="password"><br>
<?php echo $ckcode;?> <br>
<input type="submit" value=" 登录">
</form>
</div>
<?php
else:
?>
	<li>---------------------</li>
	<li><a href="./adm/add_log.php">写日志</a></li>
	<li><a href="./adm/">管理中心</a></li>
	<li><a href="./index.php?action=logout">退出</a></li>
<?php endif; ?>
		<li class="rss"><a href="./rss.php">Rss Feed</a></li>
          </ul>
        </div>
      </div>
   
	  <?php echo $exarea;?>
</div>
    <hr class="hidden" />

  </div>

</div>

</body>
</html>
<?php
?>