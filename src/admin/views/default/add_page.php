<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div class=containertitle><b><? echo $lang['page_add']; ?></b><span id="msg_2"></span></div><div id="msg"></div>
<div class=line></div>
  <form action="page.php?action=add" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="720" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td><b><? echo $lang['title'];?>:</b><br />
          <input maxlength="200" style="width:380px;" name="title" id="title"/>
	      <input name="date" id="date" type="hidden" value="" >
        </td>
        </tr>
        <tr>
          <td>
          <b><? echo $lang['content'];?>:</b> <a href="javascript: displayToggle('FrameUpload', 0);autosave(4);" class="thickbox"><? echo $lang['attachment_manager'];?></a><span id="asmsg">
          <?php doAction('adm_writelog_head'); ?>
          <input type="hidden" name="as_logid" id="as_logid" value="-1"></span><br />
          <div id="FrameUpload" style="display: none;"><iframe width="720" height="160" frameborder="0" src="attachment.php?action=selectFile"></iframe></div>
          <input type="hidden" id="content" name="content" value="" style="display:none" />
          <input type="hidden" value="CustomConfigurationsPath=fckeditor/fckconfig.js" style="display:none" />
          <iframe src="fckeditor/editor/fckeditor.html?InstanceName=content&amp;Toolbar=Default" width="720" height="460" frameborder="0" scrolling="no"></iframe>
          </td>
        </tr>
        <tr nowrap="nowrap">
          <td><b><? echo $lang['page_url'];?>:</b> (<? echo $lang['page_url_info'];?>)<br />
          <input name="url" id="url" maxlength="200" style="width:715px;" /><br />
          </td>
        </tr>
        <tr>
          <td><? echo $lang['page_comments_enable'] ;?>?
          <input type="radio" value="y" name="allow_remark" id="allow_remark" /><? echo $lang['yes'];?>
          <input type="radio" checked="checked" value="n" name="allow_remark" id="allow_remark" /><? echo $lang['no'];?>
          </td>
        </tr>
        <tr>
          <td><? echo $lang['page_new_window'];?>?
          <input type="radio" value="_blank" name="is_blank" id="is_blank" /><? echo $lang['yes'];?>
          <input type="radio" checked="checked" value="_parent" name="is_blank" id="is_blank" /><? echo $lang['no'];?>
          </td>
        </tr>
		<tr>
          <td align="center"><br>
          <input type="hidden" name="ishide" id="ishide" value="">
          <input type="submit" value="<? echo $lang['page_publish'];?>" onclick="return chekform();" class="button" />
          <input type="button" name="savedf" id="savedf" value="<? echo $lang['page_save'];?>" onclick="autosave(3);" class="button" />
		  </td>
        </tr>
	</tbody>
	</table>
  </form>
<div class=line></div>
<script type="text/javascript">
$("#title").focus();
</script>