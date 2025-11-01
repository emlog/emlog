<?php
/**
 * 息壤信息咨询服务主题 - 首页模板
 */

defined('EMLOG_ROOT') || exit('access denied!');

if (!blog_tool_ishome()) {
    include View::getView('header');
} else {
    // 首页显示完整的企业展示页面
    include View::getView('header');
?>

<!-- 首屏Hero区域 -->
<section class="xr-hero" id="hero">
    <div class="xr-hero-bg"></div>
    <div class="xr-container">
        <div class="xr-hero-content">
            <h1 class="xr-hero-title" data-aos="fade-up">
                <?php echo htmlspecialchars(_g('hero_title') ?: '息壤信息咨询服务', ENT_QUOTES, 'UTF-8'); ?>
            </h1>
            <p class="xr-hero-subtitle" data-aos="fade-up" data-aos-delay="100">
                <?php echo htmlspecialchars(_g('hero_subtitle') ?: '专业 · 创新 · 领先', ENT_QUOTES, 'UTF-8'); ?>
            </p>
            <div class="xr-hero-buttons" data-aos="fade-up" data-aos-delay="200">
                <a href="<?php echo htmlspecialchars(_g('hero_btn1_link') ?: '#services', ENT_QUOTES, 'UTF-8'); ?>"
                   class="xr-btn xr-btn-primary xr-btn-lg">
                    <?php echo htmlspecialchars(_g('hero_btn1_text') ?: '了解更多', ENT_QUOTES, 'UTF-8'); ?>
                </a>
                <a href="<?php echo htmlspecialchars(_g('hero_btn2_link') ?: '#contact', ENT_QUOTES, 'UTF-8'); ?>"
                   class="xr-btn xr-btn-outline xr-btn-lg">
                    <?php echo htmlspecialchars(_g('hero_btn2_text') ?: '联系我们', ENT_QUOTES, 'UTF-8'); ?>
                </a>
            </div>
        </div>
    </div>
    <!-- 滚动提示 -->
    <div class="xr-scroll-indicator" data-aos="fade-up" data-aos-delay="300">
        <svg class="xr-icon"><use xlink:href="#icon-chevron-down"></use></svg>
    </div>
</section>

<!-- 服务项目区块 -->
<?php xr_services_section(); ?>

<!-- 服务优势区块 -->
<?php xr_advantages_section(); ?>

<!-- 常见问题区块 -->
<?php xr_faq_section(); ?>

<!-- 关于我们区块 -->
<?php xr_about_section(); ?>

<!-- 加入我们区块 -->
<?php xr_join_section(); ?>

<?php
}

// 如果有文章列表，显示文章
if (!empty($logs) && !blog_tool_ishome()): ?>
<main class="xr-blog-list">
    <div class="xr-container">
        <div class="xr-posts-grid">
            <?php foreach ($logs as $value): ?>
            <article class="xr-post-card" data-aos="fade-up">
                <div class="xr-post-meta">
                    <time datetime="<?php echo date('Y-m-d', $value['date']); ?>">
                        <?php echo date('Y年m月d日', $value['date']); ?>
                    </time>
                    <span class="xr-post-views"><?php echo $value['views']; ?> 阅读</span>
                </div>
                <h2 class="xr-post-title">
                    <a href="<?php echo $value['log_url']; ?>">
                        <?php echo htmlspecialchars($value['log_title'], ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </h2>
                <?php if (!empty($value['log_description'])): ?>
                <p class="xr-post-excerpt">
                    <?php echo htmlspecialchars(mb_substr(strip_tags($value['log_description']), 0, 150, 'UTF-8'), ENT_QUOTES, 'UTF-8'); ?>
                </p>
                <?php endif; ?>
                <a href="<?php echo $value['log_url']; ?>" class="xr-post-read-more">
                    阅读全文 →
                </a>
            </article>
            <?php endforeach; ?>
        </div>

        <?php if (!empty($page_url)): ?>
        <div class="xr-pagination">
            <?php echo $page_url; ?>
        </div>
        <?php endif; ?>
    </div>
</main>
<?php endif; ?>

<?php include View::getView('footer'); ?>
