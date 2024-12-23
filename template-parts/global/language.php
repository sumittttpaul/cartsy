<?php
$args              = cartsy_get_multi_lang_args();

$languages         = $args['languages'];
$activeLanguage    = $args['active_language'];
$inactiveLanguages = $args['inactive_languages'];
$displayAs         = $args['display_as'];
$cssClass          = $args['css_class'];
?>

<div class="cartsy-language-switcher <?php echo esc_attr($cssClass); ?>">

    <span class="cartsy-active-lang">
        <?php if ($activeLanguage['display_as'] !== 'country_flag_url') : ?>
            <span><?php echo esc_attr($activeLanguage[$displayAs]); ?></span>
        <?php else : ?>
            <img src="<?php echo esc_url($activeLanguage['country_flag_url']); ?>">
        <?php endif; ?>
        <i class="ion ion-ios-arrow-down"></i>
    </span>

    <ul class="cartsy-language-switcher-list <?php echo esc_attr($activeLanguage['display_as']) ?>">
        <?php foreach ($inactiveLanguages as $key => $language) : ?>
            <li>
                <a href="<?php echo esc_url($language['url']); ?>">
                    <?php if ($language['display_as'] !== 'country_flag_url') : ?>
                        <?php echo esc_attr($language[$displayAs]); ?>
                    <?php else : ?>
                        <img src="<?php echo esc_url($language['country_flag_url']); ?>">
                    <?php endif; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

</div>