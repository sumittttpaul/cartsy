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

</div><!-- #page -->

<footer id="colophon" class="site-footer cartsy-site-footer">

    <?php
    /**
     * Functions hooked into cartsy_footer action
     *
     * @see template-hooks.php file
     * @see template-function.php file
     */
    do_action('cartsy_footer_' . cartsy_get_footer_layout());
    ?>

    <?php
    /**
     * Functions hooked into cartsy_copyright action
     *
     * @see template-hooks.php file
     * @see template-function.php file
     */
    do_action('cartsy_copyright_' . cartsy_get_copyright_layout());
    ?>

</footer>

<?php wp_footer(); ?>
</body>

</html>