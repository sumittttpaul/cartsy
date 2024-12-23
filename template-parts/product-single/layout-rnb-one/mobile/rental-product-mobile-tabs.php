<?php

defined('ABSPATH') || exit;

global $product;

$showTabs = 'on';
if (function_exists('CartsyGlobalOptionData')) {
    $showTabs = CartsyGlobalOptionData('woo_single_tabs_switch');
}

?>

<div class="cartsy-product-data-tabs-wrap layout-one">
    <?php if ($showTabs === 'on') { ?>
        <?php $tabs = apply_filters('woocommerce_product_tabs', array()); ?>
        <?php if (!empty($tabs)) : ?>
            <div class="cartsy-accordion woocommerce-tabs wc-tabs-wrapper">
                <?php foreach ($tabs as $key => $tab) : ?>
                    <h2 class="cartsy-accordion-title cartsy-faq-single-title-<?php echo esc_attr($key); ?>">
                        <div class="cartsy-accordion-label">
                            <?php echo wp_kses_post(apply_filters('woocommerce_product_' . $key . '_tab_title', $tab['title'], $key)); ?>
                        </div>
                    </h2>
                    <div class="cartsy-accordion-content cartsy-faq-single-content-<?php echo esc_attr($key); ?>">
                        <?php
                        if (isset($tab['callback'])) {
                            call_user_func($tab['callback'], $key, $tab);
                        }
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php } ?>
</div>
