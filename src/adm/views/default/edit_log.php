<?php
if(!defined('ADM_ROOT')) {exit('error!');}
$maxsize = changeFileSize($uploadmax);
$att_type_str = '';
foreach ($att_type as $val){
	$att_type_str .= " $val";
}
?>
<script>
setTimeout("autosave('add_log.php?action=autosave','asmsg')",30000);
</script>
<div class=containertitle><b>编辑日志</b></div>
<div class=line></div>
  <form action="admin_log.php?action=edit" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="95%" align="center" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td><b>标题：</b><br />
          <input maxlength="200" style="width:560px;" name="title" id="title" value="<?php echo $title; ?>"/></td>
        </tr>
        <tr>
          <td>
              <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tr>
                    <td><p>
					<b>内容：</b> <span id="asmsg"><input type="hidden" name="as_logid" id="as_logid" value="<?php echo $as_logid; ?>"></span><span id="auto_msg"></span><br />
					<input type="hidden" id="content" name="content" value="<?php echo $content; ?>" style="display:none" />
					<input type="hidden" id="content___Config" value="CustomConfigurationsPath=fckeditor/fckconfig.js" style="display:none" />
					<iframe id="content___Frame" src="fckeditor/editor/fckeditor.html?InstanceName=content&amp;Toolbar=Default" width="720" height="460" frameborder="0" scrolling="no"></iframe>            
                      </p>
                    </td>
                  </tr>
        </table>        </tr>
        <tr nowrap="nowrap">
          <td><b>标签:</b>(Tag，日志的关键字，半角逗号&quot;,&quot;分隔多个标签)<br />
            <input id="tags" maxlength="200" style="width:715px;" name="tag" value="<?php echo $tag; ?>" /><br /><div style="width:715px;">选择已有标签：<?php echo $oldtags; ?></div></td>
        </tr>
        <tr nowrap="nowrap">
          <td><b>引用通告：</b>(Trackback，通知你所引用的日志)<br />
          <textarea name="pingurl" cols="" rows="3" style="width:715px;" onclick="if (this.value=='每行输入一个引用地址') this.value='';">每行输入一个引用地址</textarea>
          </td>
        </tr>
        <tr>
          <td><b>更改发布时间</b>
            <input id="switch" onclick="doshow('changedate');" type="checkbox" value="1" name="edittime" />
              <br />
              <div style="clear:both; display: none;" id="changedate">
			  <input name="newyear" type="text" value="<?php echo $year; ?>" maxlength="" size="2"> 年 
			  <input name="newmonth" type="text" value="<?php echo $month; ?>" maxlength="2" size="1"> 月 
			  <input name="newday" type="text" value="<?php echo $day; ?>" maxlength="2" size="1"> 日 
			  <input name="newhour" type="text" value="<?php echo $hour; ?>" maxlength="2" 	size="1"> 时
			  <input name="newmin" type="text" value="<?php echo $minute; ?>" maxlength="2" size="1"> 分 
			  <input name="newsec" type="text" value="<?php echo $second; ?>" maxlength="2" size="1"> 秒
			  <input name="date" type="hidden" value="<?php echo $adddate; ?>" >
		  <br />请正确填写各参数,如果参数错误将仍使用当前服务器时间! 范例:2006年01月08日08时06分01秒 (24小时制)</div></td>
        </tr>
    </table>
	<table cellspacing="1" cellpadding="4" width="95%" align="center" border="0" class="attlist">
<?php
if(isset($attach)):
foreach($attach as $key=>$value):
	$extension  = strtolower(substr(strrchr($value['filepath'], "."),1));
	$atturl = $blogurl.substr(str_replace('thum-','',$value['filepath']),3);
	if($extension == 'zip' || $extension == 'rar'){
		$imgpath = "./views/$nonce_tpl/images/tar.gif";
		$embedlink = '压缩包';
	}elseif ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif') {
		$imgpath = $value['filepath'];
		$ed_imgpath = $blogurl.substr($imgpath,3);
		$embedlink = "<a href=\"javascript: addattach('$atturl','$ed_imgpath','{$value['attdes']}',{$value['aid']});\">嵌入到日志 </a>";
	}else {
		$imgpath = "./views/$nonce_tpl/images/fnone.gif";
		$embedlink = '';
	}
	?>
	<tr>
		<td width="8%" rowspan="2" >
			<a href="<?php echo $atturl; ?>" target="_blank"><img src="<?php echo $imgpath; ?>" width="60" height="60" border="0"/></a>
		</td>
	</tr>
	<tr>
		<td width="92%" ><?php echo $value['attsize']; ?>)<br />描述： 
			<input type="text" name="attachdes[<?php echo $value['attdes']; ?>" />
			<br />操作：<a href="javascript: isdel(<?php echo $value['aid']; ?>, 6);">删除</a> <?php echo $embedlink; ?> 
		</td>
	</tr>
<?php endforeach;endif; ?>
	  </table>
	  <table cellspacing="1" cellpadding="4" width="95%" align="center" border="0">
        <tr>
          <td><a href="javascript:;" onclick="showhidediv('tab_attach')"><b>上传附件</b></a> 
            <div id="tab_attach" style="display:none">
              <a id="attach" title="增加附件" onclick="addattachfrom()" href="javascript:;" name="attach">[+]</a> <a id="attach" title="减少附件" onclick="removeattachfrom()" href="javascript:;" name="attach">[-]</a> (最大允许<?php echo $maxsize ;?> 允许类型<?php echo $att_type_str; ?>)<br />
              <table cellspacing="0" cellpadding="0" width="100%" border="0">
	            <tbody id="attachbodyhidden" style="display:none"><tr><td width="100%">附件：<input type="file" name="attach[]"> 描述：<input type="text" name="attdes[]"></td></tr></tbody>
	  			<tbody id="attachbody"><tr><td width="100%">附件：<input type="file" name="attach[]"> 描述：<input type="text" name="attdes[]"></td></tr></tbody>
              </table>
            </div>
          <span id="idfilespan"></span></td></tr>
        <tr>
          <td>接受评论？是
              <input type="radio" checked="checked" value="y" name="allow_remark" <?php echo $ex; ?>/>
            否
          <input type="radio" value="n" name="allow_remark" <?php echo $ex2; ?> /></td>
        </tr>
        <tr>
          <td>接受引用？是
              <input type="radio" checked="checked" value="y" name="allow_tb" <?php echo $add; ?> />
            否
          <input type="radio" value="n" name="allow_tb" <?php echo $add2; ?> /></td>
        </tr>
        <tr>
          <td align="center" colspan="2">
		  <input type="hidden" name="gid" value=<?php echo $logid; ?> />
		  	 <input type="submit" value="保存日志" onclick="return chekform();" class="submit2" />
		  </td>
        </tr>
      </tbody>
    </table>
  </form>
  <div class=line></div>