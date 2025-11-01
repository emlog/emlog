<?php
/**
 * 息壤信息咨询服务主题 - 页脚模板
 */

defined('EMLOG_ROOT') || exit('access denied!');
?>

    <!-- 页脚 -->
    <footer class="xr-footer" id="main-footer">
        <div class="xr-container">
            <!-- 上半部分：Logo和链接列 -->
            <div class="xr-footer-top">
                <!-- Logo区域 -->
                <div class="xr-footer-logo-section">
                    <?php
                    $footerLogoType = _g('footer_logo_type') ?: 'text';
                    if ($footerLogoType === 'text') {
                        echo '<div class="xr-footer-logo-text">7XR.CN</div>';
                    } else {
                        $logoImg = _g('logo_image') ?: TEMPLATE_URL . 'images/logo.png';
                        echo '<img src="' . htmlspecialchars($logoImg, ENT_QUOTES, 'UTF-8') . '" alt="' . htmlspecialchars($blogname, ENT_QUOTES, 'UTF-8') . '" class="xr-footer-logo-img">';
                    }
                    ?>
                </div>

                <!-- 链接列 -->
                <div class="xr-footer-columns">
                    <?php
                    xr_footer_column(1);
                    xr_footer_column(2);
                    xr_footer_column(3);
                    xr_footer_column(4);
                    ?>
                </div>
            </div>

            <!-- 下半部分：版权信息和法律链接 -->
            <div class="xr-footer-bottom">
                <div class="xr-footer-copyright">
                    <?php
                    $copyright = _g('copyright_text') ?: '© 2025 7XR.CN 息壤信息咨询服务. All rights reserved.';
                    echo htmlspecialchars($copyright, ENT_QUOTES, 'UTF-8');
                    ?>
                    <?php if (!empty($icp)): ?>
                        <span class="xr-footer-icp"> | <?php echo $icp; ?></span>
                    <?php endif; ?>
                </div>

                <div class="xr-footer-legal">
                    <a href="#" class="xr-footer-legal-link" data-modal="help-doc">
                        <svg class="xr-icon"><use xlink:href="#icon-document"></use></svg>
                        <span>帮助文档</span>
                    </a>
                    <a href="#" class="xr-footer-legal-link" data-modal="terms">
                        <svg class="xr-icon"><use xlink:href="#icon-document"></use></svg>
                        <span>服务条款</span>
                    </a>
                    <a href="#" class="xr-footer-legal-link" data-modal="privacy">
                        <svg class="xr-icon"><use xlink:href="#icon-shield"></use></svg>
                        <span>隐私政策</span>
                    </a>
                </div>

                <!-- 主题切换器 -->
                <div class="xr-theme-switcher">
                    <button class="xr-theme-btn" id="theme-btn" aria-label="主题切换">
                        <svg class="xr-icon xr-theme-icon-sun"><use xlink:href="#icon-sun"></use></svg>
                        <svg class="xr-icon xr-theme-icon-moon"><use xlink:href="#icon-moon"></use></svg>
                        <svg class="xr-icon xr-theme-icon-auto"><use xlink:href="#icon-auto"></use></svg>
                    </button>
                    <div class="xr-theme-menu" id="theme-menu">
                        <button class="xr-theme-option" data-theme="light">
                            <svg class="xr-icon"><use xlink:href="#icon-sun"></use></svg>
                            <span>浅色</span>
                        </button>
                        <button class="xr-theme-option" data-theme="dark">
                            <svg class="xr-icon"><use xlink:href="#icon-moon"></use></svg>
                            <span>深色</span>
                        </button>
                        <button class="xr-theme-option" data-theme="auto">
                            <svg class="xr-icon"><use xlink:href="#icon-auto"></use></svg>
                            <span>自动</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- 返回顶部按钮 -->
    <button class="xr-back-to-top" id="back-to-top" aria-label="返回顶部">
        <svg class="xr-icon"><use xlink:href="#icon-chevron-up"></use></svg>
    </button>

    <!-- 模态弹窗 -->
    <div class="xr-modal" id="modal-help-doc">
        <div class="xr-modal-overlay"></div>
        <div class="xr-modal-content">
            <div class="xr-modal-header">
                <h3>帮助文档</h3>
                <button class="xr-modal-close" aria-label="关闭">
                    <svg class="xr-icon"><use xlink:href="#icon-close"></use></svg>
                </button>
            </div>
            <div class="xr-modal-body">
                <?php
                $helpDoc = _g('help_doc_content') ?: '这里是帮助文档的内容。';
                echo nl2br(htmlspecialchars($helpDoc, ENT_QUOTES, 'UTF-8'));
                ?>
            </div>
        </div>
    </div>

    <div class="xr-modal" id="modal-terms">
        <div class="xr-modal-overlay"></div>
        <div class="xr-modal-content">
            <div class="xr-modal-header">
                <h3>服务条款</h3>
                <button class="xr-modal-close" aria-label="关闭">
                    <svg class="xr-icon"><use xlink:href="#icon-close"></use></svg>
                </button>
            </div>
            <div class="xr-modal-body">
                <?php
                $terms = _g('terms_content') ?: '这里是服务条款的内容。';
                echo nl2br(htmlspecialchars($terms, ENT_QUOTES, 'UTF-8'));
                ?>
            </div>
        </div>
    </div>

    <div class="xr-modal" id="modal-privacy">
        <div class="xr-modal-overlay"></div>
        <div class="xr-modal-content">
            <div class="xr-modal-header">
                <h3>隐私政策</h3>
                <button class="xr-modal-close" aria-label="关闭">
                    <svg class="xr-icon"><use xlink:href="#icon-close"></use></svg>
                </button>
            </div>
            <div class="xr-modal-body">
                <?php
                $privacy = _g('privacy_content') ?: '这里是隐私政策的内容。';
                echo nl2br(htmlspecialchars($privacy, ENT_QUOTES, 'UTF-8'));
                ?>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="<?php echo TEMPLATE_URL; ?>js/main.js?v=<?php echo Option::EMLOG_VERSION_TIMESTAMP; ?>"></script>

    <?php doAction('index_footer'); ?>
</body>
</html>
