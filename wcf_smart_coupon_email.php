<?php
/*
Plugin Name: WCF Smart Coupon Email
Plugin URI: https://wecodefuture.com/wordpress-plugins/wcf-smart-coupon-email-system-plugin-for-woocommerce/
Description: WeCodeFuture smart coupon email plugin sends engaging coupon emails to your loyal customers for boosting sales, revenues, & engagement.
Version: 1.0
Author: WeCodeFuture
Author URI: http://wecodefuture.com
*/
register_activation_hook(__FILE__, 'wcf_smart_email_activate');
register_deactivation_hook(__FILE__, 'wcf_smart_email_deactivate');

function wcf_smart_email_activate()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_ud = $wpdb->prefix . 'wcf_userdata';
    $table_od = $wpdb->prefix . 'wcf_orderdata';
    $table_minam = $wpdb->prefix . 'wcf_minamnt';
    $table_multiod = $wpdb->prefix . 'wcf_multiod';
    $table_crtnday = $wpdb->prefix . 'wcf_crtnday';
    $table_wcf_cooa_logs = $wpdb->prefix . 'wcf_cooa_logs';

    $sql1 = "CREATE TABLE IF NOT EXISTS `$table_ud`(
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`user_id` INT(90) NOT NULL,
					`username` varchar(220) NOT NULL,
					`full_name` varchar(220) NOT NULL,
					`email` varchar(220) UNIQUE,
					`status`INT(1) DEFAULT '0',

					PRIMARY KEY(id)
					)
					ENGINE=MyISAM DEFAULT CHARSET=utf8";

    $wpdb->query($sql1);

    $sql2 = "CREATE TABLE IF NOT EXISTS `$table_od`(
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`domain` varchar(220) NOT NULL,
					`order_id` INT(90) NOT NULL UNIQUE,
					`order_date` varchar(220) NOT NULL,
					`product` varchar(220) NOT NULL,
					`total_cost` varchar(220) NOT NULL,
					`sh_name` varchar(220) NOT NULL,
					`sh_address` varchar(220) NOT NULL,
					`sh_city` varchar(220) NOT NULL,
					`sh_email` varchar(220) NOT NULL,
					`sh_state` varchar(220) NOT NULL,
					`sh_postal_code` varchar(220) NOT NULL,
					`status`INT(1) DEFAULT '0',
					`internal_status` INT(10) DEFAULT '0',
					PRIMARY KEY(id)
					)
					ENGINE=MyISAM DEFAULT CHARSET=utf8";

    $wpdb->query($sql2);

    $table_ud = $wpdb->prefix . 'wcf_userdata';
    $table_usr = $wpdb->prefix . 'users';
    $table_od = $wpdb->prefix . 'wcf_orderdata';
    $table_meta = $wpdb->prefix . 'postmeta';
    $table_mt = $wpdb->prefix . 'usermeta';
    $table_wcf_cooa_logs = $wpdb->prefix . 'wcf_cooa_logs';

    $udsql = "INSERT INTO $table_ud (user_id, username, full_name, email)
			SELECT ID, user_login, user_nicename, user_email
			FROM $table_usr";

    $wpdb->query($udsql);

    $sql_cooa_log = "CREATE TABLE IF NOT EXISTS `$table_wcf_cooa_logs`(
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`order_id` int(100) NOT NULL,
					`name` varchar(220) NOT NULL,
					`email` varchar(220) NOT NULL,
					`amt` int(11) NOT NULL,
					`after_day` int(11) NOT NULL,
					`expiry` int(11) NOT NULL,
					`status`INT(1) DEFAULT '0',
                    `coupon` varchar(220) NOT NULL,
                    `schedule_date` DATE NOT NULL,
                    
                    
					
					PRIMARY KEY(id)
					)
					ENGINE=MyISAM DEFAULT CHARSET=utf8";

    $wpdb->query($sql_cooa_log);

    //insert order data
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $table_ud = $wpdb->prefix . 'wcf_userdata';
    $table_usr = $wpdb->prefix . 'users';
    $table_od = $wpdb->prefix . 'wcf_orderdata';
    $table_meta = $wpdb->prefix . 'postmeta';
    $order_stats = $wpdb->prefix . 'wc_order_stats';
    $sqltest = "SELECT `order_id` FROM $order_stats";
    $orderid = $wpdb->get_results($sqltest); //get all post_id as order id.
    $array = json_decode(json_encode($orderid) , true);

    foreach ($array as $data)
    {
        $oid = $data['order_id'];
        $order = wc_get_order($oid);
        foreach ($order->get_items() as $item_key => $item)
        {
            //$product     = $item->get_product($oid);
            $order_data = $order->get_data();
            $item_data = $item->get_name();
            $product_name = $item['name'];
            $order_total = $order_data['total'];
            $order_date_created = $order_data['date_created']->date('Y-m-d H:i:s');
            $order_billing_first_name = $order_data['billing']['first_name'];
            $order_billing_last_name = $order_data['billing']['last_name'];
            $order_billing_address_1 = $order_data['billing']['address_1'];
            $order_billing_address_2 = $order_data['billing']['address_2'];
            $order_billing_state = $order_data['billing']['state'];
            $order_billing_city = $order_data['billing']['city'];
            $order_billing_email = $order_data['billing']['email'];
            $order_billing_postcode = $order_data['billing']['postcode'];
            $order_billing_full_name = $order_data['billing']['first_name'] . ' ' . $order_data['billing']['last_name'];
            $order_billing_address = $order_data['billing']['address_1'] . ' ' . $order_data['billing']['address_2'];
            $siteurl = home_url();
            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();
            $table_ud = $wpdb->prefix . 'wcf_userdata';
            $table_usr = $wpdb->prefix . 'users';
            $table_od = $wpdb->prefix . 'wcf_orderdata';
            $table_meta = $wpdb->prefix . 'postmeta';
            $order_stats = $wpdb->prefix . 'wc_order_stats';
            $woodata = array(
                'order_id' => $oid,
                'product' => $product_name,
                'order_date' => $order_date_created,
                'total_cost' => $order_total,
                'sh_name' => $order_billing_full_name,
                'sh_address' => $order_billing_address,
                'sh_state' => $order_billing_state,
                'sh_city' => $order_billing_city,
                'sh_email' => $order_billing_email,
                'sh_postal_code' => $order_billing_postcode,
            );
            $wpdb->insert($table_od, $woodata);
        }
    }
}

