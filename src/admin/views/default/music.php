<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
	<div class=containertitle><b>背景音乐</b></div>
	<div class=line></div>
  <form action="music.php?action=mod" method="post" name="blooger" id="blooger" enctype="multipart/form-data">
    <p style="margin:10px 30px;">启用背景音乐 <input id="switch" type="checkbox" value="1" name="ismusic" <?php echo $ismusic; ?>/></p>
	<div style="margin:10px 30px;">
	<p>音乐链接：(每行只能输入一条音乐链接，暂时只支持mp3格式。也可以在链接后空一格写一些简短的介绍文字)<br />
	  <textarea name="mlinks" cols="90" rows="10" wrap="off"><?php echo $content; ?></textarea>
	</p>
	<p>启用随机播放：
      <input type="radio" value="1" name="randplay" <?php echo $randplay1; ?>/>是
	  <input type="radio" value="0" name="randplay" <?php echo $randplay2; ?>/>否
	  <span class="care">(启用后将在音乐链接表中随机选取播放，如不启用则播放第一行链接所指向的音乐)</span>
	<br />启用自动播放：
      <input type="radio" value="1" name="auto" <?php echo $auto1; ?>/>是
	  <input type="radio" value="0" name="auto" <?php echo $auto2; ?>/>否
	</p>
	<input type="submit" value="确 定" class="submit2" />
	</div>
  </form>