<div class="menu-cart-area footer-cart-counter">
    <div class="cartsy-mini-cart-status">
        <svg width="16" height="16" viewBox="0 0 16 16">
            <path id="shopping-bag" d="M4.4,3.6H15.6a.8.8,0,0,1,.8.8V15.6a.8.8,0,0,1-.8.8H4.4a.8.8,0,0,1-.8-.8V4.4A.8.8,0,0,1,4.4,3.6ZM2,4.4A2.4,2.4,0,0,1,4.4,2H15.6A2.4,2.4,0,0,1,18,4.4V15.6A2.4,2.4,0,0,1,15.6,18H4.4A2.4,2.4,0,0,1,2,15.6ZM10,10C7.791,10,6,7.851,6,5.2H7.6c0,2.053,1.335,3.2,2.4,3.2s2.4-1.147,2.4-3.2H14C14,7.851,12.209,10,10,10Z" transform="translate(-2 -2)" fill="#ffffff" fill-rule="evenodd"></path>
        </svg>
        <?php echo esc_html__('Added', 'cartsy'); ?>
        <span class="count">
            <?php echo wp_kses_data(sprintf(_n('%d item', '%d items', WC()->cart->get_cart_contents_count(), 'cartsy'), WC()->cart->get_cart_contents_count())); ?>
        </span>
    </div>
    <div class="cartsy-mini-cart-price">
        <?php echo wp_kses_post(WC()->cart->get_cart_subtotal()); ?>
    </div>
</div>