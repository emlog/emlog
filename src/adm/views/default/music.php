<!--
<?php 
if(!defined('ADM_ROOT')) {exit('error!');}
print <<<EOT
-->
	<div class=containertitle><b>背景音乐</b></div>
	<div class=line></div>
  <form action="music.php?action=mod" method="post" name="blooger" id="blooger" enctype="multipart/form-data">
    <p style="margin:10px 30px;">启用背景音乐 <input id="switch" type="checkbox" value="1" name="ismusic" $ismusic/></p>
	<div style="margin:10px 30px;">
	<p>音乐链接：(每行只能输入一条音乐链接，暂时只支持mp3格式 如：http://www.emlog.net/music/jay.mp3)<br />
	  <textarea name="mlinks" cols="80" rows="10">$content</textarea>
	</p>
	<p>启用随机播放：
      <input type="radio" value="1" name="randplay" $randplay1/>是
	  <input type="radio" value="0" name="randplay" $randplay2/>否
	  <span class="care">(启用后将在音乐链接表中随机选取播放，如不启用则播放第一行链接所指向的音乐)</span>
	<br />启用自动播放：
      <input type="radio" value="1" name="auto" $auto1/>是
	  <input type="radio" value="0" name="auto" $auto2/>否
	</p>
	<input type="submit" value="确 定" class="submit2" />
	</div>
  </form>
<!--
EOT;
?>-->