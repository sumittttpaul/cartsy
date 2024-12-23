<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cartsy
 */

?>

</div><!-- #content -->


<footer id="colophon" class="site-footer cartsy-site-footer">
    <?php get_template_part('template-parts/copyright/copyright'); ?>
</footer><!-- #colophon -->
</div><!-- #page -->
<?php
if (function_exists('cartsyNewsLetterInit')) {
    cartsyNewsLetterInit();
}
?>
<?php wp_footer(); ?>
</body>

</html>