<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<script type="text/javascript" src="../lib/js/jquery/plugin-cookie.js"></script>
<div class=containertitle><b>编辑日志</b><span id="msg_2"></span></div><div id="msg"></div>
<div class=line></div>
  <form action="save_log.php?action=edit" method="post" id="addlog" name="addlog">
    <table cellspacing="1" cellpadding="4" width="720" border="0">
      <tbody>
        <tr nowrap="nowrap">
          <td><b>标题：</b><span id="auto_msg"></span><br />
          <input maxlength="200" style="width:380px;" name="title" id="title" value="<?php echo $title; ?>"/>
			<select name="sort" id="sort">
			<?php
			$sorts[] = array('sid'=>-1, 'sortname'=>'选择分类...');
			foreach($sorts as $val):
			$flg = $val['sid'] == $sortid ? 'selected' : '';
			?>
			<option value="<?php echo $val['sid']; ?>" <?php echo $flg; ?>><?php echo $val['sortname']; ?></option>
			<?php endforeach; ?>
			</select>
	       <input maxlength="200" style="width:125px;" name="postdate" id="postdate" value="<?php echo date('Y-m-d H:i:s', $date); ?>"/>
	       <input name="date" id="date" type="hidden" value="<?php echo $date; ?>" >
          </td>
        </tr>
        <tr>
          <td>
          <b>内容：</b> <a href="javascript: displayToggle('FrameUpload', 0);" class="thickbox">附件管理</a>
          <span id="asmsg"><input type="hidden" name="as_logid" id="as_logid" value="<?php echo $logid; ?>"></span><br />
          <div id="FrameUpload" style="display: none;"><iframe width="720" height="160" frameborder="0" src="attachment.php?action=attlib&logid=<?php echo $logid; ?>"></iframe></div>
          <input type="hidden" id="content" name="content" value="<?php echo $content; ?>" style="display:none" />
          <input type="hidden" id="content___Config" value="CustomConfigurationsPath=fckeditor/fckconfig.js" style="display:none" />
          <iframe src="fckeditor/editor/fckeditor.html?InstanceName=content&amp;Toolbar=Default" width="720" height="460" frameborder="0" scrolling="no"></iframe>
          </td>
        </tr>
        <tr nowrap="nowrap">
          <td><b>标签：</b>(Tag，日志的关键字，半角逗号&quot;,&quot;分隔多个标签)<br />
          <input name="tag" id="tag" maxlength="200" style="width:715px;" value="<?php echo $tagStr; ?>" /><br />
          <div style="color:#2A9DDB;cursor:pointer;"><a href="javascript:displayToggle('tagbox', 0);">选择已有标签&raquo;</a></div>
          <div id="tagbox" style="width:688px;margin-left:30px;display:none;">
          <?php 
          $tagStr = '';
          foreach ($tags as $val)
          {
          	$tagStr .=" <a href=\"javascript: insertTag('{$val['tagname']}','tag');\">{$val['tagname']}</a> ";
          }
          echo $tagStr;
          ?>
          </div>
            </td>
        </tr>
	</tbody>
	</table>
	<div id="show_advset" onclick="displayToggle('advset', 1);"><b>高级选项</b></div>
	<table cellspacing="1" cellpadding="4" width="720" border="0" id="advset">
        <tr nowrap="nowrap">
          <td>日志摘要：<br />
			<input type="hidden" id="excerpt" name="excerpt" value="<?php echo $excerpt; ?>" style="display:none" />
			<input type="hidden" value="CustomConfigurationsPath=fckeditor/fckconfig.js" style="display:none" />
			<iframe src="fckeditor/editor/fckeditor.html?InstanceName=excerpt&amp;Toolbar=Basic" width="720" height="260" frameborder="0" scrolling="no"></iframe>
          </td>
        </tr>      
        <tr nowrap="nowrap">
          <td>引用通告：(Trackback，通知你所引用的日志)<b><br /></b>
			<textarea name="pingurl" id="pingurl" rows="3" cols="" style="width:715px;" onclick="if (this.value=='每行输入一个引用地址') this.value='';" class="input">每行输入一个引用地址</textarea>
          </td>
        </tr>
        <tr>
        <td>接受评论？是
          	<input type="radio" checked="checked" value="y" name="allow_remark" <?php echo $ex; ?>/>否
          	<input type="radio" value="n" name="allow_remark" <?php echo $ex2; ?> />
        </td>
        </tr>
        <tr>
          <td>接受引用？是
          <input type="radio" checked="checked" value="y" name="allow_tb" <?php echo $add; ?> />否
          <input type="radio" value="n" name="allow_tb" <?php echo $add2; ?> />
          </td>
        </tr>
        <tr>
          <td>日志访问密码：
          <input type="text" value="<?php echo $password; ?>" name="password" id="password" class="input" /> (留空则不加访问密码)
		  </td>
        </tr>
	</table>
	<table cellspacing="1" cellpadding="4" width="720" align="center" border="0">
        <tr>
          <td align="center" colspan="2"><br>
          <input type="hidden" name="ishide" id="ishide" value="<?php echo $hide; ?>">
		  <input type="hidden" name="gid" value=<?php echo $logid; ?> />
		  <input type="submit" value="保存并返回" onclick="return chekform();" class="button" />
		  <input type="button" name="savedf" id="savedf" value="保存" onclick="autosave(2);" class="button" />
		  </td>
        </tr>
    </table>
  </form>
<div class=line></div>
<script type="text/javascript">
$("#advset").css('display', $.cookie('em_advset') ? $.cookie('em_advset') : '');
setTimeout("autosave(0)",60000);
</script>