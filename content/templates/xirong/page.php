<?php
/**
 * 息壤信息咨询服务主题 - 自建页面模板
 */

defined('EMLOG_ROOT') || exit('access denied!');
include View::getView('header');
?>

<main class="xr-page">
    <div class="xr-container xr-container-narrow">
        <article class="xr-page-content">
            <!-- 页面头部 -->
            <header class="xr-page-header">
                <h1 class="xr-page-title" data-aos="fade-up">
                    <?php echo htmlspecialchars($log_title, ENT_QUOTES, 'UTF-8'); ?>
                </h1>
            </header>

            <!-- 页面内容 -->
            <div class="xr-page-body" data-aos="fade-up" data-aos-delay="100">
                <?php echo $log_content; ?>
            </div>
        </article>

        <!-- 评论区域 -->
        <?php if ($allow_remark == 'y'): ?>
        <section class="xr-comments-section" id="comments">
            <h2 class="xr-comments-title">评论</h2>

            <!-- 评论表单 -->
            <?php blog_comments_post($logid, $ckname, $ckmail, $ckurl, $verifyCode, $allow_remark); ?>

            <!-- 评论列表 -->
            <?php if (!empty($comments)): ?>
            <div class="xr-comments-list">
                <?php blog_comments($comments, $comnum); ?>
            </div>
            <?php endif; ?>
        </section>
        <?php endif; ?>
    </div>
</main>

<?php include View::getView('footer'); ?>