function wcf_smart_coupon_email_style() {
	wp_enqueue_style( 'wcf_bootstrap_min', plugin_dir_url( '_FILE_' ) . 'wcf-smart-coupon-email/asset/css/bootstrap.min.5.2.css', false, '5.3.1' );
	wp_enqueue_style( 'wcf_datatables_min', plugin_dir_url( '_FILE_' ) . 'wcf-smart-coupon-email/asset/css/jquery.dataTables.1.11.5.css', false, '1.11.5' );
	wp_enqueue_style( 'wcf_smart_coupon_cs', plugin_dir_url( '_FILE_' ) . 'wcf-smart-coupon-email/asset/css/wcf_smart_coupon.css', false, '1.0' );
}
add_action( 'admin_enqueue_scripts', 'wcf_smart_coupon_email_style' );
	function wcf_smart_coupon_email_js() {
	wp_add_inline_script( 'jquery-core', 'window.$ = jQuery;' );
		wp_enqueue_script( 'wcf_bootstrap_min_js', plugin_dir_url( '_FILE_' ) . 'wcf-smart-coupon-email/asset/js/bootstrap.min.5.2.js', true, '5.3.1' );
		
	}
add_action( 'admin_enqueue_scripts', 'wcf_smart_coupon_email_js' );
function wcfmy_scripts_method() {
	wp_add_inline_script( 'jquery-core', 'window.$ = jQuery;' );
	wp_register_script('wcf_datatables_js', plugin_dir_url( '_FILE_' ) . 'wcf-smart-coupon-email/asset/js/jquery.dataTables.1.11.5.js', array('jquery'), '1.11.5', false);
	wp_enqueue_script('wcf_datatables_js');
	wp_register_script('wcf_smart_coupon_js', plugin_dir_url( '_FILE_' ) . 'wcf-smart-coupon-email/asset/js/wcf_smart_coupon_main.js', array('jquery'), '1.0', true );
	wp_enqueue_script('wcf_smart_coupon_js');
}
	add_action('admin_enqueue_scripts', 'wcfmy_scripts_method');

function wcf_smart_email_deactivate()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_ud = $wpdb->prefix . 'wcf_userdata';
    $table_od = $wpdb->prefix . 'wcf_orderdata';
    $table_minam = $wpdb->prefix . 'wcf_minamnt';
    $table_crtnday = $wpdb->prefix . 'wcf_crtnday';
    $table_multiod = $wpdb->prefix . 'wcf_multiod';
    $table_wcf_cooa_logs = $wpdb->prefix . 'wcf_cooa_logs';
    $sql = "DROP TABLE IF EXISTS $table_ud, $table_od, $table_wcf_cooa_logs";

    $wpdb->query($sql);
}
// Plugin setting page
add_action('admin_menu', 'wcf_plugin_menu');

function wcf_plugin_menu()
{

    add_menu_page('WCF Smart Coupon', 'WCF Smart Coupon', 'administrator', dirname(__FILE__) , 'welcome_wcf_screen');

    add_submenu_page(dirname(__FILE__) , 'Logs Report', 'Logs Report', 'manage_options', '/wcf-smart-coupon-logs', 'wcfsm_log_report');

}
function welcome_wcf_screen()
{

    include ('welcome_wcf_sync.php');

}

