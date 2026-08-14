<?php
/*
插件后台功能页面（所有用户均可见）

该文件内要包含名为 plugin_user_view 的函数，其中可以输出功能内容 此时插件的后台功能地址为：https://yourdomain/admin/plugin_user.php?plugin=pluginname
该页面可以用来构建一些给普通注册用户使用的后台功能，比如文章收藏插件就使用了该特性。
*/

function plugin_user_view()
{
    echo "hello world";
}
