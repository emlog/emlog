<?php get_header(); ?>
<div id="container">
  <div id="search">
    <form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
      <input type="text" value="<?php the_search_query(); ?>" name="s" id="s" class="txtField" />
      <input type="submit" id="searchsubmit" class="btnSearch" value="Find It &raquo;" />
    </form>
  </div>
  <div id="menu-holder"><?php include ('navigation.php'); ?></div>
  <div id="title">
    <h2><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h2>
    <?php bloginfo('description'); ?></div>
</div>
<div id="content">
  <div class="col01">
  <?php if (have_posts()) : ?>
  <?php while (have_posts()) : the_post(); ?>
    <div class="post" id="post-<?php the_ID(); ?>">
      <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?></a></h3>
      <div class="post-inner">
        <div class="date-tab"><span class="month"><?php the_time('F') ?></span><span class="day"><?php the_time('j') ?></span></div>
        <div class="thumbnail"><?php $key="thumbnail"; echo get_post_meta($post->ID, $key, true); ?></div>
		<?php the_content('Read the rest of this entry &raquo;'); ?>
      </div>
      <div class="meta">posted under <?php the_category(', ') ?> |  <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?></div>
    </div>
    <?php endwhile; ?>
    <div class="post-nav"><span class="previous"><?php next_posts_link('&laquo; Older Entries') ?></span><span class="next"><?php previous_posts_link('Newer Entries &raquo;') ?></span></div>
    <?php else : ?>
    <div class="no-results">
<h3>Not Found</h3>
    <p>Sorry, but you are looking for something that isn't here.</p>
</div>
    <?php endif; ?>
  </div>
  <div class="col02">
    <div class="recent-posts">
    <?php
    query_posts('showposts=10');
	?>
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <ul>
    <li><a href="<?php the_permalink() ?>"><?php the_title() ?><br />
    <span class="listMeta"><?php the_time('g:i a') ?>, <?php the_time('F') ?> <?php the_time('j') ?>, <?php the_time('Y') ?></span></a></li>
    </ul>
    <?php endwhile; endif; ?>
    </div>
    <div class="postit-bottom"></div>
    <?php get_sidebar(); ?>
  </div>
  <br clear="all" />
</div>
<?php get_footer(); ?>