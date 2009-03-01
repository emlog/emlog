<?php if(!defined('ADMIN_ROOT')) {exit('error!');}?>
<script>setTimeout(hideActived,2600);</script>
<div class=containertitle><b>重建缓存</b>
<?php if(isset($_GET['active_mc'])):?><span class="actived">缓存更新成功</span><?php endif;?>
</div>
<div class=line></div>
<table width="95%" align="center" border="0" cellspacing="1" cellpadding="4" class="formtd2">
   <tr>
   <td align="center" class="notice">
   缓存技术可以大幅度加快你博客首页的加载速度。<br>通常系统会自动更新缓存，但也有些特殊情况需要你手动更新，<br>比如缓存文件被无意修改、你手动修改过数据库 等。
   </td>
  </tr>
<tr><td align="center"><a href="cache.php?action=mkcache">重建缓存</a></td></tr>  
</table><p>
</td>
</tr>
</table>
</td>
</tr>
</table>