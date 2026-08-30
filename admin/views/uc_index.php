<?php defined('EMLOG_ROOT') || exit('access denied!'); ?>

<?php
$can_post_article = !Article::hasForbidPost();
$can_post_twitter = Option::get('allow_user_twitter') === 'y';
$card_count = ($can_post_article ? 1 : 0) + ($can_post_twitter ? 1 : 0) + 1;
$card_col = $card_count == 3 ? '4' : ($card_count == 2 ? '6' : '12');
?>
<!-- 数据概览卡片统计 -->
<div class="row mb-4">
    <?php if ($can_post_article): ?>
        <div class="mb-3 mb-md-0 col-md-<?= $card_col ?>">
            <div class="uc-card p-4 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small font-weight-bold text-uppercase mb-1"><?= Option::get("posts_name") ?></div>
                    <div class="h3 mb-0 font-weight-bold text-gray-800"><a href="./article.php" class="text-dark text-decoration-none"><?= $article_amount ?></a></div>
                </div>
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; background: #e0f2fe; color: #0284c7;">
                    <i class="icofont-pencil-alt-5 fa-2x"></i>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($can_post_twitter): ?>
        <div class="mb-3 mb-md-0 col-md-<?= $card_col ?>">
            <div class="uc-card p-4 d-flex align-items-center justify-content-between">
                <div>
                    <div class="text-muted small font-weight-bold text-uppercase mb-1"><?= Option::get('twitter_name') ?></div>
                    <div class="h3 mb-0 font-weight-bold text-gray-800"><a href="./twitter.php" class="text-dark text-decoration-none"><?= $note_amount ?></a></div>
                </div>
                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; background: #fef3c7; color: #d97706;">
                    <i class="icofont-penalty-card fa-2x"></i>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="mb-3 mb-md-0 col-md-<?= $card_col ?>">
        <div class="uc-card p-4 d-flex align-items-center justify-content-between">
            <div>
                <div class="text-muted small font-weight-bold text-uppercase mb-1"><?= _lang('received_comments') ?></div>
                <div class="h3 mb-0 font-weight-bold text-gray-800"><a href="./comment.php" class="text-dark text-decoration-none"><?= $comment_amount ?></a></div>
            </div>
            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; background: #f0fdf4; color: #16a34a;">
                <i class="icofont-comment fa-2x"></i>
            </div>
        </div>
    </div>
</div>

<!-- 最新动态列表卡片组 -->
<div class="row">
    <?php if (!Article::hasForbidPost()): ?>
        <div class="col-lg-6 mb-4">
            <div class="uc-card h-100">
                <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-gray-800"><?= _lang('recent_published') . Option::get("posts_name") ?></h6>
                    <a href="./article.php" class="small text-primary text-decoration-none">查看全部</a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php
                        if ($logs):
                            foreach ($logs as $v) :
                        ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3 border-0 border-bottom">
                                    <a href="<?= Url::log($v['gid']) ?>" target="_blank" class="text-dark text-decoration-none text-truncate mr-3"><?= $v['title'] ?></a>
                                    <span class="badge badge-light text-muted px-2 py-1"><i class="icofont-eye-open mr-1"></i><?= $v['views'] ?></span>
                                </li>
                            <?php
                            endforeach;
                        else:
                            ?>
                            <div class="p-4 text-center text-muted"><?= _lang('empty_list') ?></div>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-lg-<?= Article::hasForbidPost() ? '12' : '6' ?> mb-4">
        <div class="uc-card h-100">
            <div class="card-header bg-white border-bottom py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-gray-800"><?= _lang('recent_received_comments') ?></h6>
                <a href="./comment.php" class="small text-primary text-decoration-none">查看全部</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php
                    if ($comments):
                        foreach ($comments as $v) : ?>
                            <li class="list-group-item px-4 py-3 border-0 border-bottom">
                                <a href="<?= Url::log($v['gid']) ?>" target="_blank" class="text-secondary text-decoration-none text-truncate d-block">
                                    <?= subString($v['comment'], 0, 30) ?>
                                </a>
                            </li>
                        <?php endforeach;
                    else:
                        ?>
                        <div class="p-4 text-center text-muted"><?= _lang('empty_list') ?></div>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>

    <?php doAction('user_main_content') ?>
</div>