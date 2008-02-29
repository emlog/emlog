<!--<?php 
if(!defined('ADM_ROOT')) {exit('error!');}
print <<<EOT
-->
<script type="text/javascript">
function savedraft() {

	document.addlog.action = "add_log.php?action=addlog&pid=draft";
	document.submit();
}
</script>
<div class=containertitle><b>写日志</b></div>
<div class=line></div>
  <form action="add_log.php?action=addlog" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="95%" align="center" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td><b>标题:</b><br />
            <input maxlength="200" style="width:460px;" name="title" />
          <br /></td>
        </tr>
        <tr>
          <td>
              <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tr>
                    <td>
                    <input type="hidden" id="content" name="content" value="" style="display:none" />
                    <b>内容:</b><br />
                    <iframe id="content___Frame" src="./editor/editor/fckeditor.html?InstanceName=content&amp;Toolbar=Default" style="width:680px;" height="450" frameborder="no" scrolling="no"></iframe>              
                    </td>
                  </tr>
              </table>			  </td>
        </tr>
        <tr nowrap="nowrap">
          <td><b>标签：</b>(Tag，日志的关键字，半角逗号&quot;,&quot;分隔多个标签)<br />
            <input id="tags" maxlength="200" style="width:675px;"  name="tag" />
            <br />
          <div style="width:675px;">选择已有标签：$oldtags</div></td></tr>
        <tr nowrap="nowrap">
          <td><b>引用通告：</b>(Trackback，通知你所引用的日志)<b><br />
          </b>
			<textarea name="pingurl" rows="3" cols="" style="width:675px;"  onclick="if (this.value=='每行输入一个引用地址') this.value='';">每行输入一个引用地址</textarea>
          </td></tr>
        <tr>
          <td><b>更改发布时间</b>
            <input id="switch" onclick="doshow('changedate');" type="checkbox" value="1" name="edittime" />
              <br />
            <div style="clear:both; display: none;" id="changedate">
			  <input name="newyear" type="text" value="$year" maxlength="" size="2"> 年 
			  <input name="newmonth" type="text" value="$month" maxlength="2" size="1"> 月 
			  <input name="newday" type="text" value="$day" maxlength="2" size="1"> 日 
			  <input name="newhour" type="text" value="$hour" maxlength="2" 	size="1"> 时
			  <input name="newmin" type="text" value="$minute" maxlength="2" size="1"> 分 
			  <input name="newsec" type="text" value="$second" maxlength="2" size="1"> 秒
				<br />
		  请正确填写各参数,如果参数错误将仍使用当前服务器时间! 范例:2006年01月08日08时06分01秒  (24小时制)</div></td>
        </tr>
        <tr>
          <td><b>上传附件</b> <a id="attach" title="增加附件" onclick="add()" href="javascript:;" name="attach">[+]</a> (最大允许2M，支持类型:gif jpg bmp png rar zip)<br />
            <div id="tab_attach">
              <table cellspacing="0" cellpadding="0" width="100%" border="0">
                <tbody>
                </tbody>
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
			  <input type="submit" value="保存日志" onclick="savedraft();" class="submit2" />
		  </td>
        </tr>
      </tbody>
    </table>
  </form>
  <div class=line></div>
<!--
EOT;
?>-->