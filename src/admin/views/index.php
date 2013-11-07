<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="admindex">
<div id="admindex_main">
    <div id="tw">
        <div class="main_img"><a href="./blogger.php"><img src="<?php echo $avatar; ?>" height="52" width="52" /></a></div>
        <div class="right">
        <form method="post" action="twitter.php?action=post">
        <div class="msg2"><a href="blogger.php"><?php echo $name; ?></a></div>
        <div class="box_1"><textarea class="box2" name="t"><? echo $lang['write_something']; ?></textarea></div>
        <div class="tbutton" style="display:none;"><input type="submit" value="<? echo $lang['publish']; ?>" onclick="return checkt();"/> <a href="javascript:closet();"><? echo $lang['cancel']; ?></a> <span>(<? echo $lang['twitter_length_max']; ?>)</span></div>
        </form>
        </div>
		<div class="clear"></div>
    </div>
</div>
<div class="clear"></div>
<?php if (ROLE == ROLE_ADMIN):?>
<div style="margin-top: 20px;">
<div id="admindex_servinfo">
<h3><? echo $lang['site_info']; ?></h3>
<ul>
	<li><? echo $lang['with']; ?> <b><?php echo $sta_cache['lognum'];?></b><? echo $lang['posted_blogs']; ?>, <b><?php echo $sta_cache['comnum_all'];?></b><? echo $lang['_comments']; ?>, <b><?php echo $sta_cache['twnum'];?></b><? echo $lang['twitter_number']; ?></li>
	<li><? echo $lang['php_version'];?>: <?php echo $php_ver; ?></li>
	<li><? echo $lang['mysql_version'];?>: <?php echo $mysql_ver; ?></li>
	<li><? echo $lang['server_environment'];?>: <?php echo $serverapp; ?></li>
	<li><? echo $lang['gd_library'];?>: <?php echo $gd_ver; ?></li>
	<li><? echo $lang['attachment_max_size'];?>: <?php echo $uploadfile_maxsize; ?></li>
	<li><a href="index.php?action=phpinfo"><? echo $lang['php_info'];?> &raquo;</a></li>
</ul>
<p id="m"><a title="<? echo $lang['use_mobile']; ?>"><?php echo BLOG_URL.'m'; ?></a></p>
</div>
<div id="admindex_msg">
<h3><? echo $lang['official_info'];?></h3>
<ul></ul>
</div>
<div class="clear"></div>
</div>
</div>
<script>
$(document).ready(function(){
	$("#admindex_msg ul").html("<span class=\"ajax_remind_1\"><? echo $lang['loading']; ?></span>");
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
         $(".tbutton span").html("(<? echo $lang['can_yet_enter']; ?>"+n+"<? echo $lang['characters']; ?>)");
       }else {
         $(".tbutton span").html("<span style=\"color:#FF0000\">(<? echo $lang['length_exceed']; ?>"+Math.abs(n)+"<? echo $lang['characters']; ?>)</span>");
       }
    });
});
function closet(){
    $(".tbutton").hide();
    $(".tbutton span").html("(<? echo $lang['twitter_length_max']; ?>)");
    $(".box2").val('<? echo $lang['write_something']; ?>').css('height','17px').bind('focus',function(){
        $(this).val('').css('height','50px').unbind('focus');
        $(".tbutton").show();});
}
function checkt(){
    var t=$(".box2").val();
    var n=140 - t.length;
    if (n<0){return false;}
}
</script>
