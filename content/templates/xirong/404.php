<?php
/**
 * 息壤信息咨询服务主题 - 404错误页面
 */

defined('EMLOG_ROOT') || exit('access denied!');
include View::getView('header');
?>

<main class="xr-error-page">
    <div class="xr-container xr-container-narrow">
        <div class="xr-error-content">
            <div class="xr-error-code" data-aos="fade-up">404</div>
            <h1 class="xr-error-title" data-aos="fade-up" data-aos-delay="100">页面未找到</h1>
            <p class="xr-error-desc" data-aos="fade-up" data-aos-delay="200">
                抱歉，您访问的页面不存在或已被移除。
            </p>
            <div class="xr-error-actions" data-aos="fade-up" data-aos-delay="300">
                <a href="<?php echo BLOG_URL; ?>" class="xr-btn xr-btn-primary">返回首页</a>
                <a href="javascript:history.back();" class="xr-btn xr-btn-outline">返回上页</a>
            </div>
        </div>
    </div>
</main>

<style>
.xr-error-page {
    min-height: calc(100vh - 72px - 200px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: var(--spacing-3xl) 0;
    margin-top: 72px;
}

.xr-error-content {
    text-align: center;
}

.xr-error-code {
    font-size: 120px;
    font-weight: 800;
    line-height: 1;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: var(--spacing-md);
}

.xr-error-title {
    font-size: var(--font-size-3xl);
    font-weight: 700;
    margin-bottom: var(--spacing-md);
    color: var(--color-text-primary);
}

.xr-error-desc {
    font-size: var(--font-size-lg);
    color: var(--color-text-secondary);
    margin-bottom: var(--spacing-xl);
}

.xr-error-actions {
    display: flex;
    gap: var(--spacing-md);
    justify-content: center;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .xr-error-code {
        font-size: 80px;
    }

    .xr-error-title {
        font-size: var(--font-size-2xl);
    }

    .xr-error-actions {
        flex-direction: column;
    }
}
</style>

<?php include View::getView('footer'); ?>
