<?php
if (!debug_backtrace()) {
    // shouldn't be accessed directly
    die();
}
require_once('./lib/setup.php');

$config = array();
$contents = "";

class Form {
    public static function header() {
        global $config;
        ob_start();
		Setup::stripeKey($config['stripe account']);
        include_once(dirname(__FILE__).'/Form/Templates/'.$config['template'].'/header.php');
    }
    
    public static function footer() {
        global $config, $contents;
        include_once(dirname(__FILE__).'/Form/Templates/'.$config['template'].'/footer.php');
        $contents = ob_get_contents();
        ob_end_clean();
        header('Content-Type: text/html; charset=utf-8');
        if(isset($_GET['xhr']) && trim($_GET['xhr']) == 'true') {
            if($config['action'] == 'update') {
                Form::handle_update();
            } else {
                Form::handle_create();
            }
        } else {
            echo $contents;
        }
    }
    
    public static function section($name,$param1="",$param2="") {
        global $config;
        include(dirname(__FILE__).'/Form/Sections/'.$name.'.php');
    }
    
    public static function handle_create() {
        global $config, $db, $email_settings;
        $fn = $_REQUEST['FirstName'];
        $ln = $_REQUEST['LastName'];
        $em = $_REQUEST['stripeEmail'];
        $tk = $_REQUEST['stripeToken'];
        $ac = $config['stripe account']; // added $ac=$config['stripe account']
		$email_to = $email_settings['to'];
		if(isset($config['email_to'])) {
			$email_to = $config['email_to'];
		}
        if(!$tk || strlen($tk) < 1) {
            echo 'fail';
            return;
        }
        $customer = false;
        $cr = array();
        $res = mysql_query("SELECT * FROM customers WHERE first_name='".mysql_real_escape_string($fn)."' AND last_name='".mysql_real_escape_string($ln)."' AND email='".mysql_real_escape_string($em)."' AND stripe_account='".mysql_real_escape_string($ac)."' LIMIT 1", $db); // added stripe_account=$ac
        if($res && mysql_num_rows($res) > 0) {
            while($row = mysql_fetch_assoc($res)) {
                if(isset($row['stripe_customer_id']) && strlen($row['stripe_customer_id']) > 0 && !$customer) {
                    $cu = Stripe_Customer::retrieve($row['stripe_customer_id']);
                    if($cu && (!isset($cu->deleted) || !$cu->deleted)) {
                        $customer = true;
                        $cr = $row;
                    }
                }
            }
        }
        if(!$customer) {
            $cu = Stripe_Customer::create(array("description" => $fn." ".$ln, "email" => $em));
        }
        if(!$cu) {
            echo 'fail';
            return;
        }
        $card = $cu->cards->create(array('card' => $tk));
        if($card) {
            if(!isset($card->name) || strpos($card->name,'@') !== false) {
    			$card->name = $fn." ".$ln;
    			$card->save();
    		} //added this if statement
            if(isset($card->id)) {
                if(isset($cu->default_card) && $card->id !== $cu->default_card) {
                    $cu->default_card = $card->id;
                    $cu->save();
                } //make last submitted card default
                if(!$customer) {
                    mysql_query("INSERT INTO customers SET first_name='".mysql_real_escape_string($fn)."', last_name='".mysql_real_escape_string($ln)."', email='".mysql_real_escape_string($em)."', stripe_customer_id='".mysql_real_escape_string($cu->id)."', stripe_account='".$config['stripe account']."'", $db); // added stripe_account=$config['stripe account']
                    $cu_id = mysql_insert_id($db);
                } else {
                    $cu_id = $cr['id'];
                }
                $now = time();
                mysql_query("INSERT INTO cards (customer_id, stripe_card_id, last4, brand, exp_month, exp_year, modified) VALUES('".mysql_real_escape_string($cu_id)."', '".mysql_real_escape_string($card->id)."', '".mysql_real_escape_string($card->last4)."', '".mysql_real_escape_string($card->brand)."', '".mysql_real_escape_string($card->exp_month)."', '".mysql_real_escape_string($card->exp_year)."', '".$now."') ON DUPLICATE KEY UPDATE modified='".$now."', id=LAST_INSERT_ID(id)", $db);
    			// added exp_month & exp_year
                $card_id = mysql_insert_id($db);
                mysql_query("INSERT INTO entries (customer_id, card_id, tag, created, modified) VALUES('".mysql_real_escape_string($cu_id)."','".mysql_real_escape_string($card_id)."', '".mysql_real_escape_string($config['tag'])."', '".$now."', '".$now."') ON DUPLICATE KEY UPDATE card_id='".mysql_real_escape_string($card_id)."', modified='".$now."', id=LAST_INSERT_ID(id)", $db);
                $entry_id = mysql_insert_id($db);
                $meta = $_POST;
                unset($meta['FirstName'], $meta['LastName'], $meta['submit'], $meta['stripeToken'], $meta['stripeEmail']);
                $notes = parse_url($_SERVER['REQUEST_URI']);
                mysql_query("INSERT INTO entries_meta SET entry_id='".mysql_real_escape_string($entry_id)."', data='".mysql_real_escape_string(serialize($meta))."', source='".mysql_real_escape_string($notes['path'])."', title='".mysql_real_escape_string($config['title'])."', created='".$now."'", $db);
                echo 'success';
    			mail($email_to,$email_settings['subject']." - ".$config['title'],$email_settings['message'].$fn." ".$ln."\n".$em,$email_settings['headers']);
    			// added mail function; references $email_settings in lib/setup.php
                return;
            }
        }
        echo 'fail';
    }
    
