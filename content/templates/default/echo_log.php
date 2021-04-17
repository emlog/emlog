<?php
/**
 * 阅读文章页面
 */
if (!defined('EMLOG_ROOT')) {
    exit('error!');
}
?>  
    <div class="container log_con">
        <span class="back_top mh"  onclick="history.go(-1);">&laquo;</span>
        <header class="log_title"><?php topflg($top); ?><?php echo $log_title; ?></header>
        <hr />
        <p class="date"><b>时间：</b><?php echo gmdate('Y-n-j', $date); ?>&nbsp;&nbsp;&nbsp;
        <b>作者：</b><?php blog_author($author); ?>&nbsp;&nbsp;&nbsp;
        <b>分类：</b><?php blog_sort($logid); ?>
        <?php editflg($logid, $author); ?></p>
        <hr style="margin-bottom: 30px;"/>
        <?php echo $log_content; ?>
        
        <p class="tag" style="margin-top: 30px;font-size: x-small;"><?php blog_tag($logid); ?></p>
        <?php doAction('log_related', $logData); ?>
        
        <nav class="neighbor_log">
        <?php neighbor_log($neighborLog); ?>
        </nav>
        
        <?php blog_comments_post($logid, $ckname, $ckmail, $ckurl, $verifyCode, $allow_remark); ?>
        <?php blog_comments($comments); ?>
        <div style="clear:both;"></div>
    </div>

<?php
include View::getView('footer');
?>
