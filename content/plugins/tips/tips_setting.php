<?php
if (!defined('EMLOG_ROOT')) {
    die('err');
}
function plugin_setting_view() {
    ?>
    <?php if (isset($_GET['succ'])): ?>
        <div class="alert alert-success">好的，我知道你知道了</div>
    <?php endif; ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">小贴士插件</h1>
    </div>
    <div class="card shadow mb-4 mt-2">
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <p>这是世界上第一个emlog插件，它会在你的管理页面送上一句温馨的小提示，样式如下。</p>
                    <?php tips(); ?>
                    <hr>
                    <p>另外该插件也是一个demo，可以在这个插件基础上修改，开发出你自己的插件。</p>
                </div>
                <input name="test" type="hidden" class="form-control" value="hello">
                <input type="submit" class="btn btn-success btn-sm" value="好的，我知道了">
            </form>
        </div>
    </div>
    <script>
        setTimeout(hideActived, 3600);
        $("#menu_category_ext").addClass('active');
        $("#menu_ext").addClass('show');
        $("#menu_plug").addClass('active');
    </script>
<?php }

if (!empty($_POST)) {
    $ak = isset($_POST['ak']) ? addslashes(trim($_POST['ak'])) : '';

    header('Location:./plugin.php?plugin=tips&succ=1');
}
