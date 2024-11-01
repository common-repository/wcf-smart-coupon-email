<?php
if(isset($_POST['submitoam'])) {
	
	$is_enable_oa = sanitize_key($_POST['odamntactive']);
    $min = sanitize_text_field($_POST['minamnt']);
	$after_days = sanitize_text_field($_POST['afterday']);
    $exp_day = sanitize_text_field($_POST['expryday']);
    $coupon_type = sanitize_text_field($_POST['coupon_type']);
	$coupon_value = sanitize_text_field($_POST['coupon_value']);
	$email_temp = sanitize_text_field($_POST['email_temp']);
	
    if(!empty($is_enable_oa)) {
        $enable = 1;
        update_option('wcf_cooa_enable', '1'); 
    } else { 
        $enable = 0;
        update_option('wcf_cooa_enable', ''); 
    }
	update_option('wcf_cooa_min_amount', $min);
    update_option('wcf_cooa_days', $after_days);
    update_option('wcf_cooa_coupon_exp', $exp_day);
    update_option('wcf_cooa_coupon_type', $coupon_type);
	update_option('wcf_cooa_coupon_value', $coupon_value);
	update_option('wcf_cooa_email_temp', $email_temp);
}
?>
<div class="container-mt-3" style="margin-top:70px; margin-left:30px;">
  <form action="" id="order_amount_form" method="post">
	<div class="mb-3">
     <label for="odamntactive" style="font-size:20px;">Enable:</label>
     <?php if(get_option('wcf_cooa_enable') != '') {?>
      <input type="checkbox" class="checkbox" id="enblbutton" name="odamntactive" checked>
      <?php } else {?>
      <input type="checkbox" class="checkbox" id="enblbutton" name="odamntactive">
      <?php } ?>
      <p style="margin-left:200px; margin-top:-26px;">Enable to send coupons to those customers who have spend a specific amount on order.</p>
    </div>
    <div class="form-group" style="margin-top:50px;">
      <label for="coupon_type">Coupon Type:</label>
      <select class="form-control" id="sel" name="coupon_type">
        <option name="coupon_type" value="percent"<?php echo get_option('wcf_cooa_coupon_type'); ?>>Percentage</option>
        <option name="coupon_type" value="fixed_cart"<?php echo get_option('wcf_cooa_coupon_type');?>>Fixed</option>
      </select>
	</div>  
	<div class="mb-3"  style="margin-top:25px;">
      <label for="copon_value">Enter The Coupon Value:</label>
      <input type="text" class="form-control" id="cpn_value" placeholder="Enter the Coupon Value. Ex: 50" name="coupon_value" value="<?php echo esc_html(get_option('wcf_cooa_coupon_value')); ?>" required>
    </div>
    <div class="mb-3"  style="margin-top:50px;">
      <label for="minamnt">Minimum Order Amount:</label>
      <input type="text" class="form-control" id="minamount" placeholder="Enter minimum oredr amount. Ex: 1000" name="minamnt" value="<?php echo esc_html(get_option('wcf_cooa_min_amount')); ?>" required>
    </div>
    <div class="mb-3" style="margin-top:25px;">
      <label for="afterday">Send Coupon After (days):</label>
      <input type="text" class="form-control" id="aftdays" placeholder="Enter Days. Ex: 3" name="afterday" value="<?php echo esc_html(get_option('wcf_cooa_days')); ?>" required>
	  <p>When you want to send coupons.</p>
    </div>
	<div class="mb-3" style="margin-top:25px;">
      <label for="expday">Coupon Expiry (days):</label>
      <input type="text" class="form-control" id="expierydays" placeholder="Enter Expiry Days." name="expryday" value="<?php echo esc_html(get_option('wcf_cooa_coupon_exp')); ?>" required>
	  <p>The Coupon will expire after the certain days if not used. Set to -1 for unlimited coupon validity.</p>
    </div>
    <div class="form-group" style="margin-top:50px;">
      <label for="email_temp">Select Email Template :</label>
      <select class="form-control" id="temp" name="email_temp">
        <option name="email_temp" value="temp1"<?php echo get_option('wcf_cooa_email_temp'); ?>>Default</option>
        <option name="email_temp" value="temp2"<?php echo get_option('wcf_cooa_email_temp');?>>Template2</option>
		<option name="email_temp" value="temp3"<?php echo get_option('wcf_cooa_email_temp');?>>Template3</option>
      </select>
	</div> 
    <button type="submit" class="btn btn-primary"  name="submitoam" style="margin-top:25px;">Save</button>
  </form>
</div>
<script type="text/javascript">
  document.getElementById('sel').value = "<?php echo get_option('wcf_cooa_coupon_type'); ?>";
document.getElementById('temp').value = "<?php echo get_option('wcf_cooa_email_temp'); ?>";
</script>