<?php 
/*
* 底部信息
*/
if(!defined('EMLOG_ROOT')) {exit('error!');} 
?>
<div style="clear:both;"></div>
<div class="footer">
	<div class="container">
Powered by <a href="http://www.emlog.net" title="emlog <?php echo Option::EMLOG_VERSION;?>">emlog</a> | Designed by <a href="http://www.qiyuuu.com/" target="_blank">奇遇</a> <a href="http://www.miibeian.gov.cn" target="_blank"><?php echo $icp; ?></a> <a href="<?php echo BLOG_URL;?>admin/"><?php echo ISLOGIN == true ? '管理' : '登录'; ?></a>
<script src="<?php echo BLOG_URL; ?>include/lib/js/jquery/jquery-1.2.6.js" type="text/javascript"></script>
<?php if($curpage == CURPAGE_LOG) :?><script src="<?php echo TEMPLATE_URL; ?>js/jquery.ex.js" type="text/javascript"></script><?php endif; ?>
<script src="<?php echo TEMPLATE_URL; ?>js/function.js" type="text/javascript"></script>
<!--[if lte IE 6]>
<script type="text/javascript" src="<?php echo TEMPLATE_URL; ?>/js/DD_belatedPNG.js"></script>
<script type="text/javascript">
	DD_belatedPNG.fix('.logo,.desc,.title-list,.title-list ul li');
	$(".title-list ul li").mousemove(function(){
		$(this).css({"background-position":"0 0"});
	});
	$(".title-list ul li").mouseout(function(){
		$(this).css({"background-position":"left -52px"});
	});
</script>
<![endif]-->
<!--[if IE]>
<script type="text/javascript">
	$(".mini-content").click(function(){
		window.location.href = $(this).find(".title").find("a").attr("href");
	});
</script>
<![endif]--> 
<?php doAction('index_footer'); ?>
<script type="text/javascript">
	$("#message").fadeOut(1000,function(){
		var name = $.cookie('commentposter') == undefined ? '' : $.cookie('commentposter');
		var hour = (new Date).getHours();
		var min = (new Date).getMinutes();
		var time = hour * 60 + min;
		var message = '';
		if(time <= 180) {
			message = "不要命的孩子啊，都凌晨了"+name+"你还在晃";
		} else if(time <= 360) {
			message = "看来"+name+"你是没睡觉，失眠了？";
		} else if(time <= 540) {
			message = "一天之计在于晨，早啊"+name;
		} else if(time <= 660) {
			message = "快到中午了，肚子饿><";
		} else if(time <= 750) {
			message = "中午好";
			if(name != '') message += "，"+name;
		} else if(time <= 870) {
			message = "才"+hour+"点"+min+"分，再睡会～";
		} else if(time <= 990) {
			message = "下午好";
			if(name != '') message += "，"+name;
		} else if(time <= 1110) {
			message = "吃晚饭了没？"+name;
		} else if(time <= 1260) {
			message = "做啥呢？"+name;
		} else if(time <= 1320) {
			message = "吃夜宵ing";
		} else if(time <= 1380) {
			message = "不早了，啥时候休息？"+name;
		} else {
			message = "喂，半夜11点多了，"+name+"你还不睡觉";
		}
		$("#message").html(message);
		$("#message").fadeIn("slow");
		setTimeout(hideMessage,8000);
	});
</script>
	</div>
</div>
</body>
</html>