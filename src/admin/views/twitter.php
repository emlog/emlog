<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<!--vot--><div class=containertitle><b><?=lang('twitters')?></b>
<!--vot--><?php if(isset($_GET['active_t'])):?><span class="actived"><?=lang('published_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_set'])):?><span class="actived"><?=lang('settings_saved_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['active_del'])):?><span class="actived"><?=lang('twitter_delete_ok')?></span><?php endif;?>
<!--vot--><?php if(isset($_GET['error_a'])):?><span class="error"><?=lang('twitter_empty')?></span><?php endif;?>
</div>
<div class=line></div>
<div id="tw">
    <div class="main_img"><a href="./blogger.php"><img src="<?php echo $avatar; ?>" height="52" width="52" /></a></div>
    <div class="right">
    <form method="post" action="twitter.php?action=post">
    <input type="hidden" name="img" id="imgPath" />
    <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
<!--vot--> <div class="msg"><?=lang('can_enter_max_140')?></div>
    <div class="box_1"><textarea class="box" name="t"></textarea></div>
<!--vot--> <div class="tbutton"><input type="submit" value="<?=lang('publish')?>" onclick="return checkt();"/> </div>
	<img class="twImg" id="face" style="margin-right: 10px;cursor: pointer;" src="./views/images/face.png">
    <div class="twImg" id="img_select"><input width="120" type="file" height="30" name="Filedata" id="custom_file_upload" style="display: none;"></div>
    <div id="img_name" class="twImg" style="display:none;">
<!--vot--><a id="img_name_a" class="imgicon" href="javascript:;" onmouseover="$('#img_pop').show();" onmouseout="$('#img_pop').hide();">{<?=lang('image_title')?>}</a>
<!--vot--><a href="javascript:;" onclick="unSelectFile()"> [<?=lang('cancel')?>]</a>
        <div id="img_pop"></div>
    </div>
    <?php doAction('twitter_form'); ?>
    </form>
    </div>
    <div class="clear"></div>
    <ul>
    <?php
    foreach($tws as $val):
    $author = $user_cache[$val['author']]['name'];
    $avatar = empty($user_cache[$val['author']]['avatar']) ? './views/images/avatar.jpg' : '../' . $user_cache[$val['author']]['avatar'];
    $tid = (int)$val['id'];
    $replynum = $Reply_Model->getReplyNum($tid);
    $hidenum = $replynum - $val['replynum'];
/*vot*/    $img = empty($val['img']) ? "" : '<a title="<?=lang('view_image')?>" href="'.BLOG_URL.str_replace('thum-', '', $val['img']).'" target="_blank"><img style="border: 1px solid #EFEFEF;" src="'.BLOG_URL.$val['img'].'"/></a>';
    ?>
    <li class="li">
    <div class="main_img"><img src="<?php echo $avatar; ?>" width="32px" height="32px" /></div>
    <p class="post1"><?php echo $author; ?><br /><?php echo $val['t'];?> <br/><?php echo $img;?></p>
    <div class="clear"></div>
    <div class="bttome">
<!--vot--><p class="post" id="<?php echo $tid;?>"><a href="javascript:void(0);"><?=lang('reply')?></a> ( <span><?php echo $replynum;?></span> <small><?php echo $hidenum > 0 ? $hidenum : '';?></small> )</p>
<!--vot--><p class="time"><?php echo $val['date'];?> <a href="javascript: em_confirm(<?php echo $tid;?>, 'tw', '<?php echo LoginAuth::genToken(); ?>');" class="care"><?=lang('delete')?></a> </p>
    </div>
	<div class="clear"></div>
   	<div id="r_<?php echo $tid;?>" class="r"></div>
    <div class="huifu" id="rp_<?php echo $tid;?>">
	<textarea name="reply"></textarea>
<!--vot--><div><input class="button_p" type="button" onclick="doreply(<?php echo $tid;?>);" value="<?=lang('reply')?>" /> <span style="color:#FF0000"></span></div>
    </div>
    </li>
    <?php endforeach;?>
<!--vot--> <li class="page"><?php echo $pageurl;?> (<?=lang('have')?><?php echo $twnum; ?><?=lang('_twitters')?>)</li>
    </ul>
</div>
<div id="faceWraps"></div>
<script type="text/javascript" src="../include/lib/js/uploadify/jquery.uploadify.min.js?v=<?php echo Option::EMLOG_VERSION; ?>"></script>
<script type="text/javascript" src="./views/js/emo.js?v=<?php echo Option::EMLOG_VERSION; ?>""></script>
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
/*vot*/  $(".msg").html("<?=lang('you_can_enter')?>"+n+"<?=lang('_characters')?>");
       }else {
/*vot*/  $(".msg").html("<span style=\"color:#FF0000\"><?=lang('exceeded_')?>"+Math.abs(n)+"<?=lang('_characters')?></span>");
       }
    });
    setTimeout(hideActived,2600);
    $("#sz_box").css('display', $.cookie('em_sz_box') ? $.cookie('em_sz_box') : '');
    $("#menu_tw").addClass('sidebarsubmenu1');
    $(".box").focus();
	
	$("#custom_file_upload").uploadify({
		id              : jQuery(this).attr('id'),
		swf             : '../include/lib/js/uploadify/uploadify.swf',
		uploader        : 'attachment.php?action=upload_tw_img',
		cancelImage     : './views/images/cancel.png',
/*vot*/		buttonText      : lang('image_select'),
		checkExisting   : "/",
		auto            : true,
		multi           : false,
		buttonCursor    : 'pointer',
		fileTypeExts    : '*.jpg;*.png;*.gif;*.jpeg',
		queueID         : 'custom-queue',
		queueSizeLimit	: 100,
		removeCompleted : false,
		fileSizeLimit	: 20971520,
		fileObjName     : 'attach',
		postData		: {<?php echo AUTH_COOKIE_NAME;?>:'<?php echo $_COOKIE[AUTH_COOKIE_NAME];?>'},
		onUploadSuccess : onUploadSuccess,
		onUploadError   : onUploadError
	});
	
	$("#face").click(function(e){
		var wrap = $("#faceWraps");
		if(!wrap.html()){
			var emotionsStr = [];
			$.each(emo,function(k,v){
				emotionsStr.push('<img style="cursor: pointer;padding: 3px;" title="'+k+'" src="./editor/plugins/emoticons/images/'+v+'"/>');
			});
			wrap.html(emotionsStr.join(""));
		}
		
		wrap.children().unbind('click').click(function () {
			var val= $("textarea").val();
			$("textarea").val((val||"")+$(this).attr("title"));
			$("textarea").focus();
		});

		var offset = $(this).offset();
		wrap.css({
			left : offset.left,
			top : offset.top
		});
		wrap.show();
		e.stopPropagation();
		e.preventDefault();
		$(document.body).unbind('click').click(function (e) {
			wrap.hide();
		});
		$(document).unbind('click').scroll(function (e) {
			wrap.hide();
		});
	});
});

