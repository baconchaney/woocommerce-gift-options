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
                <input type="checkbox" id="gift_toggle" name="gift_toggle" value="gift_toggle" checked="checked" />
                <label for="gift_toggle"><?php _e('Add a message');?></label>
            </div>
		<?php }
		if ($gift_option && $gift_option[0] == 2) { 
			$giftWrapPrice = get_post_meta($post_id, 'cc_wc_gift_giftwrapping_price');
		?>
            <div class="gift-toggle">
                <input type="checkbox" id="gift_toggle" name="gift_toggle" value="gift_toggle" />
                <label for="gift_toggle"><?php _e('Add gift wrapping? (+ ' . get_woocommerce_currency_symbol() . $giftWrapPrice[0] . ')','cc_wc_gift_options');?></label>
            </div>
      	<?php } 
			if ($gift_option && $gift_option[0] != 0) { 
		?>
            <div id="gift-fields" class="">
            	<label for="recipient" class="screen-reader-text"><?php _e('Recipient\'s name:','cc_wc_gift_options');?></label>
                <input id="recipient" name="recipient" placeholder="<?php esc_html_e('Recipient\'s name','cc_wc_gift_options');?>" /><br/>
            	<label for="message" class="screen-reader-text"><?php _e('Your message:','cc_wc_gift_options');?></label>
                <textarea id="message" name="message" maxlength ="250" placeholder="<?php esc_html_e('Your message','cc_wc_gift_options');?>" rows="4"/></textarea><br/>
                <em id="gift-char-count"><span id="gift-char-count-value">250</span>/250 <?php _e('characters remaining','cc_wc_gift_options');?></em><br/>
            	<label for="from" class="screen-reader-text"><?php _e('From','cc_wc_gift_options');?>:</label>
                <input id="from" name="from" placeholder="<?php esc_html_e('From','cc_wc_gift_options');?>" />
            </div>
	<?php }
	}
