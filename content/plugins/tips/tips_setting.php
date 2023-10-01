<?php
if (!defined('EMLOG_ROOT')) {
    die('err');
}
function plugin_setting_view() {
    ?>
    <?php if (isset($_GET['succ'])): ?>
        <div class="alert alert-success">hello world !</div>
    <?php endif; ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">小贴士</h1>
    </div>
    <div class="card shadow mb-4 mt-2">
        <div class="card-body">
            <form method="post" action="./plugin.php?plugin=tips&action=setting">
                <div class="form-group">
                    <p>这是世界上第一个emlog插件，它会在你的管理页面送上一句温馨的小提示，样式如下。</p>
                    <?php tips(); ?>
                    <hr>
                    <p>另外该插件也是一个demo，可以在这个插件基础上修改，开发出你自己的插件。</p>
                </div>
                <div class="form-inline">
                    <input name="hello" class="form-control" style="width: 200px;" value="hello world">
                    <input type="submit" class="btn btn-success btn-sm mx-2" value="Hello">
                </div>
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

function plugin_setting() {
    $hello = Input::postStrVar('hello');
    emDirect('./plugin.php?plugin=tips&succ=1');
}
