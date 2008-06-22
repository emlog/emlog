<?php if(!defined('ADM_ROOT')) {exit('error!');}?>
<div class=containertitle><b>回复评论</b></div>
<div class=line></div>
<form action="comment.php?action=doreply" method="post">
  <table width="600">
    <tbody>
      <tr>
        <td align="right">姓名：</td><td> <?php echo $name; ?></td>
	  </tr>
      <tr>
        <td align="right" valign="top" width="50">内容：</td><td> <?php echo $comment; ?></td>
      </tr>
      <tr>
        <td align="right" valign="top">回复：</td><td>
        <textarea name="reply" rows="5" cols="60"><?php echo $reply; ?></textarea></td>
      </tr>
      <tr>
        <td></td><td>
		<input type="hidden" value="<?php echo $cid; ?>" name="cid" />
		<input type="submit" value="确 定" class="submit2" />
		<input type="button" value="取 消" class="submit2" onclick="javascript: window.history.back();"/>
		</td>
      </tr>
    </tbody>
  </table>
</form>