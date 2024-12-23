<?php
$cartsyReadMoreText = esc_html__('Read More', 'cartsy');
$allowed_html = wp_kses_allowed_html('post');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <div class="entry-media">
    <?php
    cartsy_post_thumbnail();
    ?>
  </div>
  <!-- .entry-media -->

  <div class="inner-wrapper">
    <header class="entry-header">
      <?php
      if ('post' === get_post_type()) :
      ?>
        <div class="entry-meta">
          <?php
          cartsy_post_meta();
          cartsy_post_category();
          ?>
        </div>
        <!-- .entry-meta -->
      <?php endif;

      the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>');
      ?>
    </header>
    <!-- .entry-header -->

    <div class="entry-content">
      <?php
      the_excerpt();
      ?>
    </div>
    <!-- .entry-content -->

    <footer class="entry-footer">
      <a class="cartsy-read-more" href="<?php echo esc_url(get_permalink()); ?>">
        <?php echo wp_kses($cartsyReadMoreText, $allowed_html); ?>
      </a>
    </footer>
    <!-- .entry-footer -->
  </div>
</article><!-- #post-<?php the_ID(); ?> -->