<?php
woocommerce_wp_text_input(
    [
        'id'          => '_cartsy_woocommerce_product_unit_label',
        'data_type'   => 'text',
        'label'       => __('Product Unit Label', 'cartsy'),
        'placeholder' => __('Ex. /, per', 'cartsy'),
        'class'       => 'cartsy-woocommerce-product-unit-label',
        'desc_tip'    => true,
        'description' => __('Enter product unit label that will show before product unit in front-end', 'cartsy'),
    ]
);

woocommerce_wp_text_input(
    [
        'id'          => '_cartsy_woocommerce_product_unit',
        'data_type'   => 'text',
        'label'       => __('Product Unit', 'cartsy'),
        'placeholder' => __('Ex. kg, ml', 'cartsy'),
        'class'       => 'cartsy-woocommerce-product-unit',
        'desc_tip'    => true,
        'description' => __('Enter product unit that will show in product front-end', 'cartsy'),
    ]
);
