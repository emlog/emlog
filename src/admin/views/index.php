<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="admindex">
<div id="admindex_main">
    <div id="tw">
        <div class="main_img"><a href="./blogger.php"><img src="<?php echo $avatar; ?>" height="52" width="52" /></a></div>
        <div class="right">
        <form method="post" action="twitter.php?action=post">
        <div class="msg2"><a href="blogger.php"><?php echo $name; ?></a></div>
        <div class="box_1"><textarea class="box2" name="t">为今天写点什么吧 ……</textarea></div>
        <div class="tbutton" style="display:none;"><input type="submit" value="发布" onclick="return checkt();"/> <a href="javascript:closet();">取消</a> <span>(你还可以输入140字)</span></div>
        </form>
        </div>
		<div class="clear"></div>
    </div>
</div>
<div class="clear"></div>
<?php if (ROLE == ROLE_ADMIN):?>
<div style="margin-top: 20px;">
<div id="admindex_servinfo">
<h3>站点信息</h3>
<ul>
	<li>有<b><?php echo $sta_cache['lognum'];?></b>篇文章，<b><?php echo $sta_cache['comnum_all'];?></b>条评论，<b><?php echo $sta_cache['twnum'];?></b>条微语</li>
	<li>PHP版本：<?php echo $php_ver; ?></li>
	<li>MySQL版本：<?php echo $mysql_ver; ?></li>
	<li>服务器环境：<?php echo $serverapp; ?></li>
	<li>GD图形处理库：<?php echo $gd_ver; ?></li>
	<li>服务器允许上传最大文件：<?php echo $uploadfile_maxsize; ?></li>
	<li><a href="index.php?action=phpinfo">更多信息&raquo;</a></li>
</ul>
</div>
<div id="admindex_msg">
<h3>官方消息</h3>
<ul></ul>
</div>
<div class="clear"></div>
<div id="about">
    您正在使用emlog <?php echo Option::EMLOG_VERSION; ?>  <span><a id="ckup" href="javascript:void(0);">检查更新</a></span><br />
    <span id="upmsg"></span>
</div>
</div>
</div>
<script>
$(document).ready(function(){
	$("#admindex_msg ul").html("<span class=\"ajax_remind_1\">正在读取...</span>");
	$.getJSON("http://www.emlog.net/services/messenger.php?v=<?php echo Option::EMLOG_VERSION; ?>&callback=?",
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
$("#about #ckup").click(function(){
    $("#about #upmsg").html("正在检查，请稍后").addClass("ajaxload");
	$.getJSON("http://www.emlog.net/services/check_update.php?ver=<?php echo Option::EMLOG_VERSION; ?>&callback=?",
    function(data){
        if (data.result.match("no")) {
            $("#about #upmsg").html("目前还没有适合您当前版本的更新！").removeClass();
        } else if(data.result.match("yes")) {
            $("#about #upmsg").html("有可用的emlog更新版本 "+data.ver+"，更新之前请您做好数据备份工作，<a id=\"doup\" href=\"javascript:doup('"+data.file+"','"+data.sql+"');\">现在更新</a>").removeClass();
        } else{
            $("#about #upmsg").html("检查失败，可能是网络问题").removeClass();
        }
    });
});
function doup(source,upsql){
    $("#about #upmsg").html("系统正在更新中，请耐心等待").addClass("ajaxload");
    $.get('./index.php?action=update&source='+source+"&upsql="+upsql,
      function(data){
        $("#about #upmsg").removeClass();
        if (data.match("succ")) {
            $("#about #upmsg").html('恭喜您！更新成功了，请<a href="./">刷新页面</a>开始体验新版emlog');
        } else if(data.match("error_down")){
            $("#about #upmsg").html('下载更新失败，可能是服务器网络问题');
        } else if(data.match("error_zip")){
            $("#about #upmsg").html('解压更新失败，可能是服务器不支持zip模块');
        } else if(data.match("error_dir")){
            $("#about #upmsg").html('更新失败，目录不可写');
        }else{
            $("#about #upmsg").html('更新失败');
        }
      });
}
</script>
<?php endif;?>
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