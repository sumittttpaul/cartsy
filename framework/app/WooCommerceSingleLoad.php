<?php

namespace Framework\App;

// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

class WooCommerceSingleLoad
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        add_action('cartsy_product_single_layout', [$this, 'cartsyProductSingleLayout'], 10, 1);
    }

    /**
     * cartsyProductSingleLayout
     *
     * @return template_path
     */
    public function cartsyProductSingleLayout()
    {
	    global $product;

	    $singleLayout = '';
        if (function_exists('CartsyGlobalOptionData')) {
            $singleLayout = CartsyGlobalOptionData('woo_single_layout_switch');
        }

        switch ($singleLayout) {
            case 'layout_one':

                add_filter('woocommerce_product_tabs', [$this, 'wooRenameTabsLayoutOne'], 98);
                add_filter('woocommerce_product_description_heading', '__return_null');
                add_filter('woocommerce_product_additional_information_heading', '__return_null');
                add_filter('woocommerce_reviews_title', '__return_null');

                // if (class_exists('Woo_Variation_Swatches') && has_filter('wvs_variable_item')) {
                // add_filter('wvs_variable_item', [$this, 'cartsySingleVariationsHTML'], 10, 5);
                // add_filter('wvs_available_attributes_types', [$this, 'addCustom'], 10, 1);
                // }

                get_template_part('template-parts/product-single/layout-one/layout', 'one');
                break;

	        case 'layout_rnb_one':

	        	// If the product is rental product then execute RnB layout one
				if ($product->is_type( 'redq_rental' )){

					// Otherwise render the default layout
					add_filter('woocommerce_product_tabs', [$this, 'wooRnBRenameTabsLayoutOne'], 98);
					add_filter('woocommerce_product_description_heading', '__return_null');
					add_filter('woocommerce_product_additional_information_heading', '__return_null');
					add_filter('woocommerce_product_tabs', [$this, 'wooModifyRnBTabsLayoutOne'], 98);
					add_filter('woocommerce_product_tabs', [$this, 'wooSortRnBTabsItems'], 98);

					if (!wp_is_mobile()){
						get_template_part('template-parts/product-single/layout-rnb-one/layout-rnb', 'one');
					}else{
						get_template_part('template-parts/product-single/layout-rnb-one/mobile/layout-rnb-mobile', 'one');
					}

				}else{
					// Otherwise render the default layout
					wc_get_template_part('content', 'single-product');
				}
		        break;

            default:
                wc_get_template_part('content', 'single-product');
                break;
        }
    }

    public function addCustom($fields)
    {
        // var_dump($fields);
    }

    public function cartsySingleVariationsHTML($data, $type, $options, $args, $saved_attribute)
    {
        $product   = $args['product'];
        $attribute = $args['attribute'];
        $data      = '';

        if (!empty($options)) {
            if ($product && taxonomy_exists($attribute)) {
                $terms = wc_get_product_terms($product->get_id(), $attribute, array('fields' => 'all'));
                $name  = uniqid(wc_variation_attribute_name($attribute));
                foreach ($terms as $term) {
                    if (in_array($term->slug, $options)) {
                        $selected_class = (sanitize_title($args['selected']) == $term->slug) ? 'selected' : '';
                        $tooltip        = trim(apply_filters('wvs_variable_item_tooltip', $term->name, $term, $args));

                        $tooltip_html_attr = !empty($tooltip) ? sprintf('data-wvstooltip="%s"', esc_attr($tooltip)) : '';

                        if (wp_is_mobile()) {
                            $tooltip_html_attr .= !empty($tooltip) ? ' tabindex="2"' : '';
                        }

                        $data .= sprintf('<li %1$s class="variable-item %2$s-variable-item %2$s-variable-item-%3$s %4$s" title="%5$s" data-value="%3$s" role="button" tabindex="0">', $tooltip_html_attr, esc_attr($type), esc_attr($term->slug), esc_attr($selected_class), esc_html($term->name));

                        switch ($type):
                            case 'color':
                                $color = sanitize_hex_color(get_term_meta($term->term_id, 'product_attribute_color', true));
                                $data  .= sprintf('<span class="variable-item-span variable-item-span-%s" style="background-color:%s;"></span>', esc_attr($type), esc_attr($color));
                                break;

                            case 'image':

                                $attachment_id = apply_filters('wvs_product_global_attribute_image_id', absint(get_term_meta($term->term_id, 'product_attribute_image', true)), $term, $args);
                                $image_size    = woo_variation_swatches()->get_option('attribute_image_size');
                                $image         = wp_get_attachment_image_src($attachment_id, apply_filters('wvs_product_attribute_image_size', $image_size));
                                // $image_html = wp_get_attachment_image( $attachment_id, apply_filters( 'wvs_product_attribute_image_size', $image_size ), false, array( 'class' => '' ) );

                                $data .= sprintf('<img alt="%s" src="%s" width="%d" height="%d" />', esc_attr($term->name), esc_url($image[0]), $image[1], $image[2]);
                                break;


                            case 'button':
                                $data .= sprintf('<span class="variable-item-span variable-item-span-%s">%s</span>', esc_attr($type), esc_html($term->name));
                                break;

                            case 'radio':
                                $id   = uniqid($term->slug);
                                $data .= sprintf('<input name="%1$s" id="%2$s" class="wvs-radio-variable-item" %3$s  type="radio" value="%4$s" data-value="%4$s" /><label for="%2$s">%5$s</label>', $name, $id, checked(sanitize_title($args['selected']), $term->slug, false), esc_attr($term->slug), esc_html($term->name));
                                break;

                            default:
                                $data .= apply_filters('wvs_variable_default_item_content', '', $term, $args, $saved_attribute);
                                break;
                        endswitch;
                        $data .= '</li>';
                    }
                }
            }
        }
        return apply_filters('cartsy_wvs_variable_item', $data, $type, $options, $args, $saved_attribute);
    }

    /**
     * wooRenameTabsLayoutOne
     *
     * @param  mixed $tabs
     * @return void
     */
    public function wooRenameTabsLayoutOne($tabs)
    {
        global $product;

        // description
        if ($product->get_description() !== '') {
            $tabs['description']['title'] = __('Product Details');
        }

        // reviews
        if (comments_open()) {
            $tabs['reviews']['title'] = __('Customer Reviews');
        }

        // additiona info
        if ($product->has_attributes() || $product->has_dimensions() || $product->has_weight()) {
            $tabs['additional_information']['title'] = __('Additional Informations');
        }
        return $tabs;
    }


	/**
	 * Control add or remove product tab
	 *
	 * @param $tabs
	 *
	 * @return mixed
	 *
	 * @subpackage    Redq_wc
	 */
	function wooModifyRnBTabsLayoutOne( $tabs ) {
		$singleLayout = '';

		if ( function_exists( 'CartsyGlobalOptionData' ) ) {
			$singleLayout = CartsyGlobalOptionData( 'woo_single_layout_switch' );
		}

		if ( $singleLayout == 'layout_rnb_one' ) {
			global $product, $post;
			$productType = wc_get_product( $post->ID )->get_type();
			if ( $productType === 'redq_rental' ) {
				unset( $tabs['attributes'] );

				return $tabs;
			}
		}

		return $tabs;
	}


	/**
	 * Sort tabs for rental tabs
	 *
	 * @param $tabs
	 *
	 * @return mixed
	 */
	public function wooSortRnBTabsItems($tabs){
		if (isset($tabs['description'])){
			$tabs['description']['priority'] = 5;
		}

		return $tabs;
	}


	/**
	 * wooRnBRenameTabsLayoutOne
	 *
	 * @param  mixed $tabs
	 * @return void
	 */
	public function wooRnBRenameTabsLayoutOne($tabs)
	{
		global $product;

		// description
		if ($product->get_description() !== '') {
			$tabs['description']['title'] = __('Product Details');
		}

		// reviews
		if (comments_open()) {
			$tabs['reviews']['title'] = __('Customer Reviews');
		}

		// additional info
		if ($product->has_attributes() || $product->has_dimensions() || $product->has_weight()) {
			$tabs['additional_information']['title'] = __('Additional Information');
		}
		return $tabs;
	}
}
