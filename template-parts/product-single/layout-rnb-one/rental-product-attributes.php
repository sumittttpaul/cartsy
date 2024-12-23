<?php
$attributes_by_inventories = WC_Product_Redq_Rental::redq_get_rental_non_payable_attributes( 'attributes' );
$total_inventories         = count( $attributes_by_inventories );
?>

<?php if ( isset( $attributes_by_inventories ) && ! empty( $attributes_by_inventories ) ) : ?>
    <div class="rnb-attributes-wrapper">
		<?php foreach ( $attributes_by_inventories as $key => $attributes_by_inventory ) : ?>
			<?php
			$inventory_name = $attributes_by_inventory['title'];
			$attributes     = isset( $attributes_by_inventory['attributes'] ) ? $attributes_by_inventory['attributes'] : [];
			?>
			<?php if ( isset( $attributes ) && ! empty( $attributes ) ) : ?>
				<?php if ( $total_inventories > 1 ) : ?>
                    <h2 class="rnb-single-product-attribute-title"><?php echo $inventory_name; ?></h2>
				<?php endif; ?>

                <div class="rnb-attributes-content">
					<?php foreach ( $attributes as $attr_key => $attribute ) : ?>
                        <div class="rnb-attribute-item">
							<?php if ( isset( $attribute['selected_icon'] ) && $attribute['selected_icon'] !== 'image' ) : ?>
                                <span class="attribute-icon"><i
                                            class="<?php echo esc_attr( $attribute['icon'] ); ?>"></i></span>
							<?php else : ?>
								<?php $attribute_image = wp_get_attachment_image_src( $attribute['image'] ); ?>
                                <img src="<?php echo esc_url( $attribute_image['0'] ); ?>" alt="img">
							<?php endif; ?>
                            <h6 class="rnb-attribute-item-title"><?php echo esc_attr( $attribute['name'] ); ?></h6>
                            <h4 class="rnb-attribute-item-number"><?php echo esc_attr( $attribute['value'] ); ?></h4>
                        </div>
					<?php endforeach; ?>
                </div>
            
			<?php endif; ?>
		<?php endforeach; ?>
    </div>
<?php endif; ?>