function wcfsm_log_report()
{
    include ('min_amnt_log.php');
}

add_filter('cron_schedules', 'wcfsm_internal_sync');
function wcfsm_internal_sync($schedules)
{
    $schedules['every_five_minutes'] = array(
        'interval' => 300,
        'display' => __('Every 5 minutes') ,
    );
    return $schedules;
}

if (!wp_next_scheduled('wcf_internal_sync'))
{
    wp_schedule_event(time() , 'every_five_minutes', 'wcf_internal_sync');
}

add_action('wcf_internal_sync', 'schedule_wcf_internal_sync');
function schedule_wcf_internal_sync()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_wcf_cooa_logs = $wpdb->prefix . 'wcf_cooa_logs';
    $table_od = $wpdb->prefix . 'wcf_orderdata';
    $min_amount = get_option('wcf_cooa_min_amount');
    $apiodsql = "SELECT order_id, sh_name, sh_email, total_cost, internal_status FROM $table_od WHERE internal_status='0' AND total_cost >= $min_amount LIMIT 50";
    $odresult = $wpdb->get_results($apiodsql);
    $expiry = get_option('wcf_cooa_coupon_exp');
    $afterday = get_option('wcf_cooa_days');
    $shedule_date = (date('Y-m-d', strtotime("$afterday days")));
    $curr_date = date('Y-m-d');
    foreach ($odresult as $orderlist)
    {
        $oid = $orderlist->order_id;
        $order_total = $orderlist->total_cost;
        $order_billing_full_name = $orderlist->sh_name;
        $order_billing_email = $orderlist->sh_email;
        $status = $orderlist->internal_status;
        if ($status == 0)
        {

            $insert_sync = "INSERT INTO $table_wcf_cooa_logs ( `order_id`, `name`, `email`, `amt`, `after_day`, `expiry`, `schedule_date` ) VALUES ('$oid', '$order_billing_full_name', '$order_billing_email', '$order_total', '$afterday', '$expiry', '$shedule_date')";

            $run_sql = $wpdb->get_results($insert_sync);

            $update_internal_status = "UPDATE $table_od SET internal_status = '1' WHERE order_id = $oid";
            $wpdb->query($update_internal_status);

        }

    }
}

add_filter('cron_schedules', 'wcfsm_send_coupon_emails_cron');
function wcfsm_send_coupon_emails_cron($schedules)
{
    $schedules['thirty_minutes'] = array(
        'interval' => 1800,
        'display' => __('Every thirty minutes') ,
    );
    return $schedules;
}

if (!wp_next_scheduled('send_coupon_emails_cron'))
{
    wp_schedule_event(time() , 'thirty_minutes', 'send_coupon_emails_cron');
}

add_action('send_coupon_emails_cron', 'schedule_wcf_emails_function');
function schedule_wcf_emails_function()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_wcf_cooa_logs = $wpdb->prefix . 'wcf_cooa_logs';
    $curr_date = date('Y-m-d');
    $custemail = "SELECT `email` FROM $table_wcf_cooa_logs WHERE `status` ='0' AND `schedule_date`= '$curr_date' LIMIT 7";
    $email_cstmr = $wpdb->get_results($custemail);
    foreach ($email_cstmr as $c_email)
    {
        $to = $c_email->email;
        $subject = "you won the coupon...";
        if (get_option('wcf_cooa_email_temp') == 'temp2')
        {
            ob_start();
            include ('template/coupon_template2.php'); //Template File Path
            
        }
        else if (get_option('wcf_cooa_email_temp') == 'temp3')
        {
            ob_start();
            include ('template/coupon_template3.php'); //Template File Path
            
        }
        else
        {
            ob_start();
            include ('template/coupon_template1.php'); //Template File Path
            
        }
        $message = ob_get_contents();
        ob_end_clean();
        $from = get_option('admin_email');
        $headers = array(
            'From: Congratulations <' . $from . '>',
            'Content-Type: text/html; charset=UTF-8'
        );
        $headers = implode("\r\n", $headers);
        //Here put your Validation and send mail
        $sent = wp_mail($to, $subject, $message, $headers);
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $cooa_table = $wpdb->prefix . 'wcf_cooa_logs';
        $cooa_cpn_sql = "UPDATE $cooa_table SET coupon = '$res'	WHERE email = '$to'";
        $wpdb->query($cooa_cpn_sql);
        if ($sent)
        {
            $cooa_cpn_sql = "UPDATE $cooa_table
        		SET status = '1' WHERE email = '$to'";
            $wpdb->query($cooa_cpn_sql);
        }
        
        
    }
}

?>