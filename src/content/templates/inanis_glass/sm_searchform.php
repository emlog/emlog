<?php if(!defined('EMLOG_ROOT')) {exit('error!');} ?>
<form method="get" name="keyform" id="searchform" action="<?php echo BLOG_URL; ?>">
  <div class="search-form">
    <input onfocus="SearchBoxFocus();" onblur="SearchBoxBlur();" id="searchbox" type="text" value="开始搜索" name="keyword" class="sm-search-text"/><input type="submit" id="searchsubmit" value="" class="sm-search-submit" />
  </div>
</form>
