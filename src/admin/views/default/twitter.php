<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b>碎语</b>
<?php if(isset($_GET['active_t'])):?><span class="actived">发布成功</span><?php endif;?>
<?php if(isset($_GET['active_set'])):?><span class="actived">设置保存成功</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived">碎语删除成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">碎语内容不能为空</span><?php endif;?>
</div>
<div class=line></div>
<div id="tw">
    <div class="main_img"><a href="#"><img src="<?php echo $avatar; ?>" height="52" width="52" /></a></div>
    <div class="right">
    <form method="post" action="twitter.php?action=post">
    <div class="box_1"><textarea class="box" name="t"></textarea></div>
    <div class="tbutton"><input type="submit" value="发布" /></div>
    </form>
    <div class="op"><a href="javascript:displayToggle('sz_box', 2);">设置</a></div>
    <form method="post" action="twitter.php?action=set">
        <div class="sz_box" id="sz_box">
            <span>前台是否显示：</span>
            <select name="istwitter">
                <option value="y" <?php echo $ex1; ?>>是</option>
                <option value="n" <?php echo $ex2; ?>>否</option>
            </select>
            <span>开启回复验证码：</span>
            <select name="reply_code">
                <option value="y" <?php echo $ex3; ?>>是</option>
                <option value="n" <?php echo $ex4; ?>>否</option>
            </select>
            <span>前台每页显示条数：</span><input type="text" name="index_twnum" value="<?php echo $index_twnum; ?>" />
            <br /><input class="tbutton" type="submit" value="保存" /><input class="tbutton" type="submit" value="关闭" />
        </div>
    </form>
    </div>
    <div class="clear"></div>
    <ul>
    <?php 
    foreach($tws as $val):
    $author = $user_cache[$val['author']]['name'];
    ?> 
    <li class="li">
    <div class="main_img"><img src="<?php echo $avatar; ?>" width="32px" height="32px" /></div>
    <p class="post1"><?php echo $author; ?><br /><?php echo $val['t'];?></p>
    <div class="clear"></div>
    <div class="bttome">
        <p class="post" id="<?php echo $val['id'];?>"><a href="javascript:void(0);">回复(<span><?php echo $val['replynum'];?></span>)</a></p>
        <p class="time"><?php echo $val['date'];?>
            <a href="javascript: em_confirm(<?php echo $val['id'];?>, 'tw');">删除</a>
        </p>
    </div>
	<div class="clear"></div>
    </li>
   	<div id="r_<?php echo $val['id'];?>" class="r"></div>
   	<div class="more"></div>
    <li class="huifu" id="rp_<?php echo $val['id'];?>">   
	<textarea name="reply"></textarea>
    <div><input class="button_p" type="button" onclick="doreply(<?php echo $val['id'];?>);" value="回复" /></div>
    </li>
    <?php endforeach;?>
	 <li class="page"><?php echo $pageurl;?>(有<?php echo $twnum; ?>条碎语)</li>
    </ul>
   
</div>
<script>
$(document).ready(function(){
    $(".post a").toggle(
      function () {
        tid = $(this).parent().attr('id');
        $.get("twitter.php?action=getreply&tid="+tid, function(data){
        $("#r_" + tid).html(data);
        $("#rp_"+tid).show();
        var rnum = Number($("#"+tid+" span").text());
        if(rnum>8){
           $("#rp_"+tid).prev().html("<a id=\"more_"+tid+"\" href=\"javascript:getr("+tid+","+rnum+",2);\">加载更多回复》</a>");
        }
      })},
      function () {
        tid = $(this).parent().attr('id');
        $("#r_" + tid).html('');
        $("#rp_"+tid).hide();
    });
    setTimeout(hideActived,2600);
    $("#sz_box").css('display', $.cookie('em_sz_box') ? $.cookie('em_sz_box') : '');
    $("#menu_tw").addClass('sidebarsubmenu1');
});
function getr(tid, rnum, page){
    
$.get("twitter.php?action=getreply&tid="+tid+"&page="+page, function(data){
       $("#r_" + tid).append(data);
       if(rnum>page*8){
           page++;
           $("#more_"+tid).attr('href', "javascript:getr("+tid+","+rnum+","+page+");");
       }else{
           $("#more_"+tid).html('');
       }
    });
}
function reply(tid, rp){
    $("#rp_"+tid+" textarea").val(rp);
    $("#rp_"+tid+" textarea").focus();
}
function doreply(tid){
    var r = $("#rp_"+tid+" textarea").val();
    var post = "r="+encodeURIComponent(r);
	$.post('twitter.php?action=reply&tid='+tid, post, function(data){
		data = $.trim(data);
		$("#r_"+tid).prepend(data);

		var rnum = Number($("#"+tid+" span").text());
		$("#"+tid+" span").html(rnum+1);
	});
}
function delreply(rid){
    if(confirm('你确定要删除该条回复吗？')){
        $.get("twitter.php?action=delreply&rid="+rid, function(data){
            var tid = Number(data);
            var rnum = Number($("#"+tid+" span").text());
            $("#"+tid+" span").text(rnum-1);
            $("#reply_"+rid).hide("fast");
        })}else {return;}
}
function hidereply(rid){
    $.get("twitter.php?action=hidereply&rid="+rid, function(){
        $("#reply_"+rid).css('background-color','#FEE0E4');
        $("#reply_"+rid+" span a").text('审核');
        $("#reply_"+rid+" span a").attr("href","javascript: pubreply("+rid+")");
        });
}
function pubreply(rid){
    $.get("twitter.php?action=pubreply&rid="+rid, function(){
        $("#reply_"+rid).css('background-color','#FFF');
        $("#reply_"+rid+" span a").text('屏蔽');
        $("#reply_"+rid+" span a").attr("href","javascript: hidereply("+rid+")");
        });
}
</script>