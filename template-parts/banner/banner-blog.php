<?php
$screenID = $getOptionsPageBanner = $html = $pageBannerImage = $pageBannerColor = $pageCustomTitleSwitch = $pageCustomTitle = $pageCustomSubTitleSwitch = $pageCustomSubTitle = $defaultBannerImg = $pageBannerImageLink = $blogBannerColorSchemaValue = $blogBannerColorSchemaLoad = '';
$blog_color_schema = [];
$pageBannerSwitch = $showBreadCrumb = 'off';
$pageBannerType = 'image';

$screenID = CartsyGetCurrentPageID();
// $defaultBannerImg = get_template_directory_uri() . '/assets/images/profile-cover.png';
$banner_title     = get_the_title();
$getOptionsPageBanner = !empty(get_post_meta($screenID, '_blog_get_option', true)) ? get_post_meta($screenID, '_blog_get_option', true) : 'global';
$allowedHTML = wp_kses_allowed_html('post');


if ($getOptionsPageBanner !== 'local') {
  if (function_exists('CartsyGlobalOptionData')) {
    $pageBannerSwitch            = !empty(CartsyGlobalOptionData('blog_baner_switch')) ? CartsyGlobalOptionData('blog_baner_switch') : 'off';
    $showBreadCrumb              = !empty(CartsyGlobalOptionData('blog_breadcrumb_switch')) ? CartsyGlobalOptionData('blog_breadcrumb_switch') : 'off';
    $pageBannerType              = CartsyGlobalOptionData('blog_banner_type');
    $pageBannerImage             = CartsyGlobalOptionData('blog_banner_image');
    $pageBannerColor             = CartsyGlobalOptionData('blog_banner_color');
    $pageBannerTextColor         = CartsyGlobalOptionData('blog_banner_text_color');
  }
} else {
  if (function_exists('CartsyLocalOptionData')) {
    $pageBannerSwitch          = CartsyLocalOptionData($screenID, '_blog_baner_switch', 'true');
    $pageBannerType            = CartsyLocalOptionData($screenID, '_blog_banner_type', 'true');
    $pageBannerImageLink       = CartsyLocalOptionData($screenID, '_blog_banner_image', 'true');
    $pageBannerColor           = CartsyLocalOptionData($screenID, '_blog_banner_color', 'true');
    $pageBannerTextColor       = CartsyLocalOptionData($screenID, '_blog_banner_text_color', 'true');
    // Setting Default values
    $pageBannerSwitch = $pageBannerSwitch !== '' ? $pageBannerSwitch : 'off';
    $pageBannerType = $pageBannerType !== '' ? $pageBannerType : 'image';
    $pageBannerColor = $pageBannerColor !== '' ? $pageBannerColor : '#323232';
    $pageBannerTextColor = $pageBannerTextColor !== '' ? $pageBannerTextColor : '#ffffff';

    if (!empty($pageBannerImageLink) && isset($pageBannerImageLink)) {
      $pageBannerImage = $pageBannerImageLink[0]['url'];
    }
    array_push($blog_color_schema, [
      'blogBannerBGColor' => $pageBannerColor,
      'blogBannerTextColor' => $pageBannerTextColor,
    ]);
    $blogBannerColorSchemaValue = BlogDynamicCSS($blog_color_schema);
    if (!empty($blogBannerColorSchemaValue)) {
      $blogBannerColorSchemaLoad .= "style='$blogBannerColorSchemaValue'";
    }
  }
}
?>

