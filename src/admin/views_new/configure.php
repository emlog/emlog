<?php
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
?>
<div class="panel-heading">
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="./configure.php">基本设置</a></li>
        <li role="presentation"><a href="./seo.php">SEO设置</a></li>
        <li role="presentation"><a href="./blogger.php">个人设置</a></li>
    </ul>
<?php if (isset($_GET['activated'])): ?><span class="actived">设置保存成功</span><?php endif; ?>
</div>
<div class="panel-body" style="margin-left:30px;">
    <form action="configure.php?action=mod_config" method="post" name="input" id="input">
        <div class="form-group">
            <label>站点标题：</label><input style="width:390px;" class="form-control" value="<?php echo $blogname; ?>" name="blogname" />
        </div>
        <div class="form-group">
            <label>站点副标题：</label><textarea name="bloginfo" cols="" rows="3" style="width:386px;" class="form-control"><?php echo $bloginfo; ?></textarea>
        </div>
        <div class="form-group">
            <label>站点地址：</label><input style="width:390px;" class="form-control" value="<?php echo $blogurl; ?>" name="blogurl" />
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="y" name="detect_url" id="detect_url" <?php echo $conf_detect_url; ?> />自动检测站点地址 (用于支持多域名/HTTPS，少数空间商可能不支持)
                </label>
            </div>
        </div>
        <div class="form-group form-inline">
            <label>每页显示 </label><input style="width:50px;" class="form-control" value="<?php echo $index_lognum; ?>" name="index_lognum" />篇文章
        </div>
        <div class="form-group form-inline">
            <label>你所在时区：</label>
            <select name="timezone" style="width:320px;" class="form-control">
                <?php
                $tzlist = array('-12' => '(标准时-12) 日界线西',
                    '-11' => '(标准时-11) 中途岛、萨摩亚群岛',
                    '-10' => '(标准时-10) 夏威夷',
                    '-9' => '(标准时-9) 阿拉斯加',
                    '-8' => '(标准时-8) 太平洋时间(美国和加拿大)',
                    '-7' => '(标准时-7) 山地时间(美国和加拿大)',
                    '-6' => '(标准时-6) 中部时间(美国和加拿大)、墨西哥城',
                    '-5' => '(标准时-5) 东部时间(美国和加拿大)、波哥大',
                    '-4' => '(标准时-4) 大西洋时间(加拿大)、加拉加斯',
                    '-3.5' => '(标准时-3:30) 纽芬兰',
                    '-3' => '(标准时-3) 巴西、布宜诺斯艾利斯、乔治敦',
                    '-2' => '(标准时-2) 中大西洋',
                    '-1' => '(标准时-1) 亚速尔群岛、佛得角群岛',
                    '0' => '(标准时) 西欧时间、伦敦、卡萨布兰卡',
                    '1' => '(标准时+1) 中欧时间、安哥拉、利比亚',
                    '2' => '(标准时+2) 东欧时间、开罗，雅典',
                    '3' => '(标准时+3) 巴格达、科威特、莫斯科',
                    '3.5' => '(标准时+3:30) 德黑兰',
                    '4' => '(标准时+4) 阿布扎比、马斯喀特、巴库',
                    '4.5' => '(标准时+4:30) 喀布尔',
                    '5' => '(标准时+5) 叶卡捷琳堡、伊斯兰堡、卡拉奇',
                    '5.5' => '(标准时+5:30) 孟买、加尔各答、新德里',
                    '6' => '(标准时+6) 阿拉木图、 达卡、新亚伯利亚',
                    '7' => '(标准时+7) 曼谷、河内、雅加达',
                    '8' => '(标准时+8) 北京、重庆、香港、新加坡',
                    '9' => '(标准时+9) 东京、汉城、大阪、雅库茨克',
                    '9.5' => '(标准时+9:30) 阿德莱德、达尔文',
                    '10' => '(标准时+10) 悉尼、关岛',
                    '11' => '(标准时+11) 马加丹、索罗门群岛',
                    '12' => '(标准时+12) 奥克兰、惠灵顿、堪察加半岛',
                );
                foreach ($tzlist as $key => $value):
                    $ex = $key == $timezone ? "selected=\"selected\"" : '';
                    ?>
                    <option value="<?php echo $key; ?>" <?php echo $ex; ?>><?php echo $value; ?></option>
