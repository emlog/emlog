<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="admindex">
<div id="admindex_main">
    <div id="tw">
        <div class="main_img"><a href="./blogger.php"><img src="<?php echo $avatar; ?>" height="52" width="52" /></a></div>
        <div class="right">
        <form method="post" action="twitter.php?action=post">
        <div class="msg2"><a href="blogger.php"><?php echo $name; ?></a> (有<span class=care2><b><?php echo $sta_log;?></b></span>篇日志，<span class=care2><b><?php echo $sta_tw;?></b></span>条碎语)</div>
        <div class="box_1"><textarea class="box2" name="t">为今天写点什么吧 ……</textarea></div>
        <div class="tbutton" style="display:none;"><input type="submit" value="发布" onclick="return checkt();"/> <a href="javascript:closet();">取消</a> <span>(你还可以输入140字)</span></div>
        </form>
        </div>
		<div class="clear"></div>
    </div>
</div>
<div class="clear"></div>
<div id="admindex_servinfo">
<h3>服务器信息</h3>
<ul>
	<li>PHP版本：<?php echo $php_ver; ?></li>
	<li>MySQL版本：<?php echo $mysql_ver; ?></li>
	<li>服务器环境：<?php echo $serverapp; ?></li>
	<li>GD图形处理库：<?php echo $gd_ver; ?></li>
	<li>安全模式：<?php echo $safe_mode ? '开启' : '关闭'; ?></li>
	<li>服务器允许上传最大文件：<?php echo $uploadfile_maxsize; ?></li>
	<li><a href="index.php?action=phpinfo">更多信息&raquo;</a></li>
</ul>
<p id="m"><a title="用手机访问你的博客"><?php echo BLOG_URL.'m'; ?></a></p>
</div>
<div id="admindex_msg">
<h3>官方消息</h3>
<ul></ul>
</div>
<div class="clear"></div>
</div>
<script>
$(document).ready(function(){
    $(".box2").focus(function(){
        $(this).val('').css('height','50px').unbind('focus');
        $(".tbutton").show();
    });
    $(".box2").keyup(function(){
       var t=$(this).val();
       var n = 140 - t.length;
       if (n>=0){
         $(".tbutton span").html("(你还可以输入"+n+"字)");
       }else {
         $(".tbutton span").html("<span style=\"color:#FF0000\">(已超出"+Math.abs(n)+"字)</span>");
       }
    });
	$("#admindex_msg ul").html("<span class=\"ajax_remind_1\">正在读取...</span>");
	$.getJSON("http://www.emlog.net/services/messenger.php?callback=?",
	function(data){
		$("#admindex_msg ul").html("");
		$.each(data.items, function(i,item){
			var image = '';
			if (item.image != ''){
				image = "<a href=\""+item.url+"\" target=\"_blank\" title=\""+item.title+"\"><img src=\""+item.image+"\"></a><br />";
			}
			$("#admindex_msg ul").append("<li class=\"msg_type_"+item.type+"\">"+image+"<span>"+item.date+"</span><a href=\""+item.url+"\" target=\"_blank\">"+item.title+"</a></li>");
		});
	});
});
function closet(){
    $(".tbutton").hide();
    $(".tbutton span").html("(你还可以输入140字)");
    $(".box2").val('为今天写点什么吧……').css('height','17px').bind('focus',function(){
        $(this).val('').css('height','50px').unbind('focus');
        $(".tbutton").show();});
}
function checkt(){
    var t=$(".box2").val();
    var n=140 - t.length;
    if (n<0){return false;}
}
</script>
