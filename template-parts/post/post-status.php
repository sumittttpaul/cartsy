<?php
$thumbnailUrl = get_the_post_thumbnail_url();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="background-image: url(<?php echo esc_url($thumbnailUrl); ?>)">
  <?php
  the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>');
  ?>
  <i class="icon ion-ios-paper"></i>
</article><!-- #post-<?php the_ID(); ?> -->