<?php
$blogSingleBannerSwitch = 'off';
if (function_exists('CartsyGlobalOptionData')) {
  $blogSingleBannerSwitch = !empty(CartsyGlobalOptionData('blog_baner_switch')) ? CartsyGlobalOptionData('blog_baner_switch') : 'off';
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php if (has_post_thumbnail()) : ?>
    <div class="entry-media">
      <?php
      cartsy_post_thumbnail();
      ?>
    </div>
  <?php endif; ?>
  <!-- .entry-media -->

  <header class="entry-header">
    <?php
    if ('post' === get_post_type()) :
    ?>
      <div class="entry-meta">
        <?php
        cartsy_post_meta();
        ?>
      </div>
      <!-- .entry-meta -->
    <?php endif; ?>

    <?php
    if (!empty($blogSingleBannerSwitch) && $blogSingleBannerSwitch === 'off') {
      the_title('<h3 class="entry-title">', '</h3>');
    }
    ?>
  </header>
  <!-- .entry-header -->

  <div class="entry-content">
    <?php
    the_content(sprintf(
      wp_kses(
        /* translators: %s: Name of current post. Only visible to screen readers */
        esc_html__('Continue reading<span class="screen-reader-text"> "%s"</span>', 'cartsy'),
        array(
          'span' => array(
            'class' => array(),
          ),
        )
      ),
      get_the_title()
    ));

    wp_link_pages(array(
      'before' => '<div class="page-links">' . esc_html__('Pages:', 'cartsy'),
      'after'  => '</div>',
    ));
    ?>
  </div>
  <!-- .entry-content -->
</article>
<!-- #post-<?php the_ID(); ?> -->

<?php
$tagsList = get_the_tag_list('', esc_html_x(', ', 'Comma used between tag items.', 'cartsy'));
$categoriesList = get_the_category_list(esc_html_x(', ', 'Comma used between category items.', 'cartsy'));

if ($tagsList) {
  printf(
    '<div class="entry-post-tags"> 
          <span class="tag-title">%1$s </span>
          <span class="tag-items">%2$s</span>
          </div>',
    esc_html_x('Tags: ', 'Used before tag items.', 'cartsy'),
    $tagsList
  );
}
// end of .entry-post-tag

if ($categoriesList) {
  printf(
    '<div class="entry-post-categories">
          <span class="cat-title">%1$s </span>
          <span class="cat-items">%2$s</span>
          </div>',
    esc_html_x('Categories :', 'Used before category items.', 'cartsy'),
    $categoriesList
  );
}
// end of .entry-post-category

if (is_singular('attachment')) {
  the_post_navigation(
    array(
      /* translators: %s: parent post link */
      'prev_text' => sprintf(
        esc_html__('<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'cartsy'),
        '%title'
      ),
    )
  );
} elseif (is_singular('post')) {
  cartsy_post_navigation();
}
// end of .post-navigation
