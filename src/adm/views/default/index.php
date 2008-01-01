<!--
<?php 
if(!defined('ADM_ROOT')) {exit('error!');}
print <<<EOT
-->
<div class=containertitle><b>服务器信息</b></div>
<div class=line></div>
<table width="95%" align="center" border="0" cellspacing="1" cellpadding="4" class="formtd2">
           <tr>
              <td width="50%">服务器引擎: $serverapp</td>
              <td width="50%">MySQL数据库版本: $dbversion</td>
  </tr>
            <tr>
              <td width="50%">服务器时间: $serverdate</td>
              <td width="50%">文件上传: $upload</td>
            </tr>
			<tr>
              <td width="50%">全局变量注册(register_globals): $reg_glabls</td>
              <td width="50%">图形处理(GD库): $gdlib</td>
            </tr>
			<tr>
              <td width="50%">魔术引用(magic_quotes_gpc): $gpc</td>
              <td width="50%">安全模式(safe_mode): $safe_mode</td>
            </tr>
			<tr><td><a href="configure.php?action=phpinfo">[phpinfo]</a></td></tr>
</table><p>
<div class=containertitle><b>关于我们</b></div>
<div class=line></div>
<table width="95%" align="center" border="0" cellspacing="1" cellpadding="4" class="formtd2">
            <tr>
              <td width="50%">程序: <a href="mailto:emloog@gmail.com">那多记忆</a></td>
              <td width="50%">美工: <a href="mailto:jflyang@sohu.com">CrazyDavinc</a></td>
            </tr>
            <tr>
               <td width="50%">官方主页: <a href="http://www.emlog.net" target="_blank">Www.Emlog.Net</a></font></td>
			   <td width="50%">Mail:<a href="mailto:emloog@gmail.com">emloog@gmail.com</a></td>
            </tr>
</table>
        </td>
      </tr>
   </table>
        </td>
      </tr>
   </table>
<!--
EOT;
?>-->