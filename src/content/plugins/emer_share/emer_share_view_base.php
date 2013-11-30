<script>
    $("#emer_share").addClass('sidebarsubmenu1');
</script>
<style> 
    #emshare_main {margin:20px 5px;}
    #emshare_main li{padding:5px;}
    #emshare_main li input{padding:2px;}
    #emshare_main p input{padding:2px;}
    #emshare_main p span{margin-left:30px;}
</style>
<div class=containertitle><img src="../content/plugins/emer_share/y.png" align="absbottom"><b>云平台分享插件</b></div>
<?php if (isset($_GET['setting']) && $_GET['setting']): ?><span class="actived">保存成功！</span><?php endif; ?>
<?php if (isset($_GET['info']) && $_GET['info'] == 1): ?><span class="actived">请查收邮件！</span><?php endif; ?>
<?php if (isset($_GET['info']) && $_GET['info'] == 2): ?><span class="actived">同步成功！</span><?php endif; ?>
<?php if (isset($_GET['info']) && $_GET['info'] == 3): ?><span class="actived">您已经激活过！请重置密匙！</span><?php endif; ?>
<div class=line></div>
<div class="des">
    emer分享云平台是一个专属于emlog用户的博文和碎语分享平台。 
    emer通过平台提供的分享插件，把自己的博文和碎语同时分享到云平台上。云平台会滚动展示所有emer分享上来的博文和碎语。
    通过这样一个平台，来时实反应每位emer的动态。也可以促进emer之间的沟通和交流以及提高日志的曝光量及点击率。
 <br /><br />
    提示：请确保本插件目录及emer_share_config.php文件据有写权限（777）。
</div>