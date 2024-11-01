<?php
echo"<h3>Log Report On Order Amount</h3>";
add_filter( 'woocommerce_coupon_details', 'wcfsm_expire_coupon');
function wcfsm_expire_coupon($code){
	global $woocommerce;
	$coupon = new WC_Coupon($code);
    $expiry_date = $coupon->get_date_expires();
    return $expiry_date->format('Y-m-d');
    }
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_wcf_cooa_logs =$wpdb->prefix . 'wcf_cooa_logs';
	$min_amnt= "SELECT  * FROM $table_wcf_cooa_logs";
	$cooa = $wpdb->get_results($min_amnt);
?>
<!DOCTYPE html>
<html lang="en">
<body>
<div class="container" style="max-width:100%;">
 <br>
 <table id="wcf_smart_cooa_logs" class="display" style="width:100%">
    <thead>
        <tr>
            <th>Sr.No.</th>
            <th>Order ID</th>
			<th>Name</th>
			<th>Email</th>
			<th>Order Amount</th>
			<th>Coupon Code</th>
			<th>Expiry</th>
			<th>Schedule</th>
            <th>Status</th>
        </tr>
    </thead>
	<tbody>
	<?php
    $i=1;
    
    foreach($cooa as $usr_list){  
    $name= $usr_list->name;
    $email =$usr_list->email;
    $status=$usr_list->status;
    $mcoupon=$usr_list->coupon;
    $expiry=$usr_list->expiry;
    ?>
    
      <tr>
        <td><?php echo esc_html($i); ?></td>
        <td><?php echo esc_html($usr_list->order_id); ?></td>
        <td><?php echo esc_html($usr_list->name); ?></td>
		<td><?php echo esc_html($usr_list->email); ?></td>
        <td><?php echo esc_html($usr_list->amt); ?></td>
       <?php  $cooa_check ="SELECT * FROM $table_wcf_cooa_logs WHERE email='$email'";
    $cooa_status = $wpdb->get_results($cooa_check);
   	if($status=='1') {?>
      <td><?php echo esc_html($usr_list->coupon); ?></td>
      <td><?php echo esc_html(wcfsm_expire_coupon($usr_list->coupon)); ?></td>
    <td> <?php echo esc_html($usr_list->schedule_date); ?></td>
      <?php } else{?>
      <td><?php echo "Not Generated"; ?></td>
      <td><?php echo "NA" ?></td>
      <td><?php echo esc_html($usr_list->schedule_date); ?></td>
      <?php }
		if($status=='1') {?>
      <td><?php echo "SENT"; ?></td>
      <?php } else{?>
      <td><?php echo "Processing"; ?></td>
      <?php } ?>
      </tr>
    
   <?php $i++; } ?>
   </tbody>
</table>
</div>
</body>
</html>