<?php if (!empty($pageBannerSwitch) && $pageBannerSwitch !== 'off') : ?>
  <?php if ($pageBannerType !== 'image') : ?>
    <div class="cartsy-page-title cartsy-banner-type-blog color" <?php echo apply_filters('blog_banner_color_schema', $blogBannerColorSchemaLoad); ?>>
    <?php else : ?>
      <div class=" cartsy-page-title cartsy-banner-type-blog">
        <?php if (!empty($pageBannerImage)) : ?>
          <div class="cartsy-page-thumb-area">
            <img src="<?php echo esc_url($pageBannerImage); ?>" alt="<?php the_title(); ?>" />
          </div>
        <?php endif; ?>
      <?php endif; ?>
      <div class="cartsy-page-title-content">
        <?php if (is_home()) : ?>
          <?php
          if (get_option('page_for_posts', true) !== '0') :
            $our_title = get_the_title(get_option('page_for_posts', true));
          else :
            $our_title = esc_html__('Blog', 'cartsy');
          endif;
          ?>
          <span><?php echo esc_html__('explore', 'cartsy'); ?></span>
          <h1><?php echo esc_html($our_title); ?></h1>
        <?php elseif (is_category()) : ?>
          <span><?php echo esc_html__('explore category ', 'cartsy'); ?></span>
          <h1>
            <?php
            printf(esc_html__(' %s', 'cartsy'), '' . single_cat_title('', false) . '');
            ?>
          </h1>
        <?php elseif (is_tag()) : ?>
          <span><?php echo esc_html__('explore tag ', 'cartsy'); ?></span>
          <h1>
            <?php
            printf(esc_html__(' %s', 'cartsy'), '' . single_tag_title('', false) . '');
            ?>
          </h1>
        <?php elseif (is_author()) : ?>
          <?php
          $curauth = get_query_var('author_name') ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
          ?>
          <span><?php echo esc_html__('explore author posts ', 'cartsy'); ?></span>
          <h1>
            <?php echo esc_attr($curauth->display_name); ?>
          </h1>
        <?php elseif (is_404()) : ?>
          <h1><?php echo esc_html__('Error 404', 'cartsy'); ?></h1>
        <?php elseif (is_archive()) : ?>
          <?php if (class_exists('WooCommerce') && (is_shop() || is_product_category())) : ?>
            <h1><?php woocommerce_page_title(); ?></h1>
          <?php else : ?>
            <?php if (is_day()) : ?>
              <span><?php echo esc_html__('explore daily archives ', 'cartsy'); ?></span>
              <h1><?php printf(esc_html__(' %s', 'cartsy'), get_the_date()); ?></h1>
            <?php elseif (is_month()) : ?>
              <span><?php echo esc_html__('explore monthly archives ', 'cartsy'); ?></span>
              <h1>
                <?php
                printf(
                  esc_html__(' %s', 'cartsy'),
                  get_the_date(_x('F Y', 'monthly archives date format', 'cartsy'))
                );
                ?>
              </h1>
            <?php elseif (is_year()) :  ?>
              <span><?php echo esc_html__('explore yearly archives ', 'cartsy'); ?></span>
              <h1>
                <?php
                printf(
                  esc_html__(' %s', 'cartsy'),
                  get_the_date(_x('Y', 'yearly archives date format', 'cartsy'))
                );
                ?>
              </h1>
            <?php else : ?>
              <span><?php echo esc_html__('explore', 'cartsy'); ?></span>
              <h1><?php esc_html_e('Blog Archives', 'cartsy'); ?></h1>
            <?php endif; ?>
          <?php endif; ?>

        <?php elseif (is_search()) : ?>
          <h1>
            <?php echo esc_html__('Search query : ', 'cartsy'); ?>
            <?php echo ' "'; ?>
            <?php echo esc_attr(get_search_query()); ?>
            <?php echo '"'; ?>
          </h1>
        <?php else : ?>
          <span><?php echo esc_html__('explore ', 'cartsy'); ?></span>
          <h1><?php echo wp_kses($banner_title, $allowedHTML); ?></h1>
        <?php endif; ?>
        <?php
        if ($showBreadCrumb === 'on') {
          if (function_exists('CartsyBreadcrumb')) {
            CartsyBreadcrumb();
          }
        }
        ?>
      </div>

      </div>

    <?php endif; ?>