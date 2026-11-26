<?php

/**
 * 首页模板
 */
defined('EMLOG_ROOT') || exit('access denied!');
?>
<main class="container blog-container">
    <div class="row">
        <div class="column-big">
            <?php
            $slidesStr = _em('slideShow');
            if (!empty($slidesStr) && blog_tool_ishome()) : ?>
                <div class="slideshow-container">
                    <?php
                    $slides = explode(PHP_EOL, $slidesStr);
                    foreach ($slides as $item):
                        $slide = explode('|', $item);
                        $slideImg = isset($slide[0]) ? $slide[0] : '';
                        $slideTitle = isset($slide[1]) ? $slide[1] : '';
                        $slideLink = isset($slide[2]) ? $slide[2] : '';
                    ?>
                        <div class="mySlides fade">
                            <a href="<?= $slideLink; ?>" target="_blank"><img src="<?= $slideImg ?>" height="260" width="100%" alt=""></a>
                            <div class="slideshow-text"><?= $slideTitle ?></div>
                        </div>
                    <?php endforeach; ?>
                    <a class="slideshow-prev" onclick="plusSlides(-1)">&#10094;</a>
                    <a class="slideshow-next" onclick="plusSlides(1)">&#10095;</a>
                </div>
                <br>
                <script>
                    let slides = document.querySelectorAll('.mySlides');
                    let slideIndex = 1;
                    let timeoutID;

                    const showSlides = (n) => {
                        let i;

                        if (n > slides.length) {
                            slideIndex = 1;
                        }
                        if (n < 1) {
                            slideIndex = slides.length;
                        }

                        for (i = 0; i < slides.length; i++) {
                            slides[i].style.display = "none";
                        }

                        slides[slideIndex - 1].style.display = 'block';
                        clearTimeout(timeoutID);
                        timeoutID = setTimeout(autoSlides, 2000);
                    };

                    const plusSlides = (n) => {
                        showSlides(slideIndex += n);
                    };

                    const currentSlide = (n) => {
                        showSlides(slideIndex = n);
                    };

                    function autoSlides() {
                        let i;

                        for (i = 0; i < slides.length; i++) {
                            slides[i].style.display = "none";
                        }

                        slideIndex++;
                        if (slideIndex > slides.length) {
                            slideIndex = 1;
                        }

                        slides[slideIndex - 1].style.display = "block";
                        timeoutID = setTimeout(autoSlides, 6000);
                    }

                    autoSlides();
                </script>
            <?php endif; ?>
            <?php doAction('index_loglist_top');
            $coverLayout = function_exists('_em') ? _em('coverLayout') : 'top';
            if (empty($coverLayout)) {
                $coverLayout = 'top';
            }
            if (!empty($logs)):
                foreach ($logs as $value):
                    $cardClass = '';
                    if (!empty($value['log_cover'])) {
                        if ($coverLayout === 'left') {
                            $cardClass = 'layout-left';
                        } elseif ($coverLayout === 'right') {
                            $cardClass = 'layout-right';
                        }
                    }
            ?>
                    <div class="shadow-theme bottom-5 <?= $cardClass ?>">
                        <?php if (!empty($value['log_cover'])) : ?>
                            <div class="loglist-cover">
                                <a href="<?= $value['log_url'] ?>"><img src="<?= $value['log_cover'] ?>" alt="<?= $value['log_title'] ?>" class="rea-width"></a>
                            </div>
                        <?php endif ?>
                        <div class="loglist-main">
                            <div class="card-padding loglist-body">
                                <h3 class="card-title">
                                    <a href="<?= $value['log_url'] ?>" class="loglist-title"><?= $value['log_title'] ?></a>
                                    <?php topflg($value['top'], $value['sortop'], isset($sortid) ? $sortid : '') ?>
                                    <?php bloglist_sort($value['sortid']) ?>
                                </h3>
                                <div class="loglist-content markdown"><?php echo subContent($value['log_description'], 180, 1); ?></div>
                                <div class="loglist-tag"><?php blog_tag($value['logid']) ?></div>
                            </div>
                            <div class="info-row">
                                <div class="log-info">
                                    <?php blog_author($value['author']) ?>&nbsp;<?= _langTpl('published_on') ?>&nbsp;
                                    <time><?= date('Y-n-j H:i', $value['date']) ?></time>
                                </div>
                                <div class="log-count">
                                    <a href="<?= $value['log_url'] ?>" class="m-r-10"><span class="iconfont icon-view"></span> <?= $value['views'] ?></a>
                                    <a href="<?= $value['log_url'] ?>#comment"><span class="iconfont icon-comment"></span> <?= $value['comnum'] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                endforeach;
            else:
                $isSearch = isset($keyword);
                ?>
                <div class="empty-wrap shadow-theme bottom-5">
                    <div class="empty-icon">
                        <?php if ($isSearch): ?>
                            <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="32" cy="32" r="30" class="empty-icon-bg" />
                                <path d="M28 38C33.5228 38 38 33.5228 38 28C38 22.4772 33.5228 18 28 18C22.4772 18 18 22.4772 18 28C18 33.5228 22.4772 38 28 38Z" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="empty-icon-stroke" />
                                <path d="M35.5 35.5L46 46" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="empty-icon-accent" />
                                <circle cx="28" cy="28" r="4" class="empty-icon-accent-fill" opacity="0.3" />
                            </svg>
                        <?php else: ?>
                            <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="32" cy="32" r="30" class="empty-icon-bg" />
                                <path d="M22 18H36L44 26V46H22V18Z" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round" class="empty-icon-stroke" />
                                <path d="M36 18V26H44" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round" class="empty-icon-stroke" />
                                <path d="M28 34H38" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" class="empty-icon-accent" />
                                <path d="M28 40H34" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" class="empty-icon-accent" />
                            </svg>
                        <?php endif; ?>
                    </div>
                    <h3 class="empty-title"><?= $isSearch ? _langTpl('search_no_result') : _langTpl('no_content') ?></h3>
                    <div class="empty-action">
                        <a href="<?= BLOG_URL ?>" class="empty-home-link"><?= _langTpl('back_to_home') ?></a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (!empty($logs)): ?>
                <div class="pagination bottom-5">
                    <?= pagination($lognum, $index_lognum, $page, $pageurl, '', 3, _langTpl('prev_page'), _langTpl('next_page')) ?>
                </div>
            <?php endif; ?>
        </div>
        <?php include View::getView('side') ?>
    </div>
</main>

<?php include View::getView('footer');
