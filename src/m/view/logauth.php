<?php if(!defined('EMLOG_ROOT')) {exit('error!');}?>
<div id="navi">
<a href="./">日志</a> 
<a href="./?action=tw">碎语</a> 
<a href="./?action=com">评论</a> 
<?php if(ROLE == 'admin' || ROLE == 'writer'): ?>
<a href="./?action=logout">退出</a>
<?php else:?>
<a href="./?action=login">登录</a>
<?php endif;?>
</div>
<div id="m">
该日志需要密码才能访问，请输入密码：
<form action="" method="post">
<br /><input type="password" name="logpwd" /> <input type="submit" value="确定" />
<br /><br /><a href="./">&laquo;返回首页</a>
</form>
</div>