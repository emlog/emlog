<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<script type="text/javascript" src="../lib/js/jquery/plugin-cookie.js"></script>
<div class=containertitle><b>编辑页面</b><span id="msg_2"></span></div><div id="msg"></div>
<div class=line></div>
  <form action="page.php?action=edit" method="post" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="720" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td><b>标题：</b><span id="auto_msg"></span><br />
          <input maxlength="200" style="width:380px;" name="title" id="title" value="<?php echo $title; ?>"/>
          </td>
        </tr>
        <tr>
          <td>
          <b>内容：</b> <a href="javascript: displayToggle('FrameUpload');" class="thickbox">附件管理</a>
          <span id="asmsg"><input type="hidden" name="as_logid" id="as_logid" value="<?php echo $pageId; ?>"></span><br />
          <div id="FrameUpload" style="display: none;"><iframe width="720" height="160" frameborder="0" src="attachment.php?action=attlib&logid=<?php echo $logid; ?>"></iframe></div>
          <input type="hidden" id="content" name="content" value="<?php echo $content; ?>" style="display:none" />
          <input type="hidden" id="content___Config" value="CustomConfigurationsPath=fckeditor/fckconfig.js" style="display:none" />
          <iframe src="fckeditor/editor/fckeditor.html?InstanceName=content&amp;Toolbar=Default" width="720" height="460" frameborder="0" scrolling="no"></iframe>
          </td>
        </tr>
        <tr nowrap="nowrap">
          <td><b>链接：</b>(不指定将自动生成)<br />
          <input name="url" id="url" maxlength="200" style="width:715px;" value="<?php echo $pageUrl; ?>" /><br />
          </td>
        </tr>
        <tr>
        <td>页面是否接受评论？是
          	<input type="radio" checked="checked" value="y" name="allow_remark" <?php echo $ex; ?>/>否
          	<input type="radio" value="n" name="allow_remark" <?php echo $ex2; ?> />
        </td>
        </tr>
        <tr>
        <td>在新窗口打开页面？是
          	<input type="radio" checked="checked" value="_blank" name="is_blank" <?php echo $ex3; ?>/>否
          	<input type="radio" value="_parent" name="is_blank" <?php echo $ex4; ?> />
        </td>
        </tr>
        <tr>
          <td align="center" colspan="2"><br>
          <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>">
		  <input type="hidden" name="gid" value=<?php echo $pageId; ?> />
		  <input type="submit" value="保存并返回" onclick="return chekform();" class="button" />
		  <input type="button" name="savedf" id="savedf" value="保存" onclick="autosave(3);" class="button" />
		  </td>
        </tr>
	</tbody>
	</table>
  </form>
<div class=line></div>