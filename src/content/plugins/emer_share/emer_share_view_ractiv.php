<div id="emshare_main">
<p>您已经激活，如果密匙被修改或者profile文件被删除，请：<input type="button" value="重新获取密匙" onclick="ractiv()"/>，然后填入下面激活：</p>
<form id="form1" name="form1" method="post" action="plugin.php?plugin=emer_share&action=setting&do=activ">
<p>
用户ID：<input type="text" name="mid" /> 
密 匙：<input type="text" name="pw" />
<input type="submit" value="激活" /></p>
</form>
<script>
    function ractiv(){
        window.location.href = './plugin.php?plugin=emer_share&do=ractiv';
    }
</script>
</div>