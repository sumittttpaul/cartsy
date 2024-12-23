<?php
$allowedIframe = cartsy_allowed_iframe_html();
$cartsyReadMoreText = esc_html__('Read More', 'cartsy');
$allowed_html = wp_kses_allowed_html('post');
$content = do_shortcode(apply_filters('the_content', $post->post_content));
$media = get_media_embedded_in_content($content, array('video', 'iframe'));
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <div class="entry-media">
    <?php
    echo wp_kses(do_shortcode($media[0]), $allowedIframe);
    ?>
  </div>
  <!-- .entry-media -->

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
</article><!-- #post-<?php the_ID(); ?> -->