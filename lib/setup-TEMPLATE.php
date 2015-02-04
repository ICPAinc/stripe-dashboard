<?php
// --- BEGIN CONFIGURATION ---
// Rename locally configured file to setup.php

// Database
$database_host = '[DATABASE_HOST]';
$database_username = '[DATABASE_USERNAME]';
$database_password = '[DATABASE_PASSWORD]';
$database_name = '[DATABASE_NAME]';

// Dashboard
$dashboard_login = array (
	// use key/value pairs like: "username" => "password"
	"[USERNAME1]" => "[PASSWORD1]",
	"[USERNAME2]" => "[PASSWORD2]" //etc
);
$email_settings = array(
	// for notification emails sent by lib/Form.php using mail()
	"to"      => "[NOTIFICATION EMAIL ADDRESS OR COMMA SEPARATED ADDRESSES]", //default, can be overridden on individual forms using $config['email_to'] = 'some other email address';
	"subject" => "Stripe Form Data", //or other subject prefix
	"message" => "View data at [URL FOR DASHBOARD.PHP]\n\nForm submitted by:\n", //or other message text
	"headers" => "From: [EMAIL ADDRESS]\r\nReply-To: [EMAIL ADDRESS]\r\nX-Mailer: PHP/".phpversion() //or other email header settings
);

// Stripe
$stripe_acct = "[NAME OF DEFAULT STRIPE ACCOUNT]"; //default - nickname from $stripe_keys array
$stripe_mode = "test"; //toggle to 'live' when ready to launch
$stripe_keys = array(
  "[STRIPE ACCOUNT NAME 1]" => array( //a unique nickname chosen by you
    "test" => array(
      "secret_key"      => "[SECRET TEST KEY FOR ACCOUNT 1, PROVIDED BY STRIPE]", //DON'T GET THESE MIXED UP!
      "publishable_key" => "[PUBLIC TEST KEY FOR ACCOUNT 1, PROVIDED BY STRIPE]"
    ),
    "live" => array(
      "secret_key"      => "[SECRET LIVE KEY FOR ACCOUNT 1, PROVIDED BY STRIPE]",
      "publishable_key" => "[PUBLIC LIVE KEY FOR ACCOUNT 1, PROVIDED BY STRIPE]"
    )
  ),
  "[STRIPE ACCOUNT NAME 2]" => array( //if multiple accounts - a unique nickname chosen by you
    "test" => array(
      "secret_key"      => "[SECRET TEST KEY FOR ACCOUNT 2, PROVIDED BY STRIPE]",
      "publishable_key" => "[PUBLIC TEST KEY FOR ACCOUNT 2, PROVIDED BY STRIPE]"
    ),
    "live" => array(
      "secret_key"      => "[SECRET LIVE KEY FOR ACCOUNT 2, PROVIDED BY STRIPE]",
      "publishable_key" => "[PUBLIC LIVE KEY FOR ACCOUNT 2, PROVIDED BY STRIPE]"
    )
  ),
  "[STRIPE ACCOUNT NAME 3]" => array( //if multiple accounts - a unique nickname chosen by you
    "test" => array(
      "secret_key"      => "[SECRET TEST KEY FOR ACCOUNT 3, PROVIDED BY STRIPE]",
      "publishable_key" => "[PUBLIC TEST KEY FOR ACCOUNT 3, PROVIDED BY STRIPE]"
    ),
    "live" => array(
      "secret_key"      => "[SECRET LIVE KEY FOR ACCOUNT 3, PROVIDED BY STRIPE]",
      "publishable_key" => "[PUBLIC LIVE KEY FOR ACCOUNT 3, PROVIDED BY STRIPE]"
    )
  ) // etc
);
$stripe_orgs = array(
  "[STRIPE ACCOUNT NAME 1]" => array( //nickname from $stripe_keys array
    "business_name" => "[BUSINESS NAME FOR STRIPE ACCOUNT 1]", //short displayable name for Stripe form
	"business_logo" => "/assets/images/[BUSINESS LOGO FOR STRIPE ACCOUNT 1]" //for Stripe form
  ),
  "[STRIPE ACCOUNT NAME 2]" => array( //nickname from $stripe_keys array
    "business_name" => "[BUSINESS NAME FOR STRIPE ACCOUNT 2]",
	"business_logo" => "/assets/images/[BUSINESS LOGO FOR STRIPE ACCOUNT 2]"
  ),
  "[STRIPE ACCOUNT NAME 3]" => array( //nickname from $stripe_keys array
    "business_name" => "[BUSINESS NAME FOR STRIPE ACCOUNT 3]",
	"business_logo" => "/assets/images/[BUSINESS LOGO FOR STRIPE ACCOUNT 3]"
  ) // etc
);

// System
$local_timezone = 'America/New_York'; //or other valid PHP Timezone Indentifier: http://php.net/manual/en/timezones.php

// --- END CONFIGURATION ---

// Leave the rest alone

error_reporting(E_ALL ^ E_DEPRECATED);

if (!debug_backtrace()) {
    // shouldn't be accessed directly
    die();
}

require_once('./lib/Stripe.php');

$db = mysql_connect($database_host, $database_username, $database_password);
mysql_select_db($database_name, $db);

Stripe::setApiKey($stripe_keys[$stripe_acct][$stripe_mode]['secret_key']); //set default

date_default_timezone_set($local_timezone);

class Setup {
    public static function stripeKey($new_stripe_acct) {
		global $stripe_keys, $stripe_mode;
		Stripe::setApiKey($stripe_keys[$new_stripe_acct][$stripe_mode]['secret_key']); //set new key
	}
	public static function getKey($new_stripe_acct) {
		global $stripe_keys, $stripe_mode;
		return $stripe_keys[$new_stripe_acct][$stripe_mode]['publishable_key']; //get new key (for lib/Form/shared/js.php)
	}
	public static function getName($new_stripe_acct) {
		global $stripe_orgs;
		return $stripe_orgs[$new_stripe_acct]['business_name']; //get business name (for lib/Form/shared/js.php)
	}
	public static function getLogo($new_stripe_acct) {
		global $stripe_orgs;
		return $stripe_orgs[$new_stripe_acct]['business_logo']; //get business logo (for lib/Form/shared/js.php)
	}
}
?>