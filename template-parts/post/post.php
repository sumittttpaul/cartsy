<?php
$cartsyReadMoreText = esc_html__('Read More', 'cartsy');
$allowed_html = wp_kses_allowed_html('post');
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

    <div class="entry-meta">
      <?php
      cartsy_post_meta();

      if (get_post_type() === 'post') {
        cartsy_post_category();
      }
      ?>
    </div>
    <!-- .entry-meta -->
    <?php
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
</article><!-- #post-<?php the_ID(); ?> -->