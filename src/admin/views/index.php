<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="admindex">
<?php if (ROLE == ROLE_ADMIN):?>
<div id="admindex_main">
    <div id="tw">
        <div class="main_img"><a href="./blogger.php"><img src="<?php echo $avatar; ?>" height="52" width="52" /></a></div>
        <div class="right">
        <form method="post" action="twitter.php?action=post">
        <div class="msg2"><a href="blogger.php"><?php echo $name; ?></a></div>
<!--vot--><div class="box_1"><textarea class="box2" name="t" placeholder="<?=lang('twitter_write_placeholder')?>"></textarea></div>
        <div class="tbutton" style="display:none;">
<!--vot-->  <input class="button" type="submit" value="<?=lang('publish')?>" onclick="return checkt();"/> <a class="button" href="javascript:closet();"><?=lang('cancel')?></a> <span><?=lang('twitter_write_length')?></span>
            <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
        </div>
        </form>
        </div>
        <div class="clear"></div>
    </div>
</div>
<div class="clear"></div>
<div style="margin-top: 20px;">
<div id="admindex_servinfo">
<!--vot--><h3><?=lang('site_info')?></h3>
<ul>
<!--vot--><li><?=lang('have')?><b><?php echo $sta_cache['lognum'];?></b><?=lang('_posts')?>, <b><?php echo $sta_cache['comnum_all'];?></b><?=lang('_comments')?>, <b><?php echo $sta_cache['twnum'];?></b><?=lang('_twitters')?></li>
<!--vot--><li><?=lang('db_prefix')?>: <?php echo DB_PREFIX; ?></li>
<!--vot--><li><?=lang('php_version')?>: <?php echo $php_ver; ?></li>
<!--vot--><li><?=lang('mysql_version')?>: <?php echo $mysql_ver; ?></li>
<!--vot--><li><?=lang('server_environment')?>: <?php echo $serverapp; ?></li>
<!--vot--><li><?=lang('gd_library')?>: <?php echo $gd_ver; ?></li>
<!--vot--><li><?=lang('server_max_upload_size')?>: <?php echo $uploadfile_maxsize; ?></li>
<!--vot--><li><a href="index.php?action=phpinfo"><?=lang('more_php_info')?></a></li>
</ul>
</div>
<div id="admindex_msg">
<!--vot--><h3><?=lang('official_source')?></h3>
<ul></ul>
</div>
<div class="clear"></div>
<div id="about">
<!--vot--><?=lang('using_emlog')?> <?php echo Option::EMLOG_VERSION; ?> <span><a id="ckup" href="javascript:void(0);"><?=lang('update_check')?></a></span><br />
    <span id="upmsg"></span>
</div>
</div>
</div>
<script>
$(document).ready(function(){
/*vot*/    $("#admindex_msg ul").html("<span class=\"ajax_remind_1\"><?=lang('reading')?></span>");
    $.getJSON("<?php echo OFFICIAL_SERVICE_HOST;?>services/messenger.php?v=<?php echo Option::EMLOG_VERSION; ?>&callback=?",
    function(data){
        $("#admindex_msg ul").html("");
        $.each(data.items, function(i,item){
            var image = '';
            if (item.image != ''){
                image = "<a href=\""+item.url+"\" target=\"_blank\" title=\""+item.title+"\"><img src=\""+item.image+"\"></a><br />";
            }
//vot: Translate Title
/*vot*/            item.title = item.title.replace(
/*vot*/             new RegExp('发布', 'g'),
/*vot*/             '<?=lang('released')?>'
/*vot*/         );
//vot: Translate Date
/*vot*/            item.date = item.date.replace(
/*vot*/             new RegExp('(^\\d+)年(\\d+)月(\\d+)日', 'g'),
/*vot*/             '20'+'$1'+'-'+'$2'+'-'+'$3'
/*vot*/         );

            $("#admindex_msg ul").append("<li class=\"msg_type_"+item.type+"\">"+image+"<span>"+item.date+"</span><a href=\""+item.url+"\" target=\"_blank\">"+item.title+"</a></li>");
        });
    });
});
$("#about #ckup").click(function(){
/*vot*/  $("#about #upmsg").html("<?=lang('checking_wait')?>").addClass("ajaxload");
    $.getJSON("<?php echo OFFICIAL_SERVICE_HOST;?>services/check_update.php?ver=<?php echo Option::EMLOG_VERSION; ?>&callback=?",
    function(data){
        if (data.result.match("no")) {
/*vot*/   $("#about #upmsg").html("<?=lang('updates_no')?>").removeClass();
        } else if(data.result.match("yes")) {
/*vot*/   $("#about #upmsg").html("<?=lang('update_exists')?>"+data.ver+"<?=lang('backup_before_update')?><a id=\"doup\" href=\"javascript:doup('"+data.file+"','"+data.sql+"');\"><?=lang('update_now')?></a>").removeClass();
        } else{
/*vot*/   $("#about #upmsg").html("<?=lang('update_check_failed')?>").removeClass();
        }
    });
});
function doup(source,upsql){
/*vot*/  $("#about #upmsg").html("<?=lang('updating')?>").addClass("ajaxload");
    $.get('./index.php?action=update&source='+source+"&upsql="+upsql,
      function(data){
        $("#about #upmsg").removeClass();
        if (data.match("succ")) {
/*vot*/   $("#about #upmsg").html('<?=lang('update_completed')?><a href="./"><?=lang('page_refresh')?></a><?=lang('start_new_emlog')?>');
        } else if(data.match("error_down")){
/*vot*/   $("#about #upmsg").html('<?=lang('update_download_failed')?>');
        } else if(data.match("error_zip")){
/*vot*/   $("#about #upmsg").html('<?=lang('update_extract_failed')?>');
        } else if(data.match("error_dir")){
/*vot*/   $("#about #upmsg").html('<?=lang('update_failed_nonwritable')?>');
        }else{
/*vot*/   $("#about #upmsg").html('<?=lang('update_failed')?>');
        }
      });
}
</script>
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
/*vot*/  $(".tbutton span").html("<?=lang('you_can_enter')?>"+n+"<?=lang('_characters')?>)");
       }else {
         $(".tbutton span").html("<span style=\"color:#FF0000\">(<?=lang('exceeds')?>"+Math.abs(n)+"<?=lang('_characters')?>)</span>");
       }
    });
});
function closet(){
    $(".tbutton").hide();
/*vot*/ $(".tbutton span").html("<?=lang('twitter_write_length')?>");
    $(".box2").val('<?=lang('twitter_write_placeholder')?>').css('height','17px').bind('focus',function(){
        $(this).val('').css('height','50px').unbind('focus');
        $(".tbutton").show();});
}
function checkt(){
    var t=$(".box2").val();
    var n=140 - t.length;
    if (n<0){return false;}
}
</script>
<?php else:?>
<div id="admindex_main">
<!--vot--><div id="about"><a href="blogger.php"><?php echo $name; ?></a> (<b><?php echo $sta_cache[UID]['lognum'];?></b><?=lang('_posts')?>, <b><?php echo $sta_cache[UID]['commentnum'];?></b><?=lang('_comments')?>)</div>
</div>
<div class="clear"></div>
<?php endif; ?>
