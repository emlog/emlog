<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b>碎语</b>
<?php if(isset($_GET['active_t'])):?><span class="actived">发布成功</span><?php endif;?>
<?php if(isset($_GET['active_set'])):?><span class="actived">设置保存成功</span><?php endif;?>
<?php if(isset($_GET['active_del'])):?><span class="actived">碎语删除成功</span><?php endif;?>
<?php if(isset($_GET['error_a'])):?><span class="error">碎语内容不能为空</span><?php endif;?>
</div>
<div class=line></div>
<div id="tw">
    <div class="main_img"><a href="./blogger.php"><img src="<?php echo $avatar; ?>" height="52" width="52" /></a></div>
    <div class="right">
    <form method="post" action="twitter.php?action=post">
    <div class="msg">你还可以输入140字</div>
    <div class="box_1"><textarea class="box" name="t"></textarea></div>
    <div class="tbutton"><input type="submit" value="发布" onclick="return checkt();"/></div>
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
    ?>
    <li class="li">
    <div class="main_img"><img src="<?php echo $avatar; ?>" width="32px" height="32px" /></div>
    <p class="post1"><?php echo $author; ?><br /><?php echo $val['t'];?></p>
    <div class="clear"></div>
    <div class="bttome">
        <p class="post" id="<?php echo $tid;?>"><a href="javascript:void(0);">回复</a>( <span><?php echo $replynum;?></span> <small><?php echo $hidenum > 0 ? $hidenum : '';?></small> )</p>
        <p class="time"><?php echo $val['date'];?> <a href="javascript: em_confirm(<?php echo $tid;?>, 'tw');">删除</a> </p>
    </div>
	<div class="clear"></div>
   	<div id="r_<?php echo $tid;?>" class="r"></div>
    <div class="huifu" id="rp_<?php echo $tid;?>">
	<textarea name="reply"></textarea>
    <div><input class="button_p" type="button" onclick="doreply(<?php echo $tid;?>);" value="回复" /> <span style="color:#FF0000"></span></div>
    </div>
    </li>
    <?php endforeach;?>
	 <li class="page"><?php echo $pageurl;?> (有<?php echo $twnum; ?>条碎语)</li>
    </ul>
</div>
<div id="tw_line">
<h3>最新碎语</h3>
<ul class="tw_scroll"></ul>
<div class="tw_footer"><a href="http://emer.emlog.net/" target="_blank">来自云平台</a></div>
</div>
<script>
(function($){
	$.fn.extend({
		Scroll:function(opt,callback){
			if(!opt) var opt={};
			var _this=this.eq(0).find("ul:first");
			var speed=opt.speed?parseInt(opt.speed,10):500,
			timer=opt.timer?parseInt(opt.timer,10):3000;

			scrollUp=function(){
				var thisLi= _this.find("li:first");
				var thisheight =thisLi.height();
				thisLi.animate({opacity: 1,height:0}, speed,function(){
				thisLi.appendTo(_this).css("opacity","1").height(thisheight);
				});
			}
			 _this.hover(function(){
				clearInterval(timerID);
			},function(){
				timerID=setInterval("scrollUp()",timer);
			});
				timerID=setInterval("scrollUp()",timer);
		}        
	})
})(jQuery);
$("#tw_line").Scroll({speed:1000,timer:8000});

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
         $(".msg").html("你还可以输入"+n+"字");
       }else {
         $(".msg").html("<span style=\"color:#FF0000\">已超出"+Math.abs(n)+"字</span>");
       }
    });
    setTimeout(hideActived,2600);
    $("#sz_box").css('display', $.cookie('em_sz_box') ? $.cookie('em_sz_box') : '');
    $("#menu_tw").addClass('sidebarsubmenu1');
    $(".box").focus();

	//twitter line
    $("#tw_line ul").html("<span class=\"ajax_remind_1\">正在读取...</span>");
	$.getJSON('http://emer.sinaapp.com/api/tw?callback=?',function(data){
		var tw = '';
		$.each(data,function(i,n){
			tw+='<li><a target="_blank" href="'+n.blogurl+'"><img src="http://www.gravatar.com/avatar/'+n.emer_avatar+'?s=32" align="absmiddle" /> <span>'+n.blogname+'</span></a><div>'+n.content+'</div><span class="tw_date">'+n.date+'</span></li>'
		});
		$("#tw_line ul").html("");
		$('#tw_line ul').html(tw);
	});
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
            $(".huifu span").text('回复长度需在140个字内');
		}else if(data == 'err2'){
		    $(".huifu span").text('该回复已经存在');
		}else{
    		$("#r_"+tid).append(data);
    		var rnum = Number($("#"+tid+" span").text());
    		$("#"+tid+" span").html(rnum+1);
    		$(".huifu span").text('')
    	}
	});
}
function delreply(rid,tid){
    if(confirm('你确定要删除该条回复吗？')){
        $.get("twitter.php?action=delreply&rid="+rid+"&tid="+tid+"&stamp="+timestamp(), function(data){
            var tid = Number(data);
            var rnum = Number($("#"+tid+" span").text());
            $("#"+tid+" span").text(rnum-1);
            if ($("#reply_"+rid+" span a").text() == '审核'){
                var rnum = Number($("#"+tid+" small").text());
                if(rnum == 1){$("#"+tid+" small").text('');}else{$("#"+tid+" small").text(rnum-1);}
            }
            $("#reply_"+rid).hide("slow");
        })}else {return;}
}
function hidereply(rid,tid){
    $.get("twitter.php?action=hidereply&rid="+rid+"&tid="+tid+"&stamp="+timestamp(), function(){
        $("#reply_"+rid).css('background-color','#FEE0E4');
        $("#reply_"+rid+" span a").text('审核');
        $("#reply_"+rid+" span a").attr("href","javascript: pubreply("+rid+","+tid+")");
        var rnum = Number($("#"+tid+" small").text());
        $("#"+tid+" small").text(rnum+1);
        });
}
function pubreply(rid,tid){
    $.get("twitter.php?action=pubreply&rid="+rid+"&tid="+tid+"&stamp="+timestamp(), function(){
        $("#reply_"+rid).css('background-color','#FFF');
        $("#reply_"+rid+" span a").text('屏蔽');
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