<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b><? echo $lang['twitter']; ?></b>
<?php if(isset($_GET['active_t'])):?><span class="actived"><? echo $lang['posted_ok']; ?></span><?php endif;?>
<?php if(isset($_GET['active_set'])):?><span class="actived"><? echo $lang['settings_saved_ok']; ?></span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived"><? echo $lang['twitter_del_ok']; ?></span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error"><? echo $lang['twitter_empty']; ?></span><?php endif;?>
</div>
<div class=line></div>
<div id="tw">
    <div class="main_img"><a href="./blogger.php"><img src="<?php echo $avatar; ?>" height="52" width="52" /></a></div>
    <div class="right">
    <form method="post" action="twitter.php?action=post">
    <div class="msg"><? echo $lang['twitter_length_max']; ?></div>
    <div class="box_1"><textarea class="box" name="t"></textarea></div>
    <div class="tbutton"><input type="submit" value="<? echo $lang['publish']; ?>" onclick="return checkt();"/></div>
    </form>
    <?php if (ROLE == 'admin'):?>
    <div class="op"><a href="javascript:displayToggle('sz_box', 2);"><? echo $lang['settings']; ?></a></div>
    <form method="post" action="twitter.php?action=set">
        <div class="sz_box" id="sz_box">
            <span><? echo $lang['twitter_show_front']; ?>：</span>
            <select name="istwitter">
                <option value="y" <?php echo $ex1; ?>><? echo $lang['yes']; ?></option>
                <option value="n" <?php echo $ex2; ?>><? echo $lang['no']; ?></option>
            </select>
            <span><? echo $lang['twitter_captcha']; ?>：</span>
            <select name="reply_code">
                <option value="y" <?php echo $ex3; ?>><? echo $lang['yes']; ?></option>
                <option value="n" <?php echo $ex4; ?>><? echo $lang['no']; ?></option>
            </select>
            <span><? echo $lang['twitter_premoderate']; ?>：</span>
            <select name="ischkreply">
                <option value="y" <?php echo $ex5; ?>><? echo $lang['yes']; ?></option>
                <option value="n" <?php echo $ex6; ?>><? echo $lang['no']; ?></option>
            </select>
            <br /><span><? echo $lang['twitters_per_page']; ?>：</span><input type="text" name="index_twnum" value="<?php echo $index_twnum; ?>" /> 
            <input class="tbutton" type="submit" value="<? echo $lang['save']; ?>" />
        </div>
    </form>
    <?php endif;?>
    </div>
    <div class="clear"></div>
    <ul>
    <?php
    foreach($tws as $val):
    $author = $user_cache[$val['author']]['name'];
    $avatar = empty($user_cache[$val['author']]['avatar']) ? './views/' . ADMIN_TPL . '/images/avatar.jpg' : '../' . $user_cache[$val['author']]['avatar'];
    $tid = (int)$val['id'];
    $replynum = $emReply->getReplyNum($tid);
    $hidenum = $replynum - $val['replynum'];
    ?>
    <li class="li">
    <div class="main_img"><img src="<?php echo $avatar; ?>" width="32px" height="32px" /></div>
    <p class="post1"><?php echo $author; ?><br /><?php echo $val['t'];?></p>
    <div class="clear"></div>
    <div class="bttome">
        <p class="post" id="<?php echo $tid;?>"><a href="javascript:void(0);"><? echo $lang['reply']; ?></a>( <span><?php echo $replynum;?></span> <small><?php echo $hidenum > 0 ? $hidenum : '';?></small> )</p>
        <p class="time"><?php echo $val['date'];?> <a href="javascript: em_confirm(<?php echo $tid;?>, 'tw');"><? echo $lang['remove']; ?></a> </p>
    </div>
	<div class="clear"></div>
   	<div id="r_<?php echo $tid;?>" class="r"></div>
    <div class="huifu" id="rp_<?php echo $tid;?>">
	<textarea name="reply"></textarea>
    <div><input class="button_p" type="button" onclick="doreply(<?php echo $tid;?>);" value="<? echo $lang['reply']; ?>" /> <span style="color:#FF0000"></span></div>
    </div>
    </li>
    <?php endforeach;?>
	 <li class="page"><?php echo $pageurl;?> (<? echo $lang['with']; ?><?php echo $twnum; ?> <? echo $lang['twitter_number']; ?>)</li>
    </ul>
