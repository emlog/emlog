<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<div class=containertitle><b>写日志</b><span id="msg_2"></span></div><div id="msg"></div>
<div class=line></div>
  <form action="save_log.php?action=add" method="post" enctype="multipart/form-data" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="95%" align="center" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td><b>标题：</b><br />
          <input maxlength="200" style="width:380px;" name="title" id="title"/>
	      <select name="sort" id="sort">
	        <option value="-1">选择分类...</option>
			<?php foreach($sorts as $val):?>
			<option value="<?php echo $val['sid']; ?>"><?php echo $val['sortname']; ?></option>
			<?php endforeach;?>
	      </select>
	      <input maxlength="200" style="width:125px;" name="postdate" id="postdate" value="<?php echo $postDate; ?>"/>
        </td>
        </tr>
        <tr>
          <td>
              <table cellspacing="0" cellpadding="0" width="100%" border="0">
                  <tr>
                    <td>
                    <b>内容：</b> <a href="javascript: displayToggle('FrameUpload');autosave(1);" class="thickbox">附件管理</a><span id="asmsg">
                    <input type="hidden" name="as_logid" id="as_logid" value="-1"></span><br />

                    <div id="FrameUpload" style="display: none;"><iframe width="720" frameborder=0 height="160" frameborder=0 src="attachment.php?action=selectFile"></iframe></div>

					<input type="hidden" id="content" name="content" value="" style="display:none" />
					<input type="hidden" value="CustomConfigurationsPath=fckeditor/fckconfig.js" style="display:none" />
					<iframe src="fckeditor/editor/fckeditor.html?InstanceName=content&amp;Toolbar=Default" width="720" height="460" frameborder="0" scrolling="no"></iframe>
                    </td>
                  </tr>
              </table>			  
              </td>
        </tr>
        <tr nowrap="nowrap">
          <td><b>标签：</b>(Tag，日志的关键字，半角逗号&quot;,&quot;分隔多个标签)<br />
          <input name="tag" id="tag" maxlength="200" style="width:715px;" /><br />
          <div style="width:715px;">选择已有标签：
          <?php 
          $tagStr = '';
          foreach ($tags as $val)
          {
          	$tagStr .=" <a href=\"javascript: insertTag('{$val['tagname']}','tag');\">{$val['tagname']}</a> ";
          }
          echo $tagStr;
          ?>
          </div></td>
        </tr>
	</tbody>
	</table>
	<div id="show_advset"><b>高级选项</b></div>
	<table cellspacing="0" cellpadding="4" border="0" id="advset">
        <tr nowrap="nowrap">
          <td>日志摘要：<br />
			<input type="hidden" id="excerpt" name="excerpt" value="" style="display:none" />
			<input type="hidden" value="CustomConfigurationsPath=fckeditor/fckconfig.js" style="display:none" />
			<iframe src="fckeditor/editor/fckeditor.html?InstanceName=excerpt&amp;Toolbar=Default" width="720" height="260" frameborder="0" scrolling="no"></iframe>
          </td>
        </tr>      
        <tr nowrap="nowrap">
          <td>引用通告：(Trackback，通知你所引用的日志)<b><br /></b>
			<textarea name="pingurl" id="pingurl" rows="3" cols="" style="width:715px;" onclick="if (this.value=='每行输入一个引用地址') this.value='';" class="input">每行输入一个引用地址</textarea>
          </td>
        </tr>
        <tr>
          <td>接受评论？是
          <input type="radio" checked="checked" value="y" name="allow_remark" id="allow_remark" />否
          <input type="radio" value="n" name="allow_remark" id="allow_remark" />
          </td>
        </tr>
        <tr>
          <td>接受引用？是
          <input type="radio" checked="checked" value="y" name="allow_tb" id="allow_tb" />否
          <input type="radio" value="n" name="allow_tb" id="allow_tb" />
		  </td>
        </tr>
        <tr>
          <td>日志访问密码：
          <input type="text" value="" name="password" id="password" class="input" /> (留空则不加访问密码)
		  </td>
        </tr>
	</table>
	<table cellspacing="1" cellpadding="4" width="95%" align="center" border="0">
		<tr>
          <td align="center"><br>
          <input type="hidden" name="ishide" id="ishide" value="">
          <input type="submit" value="发布日志" onclick="return chekform();" class="button" />
          <input type="button" name="savedf" id="savedf" value="存为草稿" onclick="autosave(2);" class="button" />
		  </td>
        </tr>
    </table>
  </form>
<div class=line></div>
<script type="text/javascript">
$("#show_advset").click(function(){$("#advset").toggle();});
setTimeout("autosave(0)",30000);
</script>