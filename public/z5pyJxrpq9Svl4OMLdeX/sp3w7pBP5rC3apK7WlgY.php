<?php
       //Change these with your information
    $paypalmode = ''; //'sandbox' for testing or empty ''
    $dbusername     = 'garry'; //db username
    $dbpassword     = 'TheKeeper'; //db password
    $dbhost     = 'localhost'; //db host
    $dbname     = 'ARAccounting'; //db name

if($_POST)
{
        if($paypalmode=='sandbox')
        {
            $paypalmode     =   '.sandbox';
        }
        $req = 'cmd=' . urlencode('_notify-validate');
        foreach ($_POST as $key => $value) {
            $value = urlencode(stripslashes($value));
            $req .= "&$key=$value";
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: www'.$paypalmode.'.sandbox.paypal.com'));
        $res = curl_exec($ch);
        curl_close($ch);

        if (strcmp ($res, "VERIFIED") == 0)
        {
# Initialize Variables
$invoice = '';
$custom = '';
$test_ipn = '';
$memo = '';
$business = '';
$receiver_id = '';
$receiver_email = '';
$first_name = '';
$last_name = '';
$contact_phone = '';
$address_city = '';
$address_country = '';
$address_country_code = '';
$address_name = '';
$address_state = '';
$address_status = '';
$address_street = '';
$address_zip = '';
$payer_business_name = '';
$payer_email = '';
$payer_id = '';
$payer_status = '';
$residence_country = '';
$txn_id = '';
$txn_type = '';
$transaction_entity = '';
$tax = '';
$auth_id = '';
$auth_exp = '';
$auth_status = '';
$auth_amount = '';
$num_cart_items = '';
$mc_currency = '';
$exchange_rate = '';
$mc_fee = '';
$mc_gross = '';
$parent_txn_id = '';
$payment_date = '';
$payment_status = '';
$payment_type = '';
$pending_reason = '';
$reason_code = '';
$remaining_settle = '';
$mc_handling = '';
$mc_shipping = '';
$settle_currency = '';
$case_id = '';
$case_type = '';
$case_creation_date = '';
$handling = '';
$shipping = '';
$settle_amount = '';
$auction_buyer_id = '';
$auction_closing_date = '';
$auction_multi_item = '';
$for_auction = '';
$subscr_date = '';
$subscr_effective = '';
$period1 = '';
$period2 = '';
$period3 = '';
$amount1 = '';
$amount2 = '';
$amount3 = '';
$mc_amount1 = '';
$mc_amount2 = '';
$mc_amount3 = '';
$recurring = '';
$reattempt = '';
$retry_at = '';
$recur_times = '';
$username = '';
$password = '';
$subscr_id = '';
$receipt_id = '';
$item_name = '';
$item_number = '';
$option_selection1 = '';
$option_selection2 = '';
$option_selection3 = '';
$option_selection4 = '';

$invoice  = $_POST['invoice'];
$custom  = $_POST['custom'];
$test_ipn  = $_POST['test_ipn'];
$memo  = $_POST['memo'];
$business  = $_POST['business'];
$receiver_id  = $_POST['receiver_id'];
$receiver_email  = $_POST['receiver_email'];
$first_name  = $_POST['first_name'];
$last_name  = $_POST['last_name'];
$contact_phone  = $_POST['contact_phone'];
$address_city  = $_POST['address_city'];
$address_country  = $_POST['address_country'];
$address_country_code  = $_POST['address_country_code'];
$address_name  = $_POST['address_name'];
$address_state  = $_POST['address_state'];
$address_status  = $_POST['address_status'];
$address_street  = $_POST['address_street'];
$address_zip  = $_POST['address_zip'];
$payer_business_name  = $_POST['payer_business_name'];
$payer_email  = $_POST['payer_email'];
$payer_id  = $_POST['payer_id'];
$payer_status  = $_POST['payer_status'];
$residence_country  = $_POST['residence_country'];
$txn_id  = $_POST['txn_id'];
$txn_type  = $_POST['txn_type'];
$transaction_entity  = $_POST['transaction_entity'];
$tax  = $_POST['tax'];
$auth_id  = $_POST['auth_id'];
$auth_exp  = $_POST['auth_exp'];
$auth_status  = $_POST['auth_status'];
$auth_amount  = $_POST['auth_amount'];
$num_cart_items  = $_POST['num_cart_items'];
$mc_currency  = $_POST['mc_currency'];
$exchange_rate  = $_POST['exchange_rate'];
$mc_fee  = $_POST['mc_fee'];
$mc_gross  = $_POST['mc_gross'];
$parent_txn_id  = $_POST['parent_txn_id'];
$payment_date  = $_POST['payment_date'];
$payment_status  = $_POST['payment_status'];
$payment_type  = $_POST['payment_type'];
$pending_reason  = $_POST['pending_reason'];
$reason_code  = $_POST['reason_code'];
$remaining_settle  = $_POST['remaining_settle'];
$mc_handling  = $_POST['mc_handling'];
$mc_shipping  = $_POST['mc_shipping'];
$settle_currency  = $_POST['settle_currency'];
$case_id  = $_POST['case_id'];
$case_type  = $_POST['case_type'];
$case_creation_date  = $_POST['case_creation_date'];
$handling  = $_POST['handling'];
$shipping  = $_POST['shipping'];
$settle_amount  = $_POST['settle_amount'];
$auction_buyer_id  = $_POST['auction_buyer_id'];
$auction_closing_date  = $_POST['auction_closing_date'];
$auction_multi_item  = $_POST['auction_multi_item'];
$for_auction  = $_POST['for_auction'];
$subscr_date  = $_POST['subscr_date'];
$subscr_effective  = $_POST['subscr_effective'];
$period1  = $_POST['period1'];
$period2  = $_POST['period2'];
$period3  = $_POST['period3'];
$amount1  = $_POST['amount1'];
$amount2  = $_POST['amount2'];
$amount3  = $_POST['amount3'];
$mc_amount1  = $_POST['mc_amount1'];
$mc_amount2  = $_POST['mc_amount2'];
$mc_amount3  = $_POST['mc_amount3'];
$recurring  = $_POST['recurring'];
$reattempt  = $_POST['reattempt'];
$retry_at  = $_POST['retry_at'];
$recur_times  = $_POST['recur_times'];
$username  = $_POST['username'];
$password  = $_POST['password'];
$subscr_id  = $_POST['subscr_id'];
$receipt_id  = $_POST['receipt_id'];
$item_name  = $_POST['item_name'];
$item_number  = $_POST['item_number'];
$option_selection1 = $_POST['option_selection1'];
$option_selection2 = $_POST['option_selection2'];
$option_selection3 = $_POST['option_selection3'];
$option_selection4 = $_POST['option_selection4'];

$other_data = '';
$other_data = json_encode($_POST);
	
			
            $mdate = '';
			$mdate= date('Y-m-d h:i:s',strtotime($payment_date));
            $other_data = '';
			$other_data = json_encode($_POST);
			
			

            $conn = mysql_connect($dbhost,$dbusername,$dbpassword);
            if (!$conn)
            {
             die('Could not connect: ' . mysql_error());
            }

            mysql_select_db($dbname, $conn);
			
			trigger_error('RUNNING');

            // insert in our IPN record table
            $query = "INSERT INTO PayPalIPN (invoice,custom,test_ipn,memo,business,receiver_id,receiver_email,first_name,last_name,contact_phone,address_city,address_country,address_country_code,address_name,address_state,address_status,address_street,address_zip,payer_business_name,payer_email,payer_id,payer_status,residence_country,txn_id,txn_type,transaction_entity,tax,auth_id,auth_exp,auth_status,auth_amount,num_cart_items,mc_currency,exchange_rate,mc_fee,mc_gross,parent_txn_id,payment_date,payment_status,payment_type,pending_reason,reason_code,remaining_settle,mc_handling,mc_shipping,settle_currency,case_id,case_type,case_creation_date,handling,shipping,settle_amount,auction_buyer_id,auction_closing_date,auction_multi_item,for_auction,subscr_date,subscr_effective,period1,period2,period3,amount1,amount2,amount3,mc_amount1,mc_amount2,mc_amount3,recurring,reattempt,retry_at,recur_times,username,password,subscr_id,receipt_id,item_name,item_number,option_selection1,option_selection2,option_selection3,option_selection4,other_data)
			VALUES
('$invoice','$custom','$test_ipn','$memo','$business','$receiver_id','$receiver_email','$first_name','$last_name','$contact_phone','$address_city','$address_country','$address_country_code','$address_name','$address_state','$address_status','$address_street','$address_zip','$payer_business_name','$payer_email','$payer_id','$payer_status','$residence_country','$txn_id','$txn_type','$transaction_entity','$tax','$auth_id','$auth_exp','$auth_status','$auth_amount','$num_cart_items','$mc_currency','$exchange_rate','$mc_fee','$mc_gross','$parent_txn_id','$payment_date','$payment_status','$payment_type','$pending_reason','$reason_code','$remaining_settle','$mc_handling','$mc_shipping','$settle_currency','$case_id','$case_type','$case_creation_date','$handling','$shipping','$settle_amount','$auction_buyer_id','$auction_closing_date','$auction_multi_item','$for_auction','$subscr_date','$subscr_effective','$period1','$period2','$period3','$amount1','$amount2','$amount3','$mc_amount1','$mc_amount2','$mc_amount3','$recurring','$reattempt','$retry_at','$recur_times','$username','$password','$subscr_id','$receipt_id','$item_name','$item_number','$option_selection1','$option_selection2','$option_selection3','$option_selection4','$other_data')";

			
            if(!mysql_query($query))
            {
              trigger_error(mysql_error(), E_USER_ERROR);
            }
#If this is a new subscription
if ($txn_type == "subscr_signup"){
			
### Lets upgrade the member
# Select the Community Database 
$dbname     = 'ARCommunity'; //db name
mysql_select_db($dbname, $conn);

$target_level = '';
$target_level = $item_number;
$customer = $option_selection1;

# What is the customers current level
$customer_currentlevel = '';
$query_current_customer = "SELECT * FROM customer WHERE customer_id = '$customer'";
# trigger_error('Query Current Customer = ' . $query_current_customer );	

$current_customer_result = mysql_query($query_current_customer);

while($current_customer = mysql_fetch_array($current_customer_result))
{	
$current_customer_level = $current_customer['customer_level'];
}

# Make sure this is a Valid Upgrade else Log an Exception/Error
$upgrade_ok = '';
if ($current_customer_level == "Local Resident")
{ $upgrade_ok = "YES"; }
else if (($current_customer_level == "Community Leader") and (($target_level == "Local Business") or ($target_level == "National Business")))  
{ $upgrade_ok = "YES"; }
else if (($current_customer_level == "Local Business") and ($target_level = 'National Business'))
{ $upgrade_ok = "YES"; }

## If OK do the account upgrade
if ($upgrade_ok =="YES") {
# We also update the customers Account Quotas
# Get the current account Quota's from customer_priviledges table
$target_photo_limit = "";
$target_article_limit = "";
$target_ad_limit = "";
$target_quotas_sql = "SELECT * FROM customer_privileges WHERE level = '$target_level'";
$target_quotas_sql_result = mysql_query($target_quotas_sql);
while($target_quotas = mysql_fetch_array($target_quotas_sql_result))
{	
$target_photo_limit = $target_quotas['photo_limit'];
$target_ad_limit = $target_quotas['ad_limit'];
$target_article_limit = $target_quotas['article_limit'];

}
	
	$upgrade_memberlevel_sql = "UPDATE customer SET customer_level = '$target_level' WHERE customer_id = '$customer'";
            if(!mysql_query($upgrade_memberlevel_sql))
            {
              trigger_error(mysql_error(), E_USER_ERROR);
            }
			
	$upgrade_photo_limit_sql = "UPDATE customer SET photo_limit = '$target_photo_limit' WHERE customer_id = '$customer'";	  
            if(!mysql_query($upgrade_photo_limit_sql))
            {
              trigger_error(mysql_error(), E_USER_ERROR);
            }
			
	$upgrade_ad_limit_sql = "UPDATE customer SET ad_limit = '$target_ad_limit' WHERE customer_id = '$customer'";	  
            if(!mysql_query($upgrade_ad_limit_sql))
            {
              trigger_error(mysql_error(), E_USER_ERROR);
            }
			
	$upgrade_article_limit_sql = "UPDATE customer SET article_limit = '$target_article_limit' WHERE customer_id = '$customer'";	  
            if(!mysql_query($upgrade_article_limit_sql))
            {
              trigger_error(mysql_error(), E_USER_ERROR);
            }	
								
# Clear any Membership Key
	$membershipkey_sql = "UPDATE customer SET membership_key = '' WHERE customer_id = '$customer'";
            if(!mysql_query($membershipkey_sql))
            {
              trigger_error(mysql_error(), E_USER_ERROR);
            }
# End Do the Upgrade
}

            mysql_close($conn);

        }

# Email Notification
exit();
		
# End subscr_signup		
}

##################################################################
if ($txn_type == "subscr_payment"){
# Handle Payment

# Email Notification
exit();
# End subscr_payment	
}

##################################################################
if ($txn_type == "subscr_cancel"){
# Handle Cancel

# Email Notification
exit();
# End subscr_cancel	
}
		
##################################################################
if ($txn_type == "subscr_eot"){
# Handle eot

# Email Notification
exit();
# End subscr_eot
}
		
if ($txn_type == "cart"){
# Handle Cart

# Email Notification
exit();
# End cart
}	
	
	
	
# End Post
}
?>