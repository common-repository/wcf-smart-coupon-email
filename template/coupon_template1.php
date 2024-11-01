<?php 

$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$res = "";
for ($i = 0; $i < 4; $i++) {
    $res .= $chars[mt_rand(0, strlen($chars)-1)];
}
$coupon_code = $res;

update_option('wcf_new_coupon', $coupon_code);

	/**
* Create a coupon programatically
*/
//$coupon_code = 'UNIQUECODE'; // Code
$amount = get_option('wcf_cooa_coupon_value'); // Amount
$discount_type = get_option('wcf_cooa_coupon_type'); // Type: fixed_cart, percent, fixed_product, percent_product

$expry = get_option('wcf_cooa_coupon_exp');

$coupon = array(
'post_title' => $coupon_code,
'post_content' => '',
'post_status' => 'publish',
'post_author' => 1,
'post_type' => 'shop_coupon');

$new_coupon_id = wp_insert_post( $coupon );

// Add meta
update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
update_post_meta( $new_coupon_id, 'individual_use', 'yes' );
update_post_meta( $new_coupon_id, 'product_ids', '' );
update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
update_post_meta( $new_coupon_id, 'usage_limit', '1' );
update_post_meta( $new_coupon_id, 'expiry_date', strtotime("+$expry days") );
update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
update_post_meta( $new_coupon_id, 'free_shipping', 'no' );

?>
<div class="couponcode"  style="text-align:center;">
<h1>Congratulations...!</h1>
<h2>YOU WIN</h2>

<img src="<?php echo plugin_dir_url( __FILE__ ) . '/images/coupon_code.png'; ?>">
<div class="cpncde" style="text-align:center; font-weight: 800; color:black;">Coupon Code : <?php echo esc_html($res); ?></div>
<p style="text-align:center;">You got the exclusive discount for your next purchase!</p>
<p style="text-align:center;">Only the luckiest candidates get this offer. We run a campaign that matches your order history!.</p>
<p style="text-align:center;"> “The Best Price-Fall Is Live!”</p>
<hr />
<p style="text-align:center;">Powered by <a href="<?php echo get_home_url(); ?>"> <?php wp_title(''); ?></a></p>
</div>