<?php
/**
 * 息壤信息咨询服务主题 - 模块函数定义
 * 所有模板使用的核心函数
 */

defined('EMLOG_ROOT') || exit('access denied!');

/**
 * 渲染导航菜单
 */
function xr_navigation()
{
    $navLinks = _g('nav_links');
    if (empty($navLinks)) {
        $navLinks = "关于|#about\n服务|#services\n价格|#pricing\n作品|#portfolio\n联系|#contact";
    }

    $links = explode("\n", trim($navLinks));
    $output = '<nav class="xr-nav" id="main-nav">';
    $output .= '<ul class="xr-nav-list">';

    foreach ($links as $link) {
        $link = trim($link);
        if (empty($link)) {
            continue;
        }

        $parts = explode('|', $link);
        if (count($parts) === 2) {
            $text = htmlspecialchars(trim($parts[0]), ENT_QUOTES, 'UTF-8');
            $url = htmlspecialchars(trim($parts[1]), ENT_QUOTES, 'UTF-8');
            $output .= '<li class="xr-nav-item"><a href="' . $url . '" class="xr-nav-link">' . $text . '</a></li>';
        }
    }

    $output .= '</ul>';
    $output .= '</nav>';

    echo $output;
}

/**
 * 渲染服务项目区块
 */
function xr_services_section()
{
    $services = [
        [
            'icon' => 'chart-line',
            'title' => '营销咨询',
            'description' => '数据驱动的营销策略，助力品牌增长与市场拓展'
        ],
        [
            'icon' => 'globe',
            'title' => '域名方案',
            'description' => '专业域名规划与管理，打造独特的品牌数字资产'
        ],
        [
            'icon' => 'cloud',
            'title' => '数字云建',
            'description' => '高性能云架构设计，构建稳定可靠的数字基础设施'
        ],
        [
            'icon' => 'robot',
            'title' => 'AI工程',
            'description' => '人工智能解决方案，赋能业务智能化转型升级'
        ],
    ];

    $output = '<section class="xr-services" id="services">';
    $output .= '<div class="xr-container">';
    $output .= '<h2 class="xr-section-title" data-aos="fade-up">' . htmlspecialchars(_g('services_title') ?: '我们的服务', ENT_QUOTES, 'UTF-8') . '</h2>';
    $output .= '<div class="xr-services-grid">';

    foreach ($services as $index => $service) {
        $delay = $index * 100;
        $output .= '<div class="xr-service-card" data-aos="fade-up" data-aos-delay="' . $delay . '">';
        $output .= '<div class="xr-service-icon">';
        $output .= '<svg class="xr-icon"><use xlink:href="#icon-' . $service['icon'] . '"></use></svg>';
        $output .= '</div>';
        $output .= '<h3 class="xr-service-title">' . htmlspecialchars($service['title'], ENT_QUOTES, 'UTF-8') . '</h3>';
        $output .= '<p class="xr-service-desc">' . htmlspecialchars($service['description'], ENT_QUOTES, 'UTF-8') . '</p>';
        $output .= '</div>';
    }

    $output .= '</div></div></section>';
    echo $output;
}

/**
 * 渲染服务优势区块
 */
function xr_advantages_section()
{
    $advantages = [
        [
            'icon' => 'award',
            'title' => '专业',
            'description' => '资深团队，深耕行业多年'
        ],
        [
            'icon' => 'lightbulb',
            'title' => '创意',
            'description' => '创新思维，突破传统边界'
        ],
        [
            'icon' => 'devices',
            'title' => '适配',
            'description' => '全终端覆盖，完美用户体验'
        ],
        [
            'icon' => 'rocket',
            'title' => '领先',
            'description' => '前沿技术，引领行业趋势'
        ],
    ];

    $output = '<section class="xr-advantages">';
    $output .= '<div class="xr-container">';
    $output .= '<h2 class="xr-section-title" data-aos="fade-up">' . htmlspecialchars(_g('advantages_title') ?: '我们的优势', ENT_QUOTES, 'UTF-8') . '</h2>';
    $output .= '<div class="xr-advantages-grid">';

    foreach ($advantages as $index => $advantage) {
        $delay = $index * 100;
        $output .= '<div class="xr-advantage-card" data-aos="zoom-in" data-aos-delay="' . $delay . '">';
        $output .= '<div class="xr-advantage-icon">';
        $output .= '<svg class="xr-icon"><use xlink:href="#icon-' . $advantage['icon'] . '"></use></svg>';
        $output .= '</div>';
        $output .= '<h3 class="xr-advantage-title">' . htmlspecialchars($advantage['title'], ENT_QUOTES, 'UTF-8') . '</h3>';
        $output .= '<p class="xr-advantage-desc">' . htmlspecialchars($advantage['description'], ENT_QUOTES, 'UTF-8') . '</p>';
        $output .= '</div>';
    }

    $output .= '</div></div></section>';
    echo $output;
}

/**
 * 渲染常见问题区块
 */
