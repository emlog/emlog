<?php if (!defined('EMLOG_ROOT')) {
	exit('error!');
} ?>
<?php if (isset($_GET['activated'])): ?>
    <div class="alert alert-success">设置保存成功</div><?php endif; ?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">设置</h1>
</div>
<div class="panel-heading">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" href="./configure.php">基本设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./seo.php">SEO设置</a></li>
        <li class="nav-item"><a class="nav-link" href="./blogger.php">个人设置</a></li>
    </ul>
</div>
<div class="card shadow mb-4 mt-2">
    <div class="card-body">
        <form action="configure.php?action=mod_config" method="post" name="input" id="input">
            <div class="form-group">
                <label>站点标题</label>
                <input class="form-control" value="<?php echo $blogname; ?>" name="blogname">
            </div>
            <div class="form-group">
                <label>站点副标题：</label>
                <textarea name="bloginfo" cols="" rows="3" class="form-control"><?php echo $bloginfo; ?></textarea>
            </div>
            <div class="form-group">
                <label>站点地址</label>
                <input class="form-control" value="<?php echo $blogurl; ?>" name="blogurl">
            </div>
            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="detect_url" id="detect_url" <?php echo $conf_detect_url; ?> />
                <label class="form-check-label" for="exampleCheck1">自动检测站点地址 (可能和部分CDN解决方案不兼容)</label>
            </div>

            <div class="form-group">
                <label>你所在时区</label>
                <select name="timezone" style="width:320px;" class="form-control">
					<?php foreach ($tzlist as $key => $value):
						$ex = $key == $timezone ? "selected=\"selected\"" : ''; ?>
                        <option value="<?php echo $key; ?>" <?php echo $ex; ?>><?php echo $value; ?></option>
					<?php endforeach; ?>
                </select>
            </div>

            <div class="form-group form-check">
                <input class="form-check-input" type="checkbox" value="y" name="login_code" id="login_code" <?php echo $conf_login_code; ?> >
                <label class="form-check-label">登录验证码</label>
            </div>

            <hr>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="iscomment" id="iscomment" <?php echo $conf_iscomment; ?> />
                <label>开启评论</label>，
            </div>

            <div class="form-check form-inline">
                发表评论间隔 <input class="form-control" value="<?php echo $comment_interval; ?>" name="comment_interval" style="width: 100px;"/>秒
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="ischkcomment" id="ischkcomment" <?php echo $conf_ischkcomment; ?> />
                <label>评论审核</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="comment_code" id="comment_code" <?php echo $conf_comment_code; ?> />
                <label>评论验证码</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="isgravatar" id="isgravatar" <?php echo $conf_isgravatar; ?> />
                <label>评论人头像</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="comment_needchinese" id="comment_needchinese" <?php echo $conf_comment_needchinese; ?> />
                <label>评论内容必须包含中文</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="comment_paging" id="comment_paging" <?php echo $conf_comment_paging; ?> />
                <label>评论分页</label>
            </div>
            <div class="form-check form-inline">
                每页显示<input maxlength="5" style="width:50px;" class="form-control" value="<?php echo $comment_pnum; ?>" name="comment_pnum"/>条评论，
                <select name="comment_order" class="form-control" style="width: 100px;">
                    <option value="newer" <?php echo $ex3; ?>>较新的</option>
                    <option value="older" <?php echo $ex4; ?>>较旧的</option>
                </select>排在前面
            </div>

            <hr>

            <div class="form-group form-inline">
                <label>每页显示文章数量</label>
                <input class="form-control mx-sm-3" value="<?php echo $index_lognum; ?>" name="index_lognum"/>
            </div>

            <div class="form-group form-inline">
                RSS输出 <input maxlength="5" style="width:50px;" value="<?php echo $rss_output_num; ?>" class="form-control" name="rss_output_num"/> 篇文章（0为关闭），且输出
                <select name="rss_output_fulltext" class="form-control">
                    <option value="y" <?php echo $ex1; ?>>全文</option>
                    <option value="n" <?php echo $ex2; ?>>摘要</option>
                </select>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" name="isexcerpt" id="isexcerpt" <?php echo $conf_isexcerpt; ?> />
                <label class="form-check-label">自动摘要</label>
            </div>

            <div class="form-check form-inline">
                <label class="form-check-label">自动截取</label>
                <input type="text" name="excerpt_subnum" value="<?php echo Option::get('excerpt_subnum'); ?>" class="form-control" style="width:60px;"/>个字作为摘要
            </div>

            <hr>

            <div class="form-group form-inline">
                附件上传最大限制 <input maxlength="10" style="width:80px;" class="form-control" value="<?php echo $att_maxsize; ?>" name="att_maxsize"/> KB
            </div>
            <div class="form-group form-inline">
                允许上传的附件类型 <input maxlength="200" style="width:320px;" class="form-control" value="<?php echo $att_type; ?>" name="att_type"/>（多个用半角逗号分隔）
            </div>
            <div class="form-group form-inline">
                <input type="checkbox" value="y" name="isthumbnail" id="isthumbnail" <?php echo $conf_isthumbnail; ?> />上传图片生成缩略图，最大尺寸：
                <input maxlength="5" style="width:60px;" class="form-control" value="<?php echo $att_imgmaxw; ?>" name="att_imgmaxw"/> x
                <input maxlength="5" style="width:60px;" class="form-control" value="<?php echo $att_imgmaxh; ?>" name="att_imgmaxh"/>（单位：像素）
            </div>

            <div class="form-group">
                <label>ICP备案号</label>
                <input class="form-control" value="<?php echo $icp; ?>" name="icp"/>
            </div>
            <div class="form-group">
                <label>首页底部信息(支持html，可用于添加流量统计代码)</label>
                <textarea name="footer_info" rows="6" class="form-control"><?php echo $footer_info; ?></textarea>
            </div>
            <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden"/>
            <input type="submit" value="保存设置" class="btn btn-sm btn-success"/>
        </form>
    </div>
</div>
<script>
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('show');
    $("#menu_setting").addClass('active');
    setTimeout(hideActived, 2600);
</script>