</div>
<script>
$(document).ready(function(){
    $(".post a").toggle(
      function () {
        tid = $(this).parent().attr('id');
        $("#r_" + tid).html('<p class="loading"></p>');
        $.get("twitter.php?action=getreply&tid="+tid+"&stamp="+timestamp(), function(data){
        $("#r_" + tid).html(data);
        $("#rp_"+tid).show();
      })},
      function () {
        tid = $(this).parent().attr('id');
        $("#r_" + tid).html('');
        $("#rp_"+tid).hide();
    });
    $(".box").keyup(function(){
       var t=$(this).val();
       var n = 140 - t.length;
       if (n>=0){
         $(".msg").html("<? echo $lang['can_yet_enter']; ?>"+n+" <? echo $lang['characters']; ?>");
       }else {
         $(".msg").html("<span style=\"color:#FF0000\"><? echo $lang['length_exceed']; ?>"+Math.abs(n)+" <? echo $lang['characters']; ?></span>");
       }
    });
    setTimeout(hideActived,2600);
    $("#sz_box").css('display', $.cookie('em_sz_box') ? $.cookie('em_sz_box') : '');
    $("#menu_tw").addClass('sidebarsubmenu1');
    $(".box").focus();
});
function reply(tid, rp){
    $("#rp_"+tid+" textarea").val(rp);
    $("#rp_"+tid+" textarea").focus();
}
function doreply(tid){
    var r = $("#rp_"+tid+" textarea").val();
    var post = "r="+encodeURIComponent(r);
	$.post('twitter.php?action=reply&tid='+tid+"&stamp="+timestamp(), post, function(data){
		data = $.trim(data);
		if (data == 'err1'){
            $(".huifu span").text('<? echo $lang['twitter_length_max']; ?>');
		}else if(data == 'err2'){
		    $(".huifu span").text('<? echo $lang['twitter_reply_exists']; ?>');
		}else{
    		$("#r_"+tid).append(data);
    		var rnum = Number($("#"+tid+" span").text());
    		$("#"+tid+" span").html(rnum+1);
    		$(".huifu span").text('')
    	}
	});
}
function delreply(rid,tid){
    if(confirm('<? echo $lang['twitter_reply_delete_sure']; ?>')){
        $.get("twitter.php?action=delreply&rid="+rid+"&tid="+tid+"&stamp="+timestamp(), function(data){
            var tid = Number(data);
            var rnum = Number($("#"+tid+" span").text());
            $("#"+tid+" span").text(rnum-1);
            if ($("#reply_"+rid+" span a").text() == '<? echo $lang['approve']; ?>'){
                var rnum = Number($("#"+tid+" small").text());
                if(rnum == 1){$("#"+tid+" small").text('');}else{$("#"+tid+" small").text(rnum-1);}
            }
            $("#reply_"+rid).hide("slow");
        })}else {return;}
}
function hidereply(rid,tid){
    $.get("twitter.php?action=hidereply&rid="+rid+"&tid="+tid+"&stamp="+timestamp(), function(){
        $("#reply_"+rid).css('background-color','#FEE0E4');
        $("#reply_"+rid+" span a").text('<? echo $lang['approve']; ?>');
        $("#reply_"+rid+" span a").attr("href","javascript: pubreply("+rid+","+tid+")");
        var rnum = Number($("#"+tid+" small").text());
        $("#"+tid+" small").text(rnum+1);
        });
}
function pubreply(rid,tid){
    $.get("twitter.php?action=pubreply&rid="+rid+"&tid="+tid+"&stamp="+timestamp(), function(){
        $("#reply_"+rid).css('background-color','#FFF');
        $("#reply_"+rid+" span a").text('<? echo $lang['hide']; ?>');
        $("#reply_"+rid+" span a").attr("href","javascript: hidereply("+rid+","+tid+")");
        var rnum = Number($("#"+tid+" small").text());
        if(rnum == 1){$("#"+tid+" small").text('');}else{$("#"+tid+" small").text(rnum-1);}
        });
}
function checkt(){
    var t=$(".box").val();
    var n=140 - t.length;
    if (n<0){return false;}
}
</script>