function xr_faq_section()
{
    $faqItems = _g('faq_items');
    if (empty($faqItems)) {
        $faqItems = "你们的服务范围是什么？|我们提供营销咨询、域名方案、数字云建和AI工程等全方位信息咨询服务。\n服务周期一般多长？|根据项目复杂度，一般从1周到3个月不等，我们会在项目开始前给出明确的时间规划。";
    }

    $faqs = explode("\n", trim($faqItems));

    $output = '<section class="xr-faq" id="faq">';
    $output .= '<div class="xr-container">';
    $output .= '<h2 class="xr-section-title" data-aos="fade-up">' . htmlspecialchars(_g('faq_title') ?: '常见问题', ENT_QUOTES, 'UTF-8') . '</h2>';
    $output .= '<div class="xr-faq-list">';

    foreach ($faqs as $index => $faq) {
        $faq = trim($faq);
        if (empty($faq)) {
            continue;
        }

        $parts = explode('|', $faq);
        if (count($parts) === 2) {
            $question = htmlspecialchars(trim($parts[0]), ENT_QUOTES, 'UTF-8');
            $answer = htmlspecialchars(trim($parts[1]), ENT_QUOTES, 'UTF-8');

            $output .= '<div class="xr-faq-item" data-aos="fade-up" data-aos-delay="' . ($index * 50) . '">';
            $output .= '<div class="xr-faq-question">';
            $output .= '<span>' . $question . '</span>';
            $output .= '<svg class="xr-faq-icon"><use xlink:href="#icon-chevron-down"></use></svg>';
            $output .= '</div>';
            $output .= '<div class="xr-faq-answer"><p>' . $answer . '</p></div>';
            $output .= '</div>';
        }
    }

    $output .= '</div></div></section>';
    echo $output;
}

/**
 * 渲染关于我们区块
 */
function xr_about_section()
{
    $title = _g('about_title') ?: '关于我们';
    $content = _g('about_content') ?: '息壤信息咨询服务致力于为企业提供专业的信息化解决方案。';
    $btnText = _g('about_btn_text') ?: '了解更多';
    $btnLink = _g('about_btn_link') ?: '#';

    $output = '<section class="xr-about" id="about">';
    $output .= '<div class="xr-container">';
    $output .= '<div class="xr-about-content" data-aos="fade-right">';
    $output .= '<h2 class="xr-section-title">' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</h2>';
    $output .= '<p class="xr-about-text">' . nl2br(htmlspecialchars($content, ENT_QUOTES, 'UTF-8')) . '</p>';
    $output .= '<a href="' . htmlspecialchars($btnLink, ENT_QUOTES, 'UTF-8') . '" class="xr-btn xr-btn-primary">' . htmlspecialchars($btnText, ENT_QUOTES, 'UTF-8') . '</a>';
    $output .= '</div>';
    $output .= '</div></section>';
    echo $output;
}

/**
 * 渲染加入我们区块
 */
function xr_join_section()
{
    $title = _g('join_title') ?: '加入我们';
    $content = _g('join_content') ?: '我们正在寻找充满激情的人才加入我们的团队。';
    $btnText = _g('join_btn_text') ?: '查看职位';
    $btnLink = _g('join_btn_link') ?: '#';

    $output = '<section class="xr-join">';
    $output .= '<div class="xr-container">';
    $output .= '<div class="xr-join-content" data-aos="fade-left">';
    $output .= '<h2 class="xr-section-title">' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</h2>';
    $output .= '<p class="xr-join-text">' . nl2br(htmlspecialchars($content, ENT_QUOTES, 'UTF-8')) . '</p>';
    $output .= '<a href="' . htmlspecialchars($btnLink, ENT_QUOTES, 'UTF-8') . '" class="xr-btn xr-btn-secondary">' . htmlspecialchars($btnText, ENT_QUOTES, 'UTF-8') . '</a>';
    $output .= '</div>';
    $output .= '</div></section>';
    echo $output;
}

/**
 * 渲染Footer链接列
 */
function xr_footer_column($columnNumber)
{
    $title = _g("footer_column{$columnNumber}_title");
    $links = _g("footer_column{$columnNumber}_links");

    if (empty($links)) {
        return;
    }

    $linkArray = explode("\n", trim($links));

    echo '<div class="xr-footer-column">';
    echo '<h4 class="xr-footer-column-title">' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '</h4>';
    echo '<ul class="xr-footer-links">';

    foreach ($linkArray as $link) {
        $link = trim($link);
        if (empty($link)) {
            continue;
        }

        $parts = explode('|', $link);
        if (count($parts) === 2) {
            $text = htmlspecialchars(trim($parts[0]), ENT_QUOTES, 'UTF-8');
            $url = htmlspecialchars(trim($parts[1]), ENT_QUOTES, 'UTF-8');
            echo '<li><a href="' . $url . '">' . $text . '</a></li>';
        }
    }

    echo '</ul>';
    echo '</div>';
}

/**
 * SVG图标库
 */
