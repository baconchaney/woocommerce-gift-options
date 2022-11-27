<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $product->is_purchasable() && $product->is_in_stock() ) {
		$post_id = $product->get_id();
		$gift_option = get_post_meta($post_id, 'cc_wc_gift_giftwrapping_option');
		
		if ($gift_option && $gift_option[0] == 1) {  ?>
            <div class="gift-toggle">
                <input type="checkbox" id="gift_toggle" name="gift_toggle" value="gift_toggle" />
                <label for="gift_toggle">Add a message</label>
            </div>
		<?php }
		if ($gift_option && $gift_option[0] == 2) { 
			$giftWrapPrice = get_post_meta($post_id, 'cc_wc_gift_giftwrapping_price');
		?>
            <div class="gift-toggle">
                <input type="checkbox" id="gift_toggle" name="gift_toggle" value="gift_toggle" />
                <label for="gift_toggle">Add gift wrapping? (+<?php echo get_woocommerce_currency_symbol() . $giftWrapPrice[0];?>)</label>
            </div>
      	<?php } 
			if ($gift_option && $gift_option[0] != 0) { 
		?>
            <div id="gift-fields" class="">
            	<label for="recipient" class="screen-reader-text">Recipient's name:</label>
                <input id="recipient" name="recipient" placeholder="Recipient's name" /><br/>
            	<label for="message" class="screen-reader-text">Your message:</label>
                <textarea id="message" name="message" maxlength ="250" placeholder="Your message" rows="4"/></textarea><br/>
                <em id="gift-char-count"><span id="gift-char-count-value">250</span>/250 characters left</em><br/>
            	<label for="from" class="screen-reader-text">From:</label>
                <input id="from" name="from" placeholder="From" />
            </div>
	<?php }
	}
