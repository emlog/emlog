<div id="footer-holder">
  <div class="footer"></div>
  <div class="txt">
	<?php if($ismusic): ?>
	<?php echo $musicdes; ?><object type="application/x-shockwave-flash" data="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" width="180" height="20"><param name="movie" value="./images/player.swf?son=<?php echo $musicurl; ?><?php echo $autoplay; ?>&autoreplay=1" /></object><br />
	<?php endif; ?>
	Powered by <a href="http://www.emlog.net" title="emlog <?php echo EMLOG_VERSION;?>">emlog</a>　
	<a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a>
  </div>
  <span class="smashing"><a href="http://jobs.smashingmagazine.com">Smashing Magazine</a></span> <span class="rss"><a href="rss.php">RSS</a></span></div>
</body></html>