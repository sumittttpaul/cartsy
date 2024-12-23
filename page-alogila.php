<?php

/**
 * Template Name: Cartsy Algolia Search Template
 *
 * @package WordPress
 * @subpackage Cartsy
 * @since Cartsy 1.0.0
 */
?>
<?php
get_header();
?>

<div class="cartsy-full-width-content">
    <?php
    while (have_posts()) : the_post();
        the_content();
    endwhile;
    ?>
</div>

<?php
get_footer();
?>