function xr_svg_icons()
{
    ?>
    <svg style="display: none;" xmlns="http://www.w3.org/2000/svg">
        <defs>
            <!-- 营销咨询 - 折线图 -->
            <symbol id="icon-chart-line" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      d="M3 3v18h18M7 16l4-4 3 3 5-7"/>
            </symbol>

            <!-- 域名方案 - 地球 -->
            <symbol id="icon-globe" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" fill="none" stroke="currentColor" stroke-width="2"/>
                <path fill="none" stroke="currentColor" stroke-width="2" d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
            </symbol>

            <!-- 数字云建 - 云 -->
            <symbol id="icon-cloud" viewBox="0 0 24 24">
                <path fill="currentColor" d="M19.35 10.04A7.49 7.49 0 0 0 12 4C9.11 4 6.6 5.64 5.35 8.04A5.994 5.994 0 0 0 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96z"/>
            </symbol>

            <!-- AI工程 - 机器人 -->
            <symbol id="icon-robot" viewBox="0 0 24 24">
                <rect x="6" y="8" width="12" height="12" rx="2" fill="none" stroke="currentColor" stroke-width="2"/>
                <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M12 8V5M12 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                <circle cx="9" cy="13" r="1" fill="currentColor"/>
                <circle cx="15" cy="13" r="1" fill="currentColor"/>
                <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M9 17h6"/>
            </symbol>

            <!-- 专业 - 奖杯 -->
            <symbol id="icon-award" viewBox="0 0 24 24">
                <circle cx="12" cy="8" r="7" fill="none" stroke="currentColor" stroke-width="2"/>
                <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      d="M8.21 13.89L7 23l5-3 5 3-1.21-9.12"/>
            </symbol>

            <!-- 创意 - 灯泡 -->
            <symbol id="icon-lightbulb" viewBox="0 0 24 24">
                <path fill="currentColor" d="M9 21c0 .55.45 1 1 1h4c.55 0 1-.45 1-1v-1H9v1zm3-19C8.14 2 5 5.14 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.86-3.14-7-7-7z"/>
            </symbol>

            <!-- 适配 - 多设备 -->
            <symbol id="icon-devices" viewBox="0 0 24 24">
                <rect x="1" y="4" width="14" height="12" rx="1" fill="none" stroke="currentColor" stroke-width="2"/>
                <path fill="none" stroke="currentColor" stroke-width="2" d="M18 8h2a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-6a2 2 0 0 1-2-2v-2"/>
            </symbol>

            <!-- 领先 - 火箭 -->
            <symbol id="icon-rocket" viewBox="0 0 24 24">
                <path fill="currentColor" d="M12 2c-4 3-7 7-7 12a4 4 0 0 0 4 4c3 0 7 0 7-11 0-1.1-.9-2-2-2h-2z"/>
                <path fill="currentColor" d="M5 14a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm14 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
            </symbol>

            <!-- 下箭头 -->
            <symbol id="icon-chevron-down" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/>
            </symbol>

            <!-- 上箭头 -->
            <symbol id="icon-chevron-up" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M18 15l-6-6-6 6"/>
            </symbol>

            <!-- 关闭 -->
            <symbol id="icon-close" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M18 6L6 18M6 6l12 12"/>
            </symbol>

            <!-- 文档 -->
            <symbol id="icon-document" viewBox="0 0 24 24">
                <path fill="currentColor" d="M6 2a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6H6z"/>
                <path fill="none" stroke="#fff" stroke-width="2" d="M14 2v6h6M10 13h4M10 17h4"/>
            </symbol>

            <!-- 盾牌 -->
            <symbol id="icon-shield" viewBox="0 0 24 24">
                <path fill="currentColor" d="M12 2L4 5v6.09c0 5.05 3.41 9.76 8 10.91 4.59-1.15 8-5.86 8-10.91V5l-8-3z"/>
            </symbol>

            <!-- 菜单 -->
            <symbol id="icon-menu" viewBox="0 0 24 24">
                <path fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" d="M3 12h18M3 6h18M3 18h18"/>
            </symbol>

            <!-- 月亮 -->
            <symbol id="icon-moon" viewBox="0 0 24 24">
                <path fill="currentColor" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
            </symbol>

            <!-- 太阳 -->
            <symbol id="icon-sun" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="5" fill="currentColor"/>
                <path fill="currentColor" d="M12 1v2m0 18v2M4.22 4.22l1.42 1.42m12.72 12.72l1.42 1.42M1 12h2m18 0h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
            </symbol>

            <!-- 自动 -->
            <symbol id="icon-auto" viewBox="0 0 24 24">
                <path fill="currentColor" d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 0 1-8-8 8 8 0 0 1 8-8v8h8a8 8 0 0 1-8 8z"/>
            </symbol>
        </defs>
    </svg>
    <?php
}

/**
 * 判断是否为首页
 */
function blog_tool_ishome()
{
    if (BLOG_URL . trim(Dispatcher::setPath(), '/') == BLOG_URL) {
        return true;
    } else {
        return false;
    }
}

/**
 * 判断文章是否有标签
 */
function blog_tag_exists($blogid)
{
    $tag_model = new Tag_Model();
    $tags = $tag_model->getTag($blogid);
    return !empty($tags);
}
