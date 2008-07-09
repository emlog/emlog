<?php 
if(!defined('ADM_ROOT')) {exit('error!');}
$maxsize = changeFileSize($uploadmax);
//允许附件类型
$att_type_str = '';
foreach ($att_type as $val){
	$att_type_str .= " $val";
}
?>
<script type="text/javascript">
function savedraft(){
	if(!chekform())
	{
		return false;
	}
	document.addlog.action = "add_log.php?action=addlog&pid=draft";
	document.submit();
}
setTimeout("autosave('add_log.php?action=autosave','asmsg')",30000);
</script>
<div class=containertitle><b>写日志</b></div>
<div class=line></div>
  <form action="add_log.php?action=addlog" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="95%" align="center" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td><b>标题：</b><br />
          <input maxlength="200" style="width:560px;" name="title" id="title"/>
          <br /></td>
        </tr>
        <tr>
          <td>
              <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tr>
                    <td>
                    <b>内容：</b><span id="asmsg"><input type="hidden" name="as_logid" id="as_logid" value="-1"></span><span id="auto_msg"></span><br />
					<input type="hidden" id="content" name="content" value="" style="display:none" />
					<input type="hidden" id="content___Config" value="CustomConfigurationsPath=fckeditor/fckconfig.js" style="display:none" />
					<iframe id="content___Frame" src="fckeditor/editor/fckeditor.html?InstanceName=content&amp;Toolbar=Default" width="720" height="460" frameborder="0" scrolling="no"></iframe>
                    </td>
                  </tr>
              </table>			  </td>
        </tr>
        <tr nowrap="nowrap">
          <td><b>标签：</b>(Tag，日志的关键字，半角逗号&quot;,&quot;分隔多个标签)<br />
            <input id="tags" maxlength="200" style="width:715px;"  name="tag" />
            <br />
          <div style="width:715px;">选择已有标签：<?php echo $oldtags; ?></div></td></tr>
        <tr nowrap="nowrap">
          <td><b>引用通告：</b>(Trackback，通知你所引用的日志)<b><br />
          </b>
			<textarea name="pingurl" rows="3" cols="" style="width:715px;"  onclick="if (this.value=='每行输入一个引用地址') this.value='';">每行输入一个引用地址</textarea>
          </td></tr>
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
				<br />
		  请正确填写各参数,如果参数错误将仍使用当前服务器时间! 范例:2006年01月08日08时06分01秒  (24小时制)</div></td>
        </tr>
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
        <tr>
          <td>接受评论？是
            <input type="radio" checked="checked" value="y" name="allow_remark" />否
          <input type="radio" value="n" name="allow_remark" /></td>
        </tr>
        <tr>
          <td>接受引用？是
            <input type="radio" checked="checked" value="y" name="allow_tb" />否
            <input type="radio" value="n" name="allow_tb" />
		  </td>
        </tr>
		<tr>
          <td align="center">
		  	  <input type="submit" value="发布日志" onclick="return chekform();" class="submit2" />
			  <input type="submit" value="保存日志" onclick="return savedraft();" class="submit2" />
		  </td>
        </tr>
      </tbody>
    </table>
  </form>
  <div class=line></div>