    public static function handle_update() {
        global $config, $db, $email_settings;
        $fn = $_REQUEST['FirstName'];
        $ln = $_REQUEST['LastName'];
        $em = $_REQUEST['stripeEmail'];
        $tk = $_REQUEST['stripeToken'];
        $ac = $config['stripe account']; // added $ac=$config['stripe account']
		$email_to = $email_settings['to'];
		if(isset($config['email_to'])) {
			$email_to = $config['email_to'];
		}
        if(!$tk || strlen($tk) < 1) {
            echo 'fail';
            return;
        }
        $customer = false;
        $cr = array();
        $res = mysql_query("SELECT * FROM customers WHERE first_name='".mysql_real_escape_string($fn)."' AND last_name='".mysql_real_escape_string($ln)."' AND email='".mysql_real_escape_string($em)."' AND stripe_account='".mysql_real_escape_string($ac)."' LIMIT 1", $db); // added stripe_account=$ac
        if($res && mysql_num_rows($res) > 0) {
            while($row = mysql_fetch_assoc($res)) {
                if(isset($row['stripe_customer_id']) && strlen($row['stripe_customer_id']) > 0 && !$customer) {
                    $cu = Stripe_Customer::retrieve($row['stripe_customer_id']);
                    if($cu && (!isset($cu->deleted) || !$cu->deleted)) {
                        $customer = true;
                        $cr = $row;
                    }
                }
            }
        }
        if(!$customer || !$cu) {
            echo 'notfound';
            return;
        }
        $card = $cu->cards->create(array('card' => $tk));
        if($card) {
    		if(!isset($card->name) || strpos($card->name,'@') !== false) {
    			$card->name = $fn." ".$ln;
    			$card->save();
    		} //added this if statement
            if(isset($card->id)) {
                if(isset($cu->default_card) && $card->id !== $cu->default_card) {
                    $cu->default_card = $card->id;
                    $cu->save();
                } //make last submitted card default
                $cu_id = $cr['id'];
                $entry = false;
                $res = mysql_query("SELECT * FROM entries WHERE customer_id='".mysql_real_escape_string($cu_id)."' AND tag='".mysql_real_escape_string($config['tag'])."' LIMIT 1", $db);
                if($res && mysql_num_rows($res) > 0) {
                    $now = time();
                    mysql_query("INSERT INTO cards (customer_id, stripe_card_id, last4, brand, exp_month, exp_year, modified) VALUES('".mysql_real_escape_string($cu_id)."', '".mysql_real_escape_string($card->id)."', '".mysql_real_escape_string($card->last4)."', '".mysql_real_escape_string($card->brand)."', '".mysql_real_escape_string($card->exp_month)."', '".mysql_real_escape_string($card->exp_year)."', '".$now."') ON DUPLICATE KEY UPDATE modified='".$now."', id=LAST_INSERT_ID(id)", $db);
    				// added exp_month & exp_year
                    $card_id = mysql_insert_id($db);
    				// mysql_query("UPDATE entries SET id=LAST_INSERT_ID(id), card_id='".mysql_real_escape_string($card_id)."', modified='".$now."' WHERE customer_id='".mysql_real_escape_string($cu_id)."' AND tag='".mysql_real_escape_string($config['tag'])."' LIMIT 1", $db); // OLD CODE
    				mysql_query("INSERT INTO entries (customer_id, card_id, tag, created, modified) VALUES('".mysql_real_escape_string($cu_id)."','".mysql_real_escape_string($card_id)."', '".mysql_real_escape_string($config['tag'])."', '".$now."', '".$now."') ON DUPLICATE KEY UPDATE card_id='".mysql_real_escape_string($card_id)."', modified='".$now."', id=LAST_INSERT_ID(id)", $db); // NEW CODE
                    $entry_id = mysql_insert_id($db);
                    $meta = $_POST;
                    unset($meta['FirstName'], $meta['LastName'], $meta['submit'], $meta['stripeToken'], $meta['stripeEmail']);
                    $notes = parse_url($_SERVER['REQUEST_URI']);
                    mysql_query("INSERT INTO entries_meta SET entry_id='".mysql_real_escape_string($entry_id)."', data='".mysql_real_escape_string(serialize($meta))."', source='".mysql_real_escape_string($notes['path'])."', title='".mysql_real_escape_string($config['title'])."', created='".$now."'", $db);
                    echo 'success';
    				mail($email_to,$email_settings['subject']." - ".$config['title'],$email_settings['message'].$fn." ".$ln."\n".$em,$email_settings['headers']);
    				// added mail function; references $email_settings in lib/setup.php
                    return;
                } else {
                    echo 'notfound';
                    return;
                }
            }
        }
        echo 'fail';
    }
}

?>
