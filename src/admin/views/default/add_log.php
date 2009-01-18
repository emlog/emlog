<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<script type="text/javascript">
function insertTag (tag, boxId) {
	var targetinput = $("#"+boxId).val();
	if(targetinput == '')  {
		targetinput += tag;
	}else{
		var n = ',' + tag;
		targetinput += n;
	}
	$("#"+boxId).val(targetinput);
}
function savedraft(){
	if(!chekform()){return false;}
	document.addlog.action = "add_log.php?action=addlog&pid=draft";
	document.submit();
}
function doautosave(){
	var title = $.trim($("#title").val());
	if(title!=""){autosave('add_log.php?action=autosave','asmsg');}
}
setTimeout("doautosave()",30000);
</script>
<div class=containertitle><b>写日志</b></div>
<div class=line></div>
  <form action="add_log.php?action=addlog" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="95%" align="center" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td><b>标题：</b> <span id="auto_msg"></span><br />
          <input maxlength="200" style="width:380px;" name="title" id="title"/>
	      <select name="sort">
	        <option value="-1">选择分类...</option>
			<?php foreach($sorts as $val):?>
			<option value="<?php echo $val['sid']; ?>"><?php echo $val['sortname']; ?></option>
			<?php endforeach;?>
	      </select> 
	      <input maxlength="200" style="width:125px;" name="postdate" id="title" value="<?php echo date('Y-m-d H:i:s'); ?>"/>
        </td>
        </tr>
        <tr>
          <td>
              <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tr>
                    <td>
                    <b>内容：</b> <a href="javascript: displayToggle('FrameUpload');autosave('add_log.php?action=autosave','asmsg');" class="thickbox">附件管理</a><span id="asmsg">
                    <input type="hidden" name="as_logid" id="as_logid" value="-1"></span><br />

                    <div id="FrameUpload" style="display: none;"><iframe width="720" frameborder=0 height="160" frameborder=0 src="attachment.php?action=selectFile"></iframe></div>

					<input type="hidden" id="content" name="content" value="" style="display:none" />
					<input type="hidden" id="content___Config" value="CustomConfigurationsPath=fckeditor/fckconfig.js" style="display:none" />
					<iframe id="content___Frame" src="fckeditor/editor/fckeditor.html?InstanceName=content&amp;Toolbar=Default" width="720" height="460" frameborder="0" scrolling="no"></iframe>
                    </td>
                  </tr>
              </table>			  
              </td>
        </tr>
        <tr nowrap="nowrap">
          <td><b>标签：</b>(Tag，日志的关键字，半角逗号&quot;,&quot;分隔多个标签)<br />
            <input id="tags" maxlength="200" style="width:715px;"  name="tag" />
            <br />
          <div style="width:715px;">选择已有标签：
          <?php 
          $tagStr = '';
          foreach ($tags as $val)
          {
          	$tagStr .=" <a href=\"javascript: insertTag('{$val['tagname']}','tags');\">{$val['tagname']}</a> ";
          }
          echo $tagStr;
          ?>
          </div></td></tr>
        <tr nowrap="nowrap">
          <td><b>引用通告：</b>(Trackback，通知你所引用的日志)<b><br /></b>
			<textarea name="pingurl" rows="3" cols="" style="width:715px;"  onclick="if (this.value=='每行输入一个引用地址') this.value='';">每行输入一个引用地址</textarea>
          </td></tr>
        <tr>
          <td>接受评论？是
          <input type="radio" checked="checked" value="y" name="allow_remark" />否
          <input type="radio" value="n" name="allow_remark" />
          </td>
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
          <input type="submit" value="存为草稿" onclick="return savedraft();" class="submit2" />
		  </td>
        </tr>
      </tbody>
    </table>
  </form>
  <div class=line></div>