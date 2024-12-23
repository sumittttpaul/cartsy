<?php
global $post;
$screenID = $getOptionsPageBanner = $html = $pageBannerImage = $pageBannerColor = $pageCustomTitleSwitch = $pageCustomTitle = $pageCustomSubTitleSwitch = $pageCustomSubTitle = $pageBannerImageLink = $bannerColorSchemaValue = $bannerColorSchemaLoad = '';
$pageCustomTitleSwitch = $pageCustomSubTitleSwitch = 'on';
$pageBannerSwitch = $showBreadCrumb = 'off';
$blog_color_schema = [];
$pageBannerType = 'image';
$pageBannerTextColor = '#fff';
$screenID = CartsyGetCurrentPageID();

$getOptionsPageBanner = !empty(get_post_meta($screenID, '_general_get_option', true)) ? get_post_meta($screenID, '_general_get_option', true) : 'global';
$allowed_html = wp_kses_allowed_html('post');
if ($getOptionsPageBanner !== 'local') {
  if (function_exists('CartsyGlobalOptionData')) {
    $pageBannerSwitch            = !empty(CartsyGlobalOptionData('page_banner_switch')) ? CartsyGlobalOptionData('page_banner_switch') : 'off';
    $showBreadCrumb              = !empty(CartsyGlobalOptionData('page_breadcrumb_switch')) ? CartsyGlobalOptionData('page_breadcrumb_switch') : 'off';
    $pageBannerType              = CartsyGlobalOptionData('page_banner_type');
    $pageBannerImage             = CartsyGlobalOptionData('page_banner_image');
    $pageBannerColor             = CartsyGlobalOptionData('page_banner_color');
    $pageCustomSubTitleSwitch    = CartsyGlobalOptionData('page_custom_subtitle_switch');
    $pageCustomSubTitle          = CartsyGlobalOptionData('page_custom_subtitle');
    $pageBannerTextColor         = CartsyGlobalOptionData('page_banner_text_color');
  }
} else {
  if (function_exists('CartsyLocalOptionData')) {
    $pageBannerSwitch            = !empty(CartsyLocalOptionData($screenID, '_page_banner_switch', 'true')) ? CartsyLocalOptionData($screenID, '_page_banner_switch', 'true') : 'off';
    $pageBannerType              = CartsyLocalOptionData($screenID, '_page_banner_type', 'true');
    $pageBannerImageLink         = CartsyLocalOptionData($screenID, '_page_banner_image', 'true');
    $pageCustomSubTitleSwitch    = CartsyLocalOptionData($screenID, '_page_custom_subtitle_switch', 'true');
    $pageCustomSubTitle          = CartsyLocalOptionData($screenID, '_page_custom_subtitle', 'true');

    $pageBannerColor             = CartsyLocalOptionData($screenID, '_page_banner_color', 'true');
    $pageBannerTextColor         = CartsyLocalOptionData($screenID, '_page_banner_text_color', 'true');

    // Setting Default values
    $pageBannerSwitch = $pageBannerSwitch !== '' ? $pageBannerSwitch : 'on';
    $pageBannerType = $pageBannerType !== '' ? $pageBannerType : 'image';
    $pageBannerColor = $pageBannerColor !== '' ? $pageBannerColor : '#323232';
    $pageCustomSubTitleSwitch = $pageCustomSubTitleSwitch !== '' ? $pageCustomSubTitleSwitch : 'on';
    $pageBannerTextColor = $pageBannerTextColor !== '' ? $pageBannerTextColor : '#ffffff';

    if (!empty($pageBannerImageLink) && isset($pageBannerImageLink)) {
      $pageBannerImage = $pageBannerImageLink[0]['url'];
    }
    array_push($blog_color_schema, [
      'pageBannerBGColor' => $pageBannerColor,
      'pageBannerTextColor' => $pageBannerTextColor,
    ]);
    $bannerColorSchemaValue = BannerDynamicCSS($blog_color_schema);
    if (!empty($bannerColorSchemaValue)) {
      $bannerColorSchemaLoad .= "style='$bannerColorSchemaValue'";
    }
  }
}
?>
<?php if (!empty($pageBannerSwitch) && $pageBannerSwitch === 'on') { ?>
  <?php if ($pageBannerType === 'image') { ?>
    <div class="cartsy-page-title image">
      <?php if (!empty($pageBannerImage)) { ?>
        <div class="cartsy-page-thumb-area">
          <img src="<?php echo esc_url($pageBannerImage); ?>" alt="<?php the_title(); ?>" />
        </div>
      <?php } else if (has_post_thumbnail()) { ?>
        <div class="cartsy-page-thumb-area">
          <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" />
        </div>
      <?php } ?>

      <div class="cartsy-page-title-content">
        <?php if (!empty($pageCustomSubTitleSwitch) &&  $pageCustomSubTitleSwitch === 'on') { ?>
          <?php if (!empty($pageCustomSubTitle)) { ?>
            <span><?php echo wp_kses($pageCustomSubTitle, $allowed_html); ?></span>
          <?php } else { ?>
            <span><?php echo esc_html__('explore', 'cartsy'); ?></span>
          <?php } ?>
        <?php } ?>
        <?php if (!empty($post->post_title)) { ?>
          <h1><?php the_title(); ?></h1>
        <?php } ?>
        <?php
        if ($showBreadCrumb === 'on') {
          if (function_exists('CartsyBreadcrumb')) {
            CartsyBreadcrumb();
          }
        }
        ?>
      </div>
    </div>

  <?php } else { ?>
    <div class="cartsy-page-title color" <?php echo apply_filters('page_banner_color_schema', $bannerColorSchemaLoad); ?>>
      <div class="cartsy-page-title-content">
        <?php if (!empty($pageCustomSubTitleSwitch) &&  $pageCustomSubTitleSwitch === 'on') : ?>
          <?php if (!empty($pageCustomSubTitle)) : ?>
            <span><?php echo wp_kses($pageCustomSubTitle, $allowed_html); ?></span>
          <?php else : ?>
            <span><?php echo esc_html__('explore', 'cartsy'); ?></span>
          <?php endif; ?>
        <?php endif; ?>
        <?php if (!empty($post->post_title)) { ?>
          <h1><?php the_title(); ?></h1>
        <?php } ?>
        <?php
        if ($showBreadCrumb === 'on') {
          if (function_exists('CartsyBreadcrumb')) {
            CartsyBreadcrumb();
          }
        }
        ?>
      </div>
    </div>
  <?php } ?>
<?php } ?>