<?php endforeach; ?>
            </select>
            (本地时间：<?php echo gmdate('Y-m-d H:i:s', time() + $timezone * 3600); ?>)
        </div>
        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="y" name="login_code" id="login_code" <?php echo $conf_login_code; ?> />登录验证码
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="y" name="isgzipenable" id="isgzipenable" <?php echo $conf_isgzipenable; ?> />Gzip压缩
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="y" name="isxmlrpcenable" id="isxmlrpcenable" <?php echo $conf_isxmlrpcenable; ?> />离线写作（支持用Windows Live Writer等工具写文章）
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="y" name="ismobile" id="ismobile" <?php echo $conf_ismobile; ?> />手机访问版，地址：<span id="m"><a title="用手机访问你的站点"><?php echo BLOG_URL . 'm'; ?></a></span>
                </label>
            </div>
            <div class="checkbox form-inline">
                <label><input type="checkbox" value="y" name="isexcerpt" id="isexcerpt" <?php echo $conf_isexcerpt; ?> />自动摘要</label>，
                截取文章的前<input type="text" name="excerpt_subnum" value="<?php echo Option::get('excerpt_subnum'); ?>" class="form-control" style="width:60px;" />个字作为摘要
            </div>          
        </div>
        <div class="form-group">
            <div class="checkbox form-inline">
                <label><input type="checkbox" value="y" name="istwitter" id="istwitter" <?php echo $conf_istwitter; ?> />开启微语</label>，
                每页显示<input type="text" name="index_twnum" maxlength="3" value="<?php echo Option::get('index_twnum'); ?>" class="form-control" style="width:50px;" />条微语
            </div>
            <div class="checkbox form-inline">
                <label><input type="checkbox" value="y" name="istreply" id="istreply" <?php echo $conf_istreply; ?> />开启微语回复，</label>
                <label><input type="checkbox" value="y" name="reply_code" id="reply_code" <?php echo $conf_reply_code; ?> />回复验证码，</label>
                <label><input type="checkbox" value="y" name="ischkreply" id="ischkreply" <?php echo $conf_ischkreply; ?> />回复审核</label>
            </div>
        </div>
        <div class="form-group form-inline">
            RSS输出 <input maxlength="5" style="width:50px;" value="<?php echo $rss_output_num; ?>" class="form-control" name="rss_output_num" /> 篇文章（0为关闭），且输出
            <select name="rss_output_fulltext" class="form-control">
                <option value="y" <?php echo $ex1; ?>>全文</option>
                <option value="n" <?php echo $ex2; ?>>摘要</option>
            </select>
        </div>
        <div class="form-group">
            <div class="checkbox form-inline">
                <label><input type="checkbox" value="y" name="iscomment" id="iscomment" <?php echo $conf_iscomment; ?> />开启评论</label>，发表评论间隔<input maxlength="5" style="width:50px;" class="form-control" value="<?php echo $comment_interval; ?>" name=comment_interval />秒
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="y" name="ischkcomment" id="ischkcomment" <?php echo $conf_ischkcomment; ?> />评论审核
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="y" name="comment_code" id="comment_code" <?php echo $conf_comment_code; ?> />评论验证码
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="y" name="isgravatar" id="isgravatar" <?php echo $conf_isgravatar; ?> />评论人头像
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="y" name="comment_needchinese" id="comment_needchinese" <?php echo $conf_comment_needchinese; ?> />评论内容必须包含中文
                </label>
            </div>
            <div class="checkbox form-inline">
                <label><input type="checkbox" value="y" name="comment_paging" id="comment_paging" <?php echo $conf_comment_paging; ?> />评论分页，</label>
                每页显示<input maxlength="5" style="width:50px;" class="form-control" value="<?php echo $comment_pnum; ?>" name="comment_pnum" />条评论，
                <select name="comment_order" class="form-control"><option value="newer" <?php echo $ex3; ?>>较新的</option><option value="older" <?php echo $ex4; ?>>较旧的</option></select>排在前面
            </div>
        </div>
        <div class="form-group form-inline">
            <label>附件上传最大限制</label><input maxlength="10" style="width:80px;" class="form-control" value="<?php echo $att_maxsize; ?>" name="att_maxsize" />KB（上传文件还受到服务器空间PHP配置最大上传 <?php echo ini_get('upload_max_filesize'); ?> 限制）
        </div>
        <div class="form-group form-inline">
            <label>允许上传的附件类型</label><input maxlength="200" style="width:320px;" class="form-control" value="<?php echo $att_type; ?>" name="att_type" />（多个用半角逗号分隔）
        </div>
        <div class="form-group form-inline">
            <input type="checkbox" value="y" name="isthumbnail" id="isthumbnail" <?php echo $conf_isthumbnail; ?> />上传图片生成缩略图，最大尺寸：<input maxlength="5" style="width:60px;" class="form-control" value="<?php echo $att_imgmaxw; ?>" name="att_imgmaxw" /> x <input maxlength="5" style="width:60px;" class="form-control" value="<?php echo $att_imgmaxh; ?>" name="att_imgmaxh" />（单位：像素）
        </div>
        <div class="form-group">
            ICP备案号：
            <input maxlength="200" style="width:390px;" class="form-control" value="<?php echo $icp; ?>" name="icp" />
        </div>
        <div class="form-group">
            <label>首页底部信息(支持html，可用于添加流量统计代码)：</label>
            <textarea name="footer_info" cols="" rows="6" class="form-control" style="width:386px;"><?php echo $footer_info; ?></textarea>
        </div>
        <input name="token" id="token" value="<?php echo LoginAuth::genToken(); ?>" type="hidden" />
        <input type="submit" value="保存设置" class="btn btn-primary" />
    </form>
</div>
<script>
    setTimeout(hideActived, 2600);
    $("#menu_category_sys").addClass('active');
    $("#menu_sys").addClass('in');
    $("#menu_setting").addClass('active');
</script>