function onUploadSuccess(file, data, response){
	var data = eval("("+data+")");
	if(data.filePath){
		$("#imgPath").val(data.filePath);
		$("#img_select").hide();
		$("#img_name").show();
		$("#img_name_a").text(file.name);
		$("#img_pop").html("<img src='"+data.filePath+"'/>");
	}else{
/*vot*/		alert("<?=lang('upload_failed')?>");	
	}
}
function onUploadError(file, errorCode, errorMsg, errorString){
	alert(errorString);
}
function unSelectFile(){
	$.get("attachment.php?action=del_tw_img",{filepath:$("#imgPath").val()});
	$("#imgPath").val("");
	$("#img_select").show();
	$("#img_name").hide();
/*vot*/	$("#img_name_a").text("{<?=lang('image_title')?>}");
	$("#img_pop").empty();
}
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
/*vot*/		  $(".huifu span").text('<?=lang('reply_length_max_140')?>');
		}else if(data == 'err2'){
/*vot*/		  $(".huifu span").text('<?=lang('replied_already')?>');
		}else{
    		$("#r_"+tid).append(data);
    		var rnum = Number($("#"+tid+" span").text());
    		$("#"+tid+" span").html(rnum+1);
    		$(".huifu span").text('')
    	}
	});
}
function delreply(rid,tid){
/*vot*/ if(confirm('<?=lang('reply_delete_sure')?>')){
        $.get("twitter.php?action=delreply&rid="+rid+"&tid="+tid+"&stamp="+timestamp(), function(data){
            var tid = Number(data);
            var rnum = Number($("#"+tid+" span").text());
            $("#"+tid+" span").text(rnum-1);
/*vot*/     if ($("#reply_"+rid+" span a").text() == '<?=lang('approve')?>'){
                var rnum = Number($("#"+tid+" small").text());
                if(rnum == 1){$("#"+tid+" small").text('');}else{$("#"+tid+" small").text(rnum-1);}
            }
            $("#reply_"+rid).hide("slow");
        })}else {return;}
}
function hidereply(rid,tid){
    $.get("twitter.php?action=hidereply&rid="+rid+"&tid="+tid+"&stamp="+timestamp(), function(){
        $("#reply_"+rid).css('background-color','#FEE0E4');
/*vot*/ $("#reply_"+rid+" span a").text('<?=lang('approve')?>');
        $("#reply_"+rid+" span a").attr("href","javascript: pubreply("+rid+","+tid+")");
        var rnum = Number($("#"+tid+" small").text());
        $("#"+tid+" small").text(rnum+1);
        });
}
function pubreply(rid,tid){
    $.get("twitter.php?action=pubreply&rid="+rid+"&tid="+tid+"&stamp="+timestamp(), function(){
        $("#reply_"+rid).css('background-color','#FFF');
/*vot*/ $("#reply_"+rid+" span a").text('<?=lang('hide')?>');
        $("#reply_"+rid+" span a").attr("href","javascript: hidereply("+rid+","+tid+")");
        var rnum = Number($("#"+tid+" small").text());
        if(rnum == 1){$("#"+tid+" small").text('');}else{$("#"+tid+" small").text(rnum-1);}
        });
}
function checkt(){
	var t=$(".box").val();
    if (t.length > 140){return false;}
}
</script>