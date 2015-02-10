<?php
session_start();
if(isset($_GET['p']) && $_GET['p'] == 'logout') {
    session_unset('loggedin');
    header("Location: /dashboard.php");
    die();
}
require_once('./lib/setup.php');
require_once('./lib/parsecsv.lib.php');
$res = mysql_query("SELECT DISTINCT e.tag, m.source FROM entries_meta m, entries e WHERE e.id = m.entry_id ORDER BY e.tag ASC, m.source ASC", $db);
$sources = array();
$validsources = array();
if($res && mysql_num_rows($res) > 0) {
    while($row = mysql_fetch_assoc($res)) {
        $sources[$row['tag']][] = $row['source'];
        $validsources[] = $row['source'];
    }
}
$chargesources = array();
$res = mysql_query("SELECT DISTINCT tag FROM charges ORDER BY tag ASC");
if($res && mysql_num_rows($res) > 0) {
    while($row = mysql_fetch_assoc($res)) {
        $chargesources[] = $row['tag'];
    }
}
if(isset($_POST['login'])) {
    if(isset($dashboard_login[$_POST['username']]) && $_POST['password'] == $dashboard_login[$_POST['username']]) {
        $_SESSION['loggedin'] = true;
    } // changed credentials from fixed variables to key/value pairs
}
// ****** EXPORT ENTRIES BUTTON ACTION
if(isset($_POST['export']) && !isset($_GET['p'])) {
    $from = strtotime($_POST['from']);
    $to = strtotime($_POST['to']);
    if(!$from) { $from = time() - 604800; }
    if(!$to) { $to = time(); }
    $good = true;
    if(!$_POST['source'] || !in_array($_POST['source'], $validsources)) {
        $good = false;
    }
// ****** EXPORT FILTERED SELECTION OF ENTRIES
    if($good) {
        $res = mysql_query("SELECT cu.stripe_customer_id, cu.first_name, cu.last_name, cu.email, cu.stripe_account, ca.stripe_card_id, ca.last4, ca.brand, ca.exp_month, ca.exp_year, e.*, m.data FROM entries_meta m, entries e, cards ca, customers cu WHERE e.id = m.entry_id AND cu.id = e.customer_id AND ca.id = e.card_id AND m.source = '".mysql_real_escape_string($_POST['source'])."' AND m.created > '".$from."' AND m.created < '".$to."' ORDER BY m.created ASC", $db);
		//added exp_month & exp_year
		//added stripe_account
        if($res && mysql_num_rows($res) > 0) {
            $table = true;
            $th = false;
            $out = array();
            while($row = mysql_fetch_assoc($res)) {
                $or = array();
                $meta = unserialize($row['data']);
                if(count($out) == 0) {
                    $oh = array('Created','FirstName','LastName','Email','StripeAccount','StripeCustomerID','StripeCardID','StripeCardBrand','StripeCardLastFour','ExpMonth','ExpYear');
					//added exp_month & exp_year
					//added StripeAccount
                    $oh = array_merge($oh, array_keys($meta));
                }
                $or[] = date('m/d/Y', intval($row['created']));
                $or[] = $row['first_name'];
                $or[] = $row['last_name'];
                $or[] = $row['email'];
                $or[] = $row['stripe_account'];
                $or[] = $row['stripe_customer_id'];
                $or[] = $row['stripe_card_id'];
                $or[] = $row['brand'];
                $or[] = sprintf('%04d', $row['last4']);
                $or[] = sprintf('%02d', $row['exp_month']);
                $or[] = sprintf('%04d',$row['exp_year']);
				//added exp_month & exp_year
				//added stripe_account
                $out[] = array_merge($or, array_values($meta));
            }
            $fn = trim($_POST['source']).'-'.$from.'-'.$to.'.csv'; // added trim formatting
            $csv = new parseCSV();
            $csv->output($fn, $out, $oh, ',');
            die();
        }
// ****** EXPORT ALL ENTRIES
    } else { //start All Entries addition
        $res = mysql_query("SELECT cu.stripe_customer_id, cu.first_name, cu.last_name, cu.email, cu.stripe_account, ca.stripe_card_id, ca.last4, ca.brand, ca.exp_month, ca.exp_year, e.*, m.data, m.source, m.created AS date FROM entries_meta m, entries e, cards ca, customers cu WHERE e.id = m.entry_id AND cu.id = e.customer_id AND ca.id = e.card_id AND m.created > '".$from."' AND m.created < '".$to."' ORDER BY m.created ASC", $db);
		//added stripe_account
        if($res && mysql_num_rows($res) > 0) {
            $table = true;
            $th = false;
            $out = array();
            while($row = mysql_fetch_assoc($res)) {
                $or = array();
                $meta = unserialize($row['data']);
                if(count($out) == 0) {
                    $oh = array('Date','FirstName','LastName','Email','StripeAccount','StripeCustomerID','StripeCardID','StripeCardBrand','StripeCardLastFour','ExpMonth','ExpYear','Form');
					//added StripeAccount
                }
                $or[] = date('m/d/Y', intval($row['date']));
                $or[] = $row['first_name'];
                $or[] = $row['last_name'];
                $or[] = $row['email'];
                $or[] = $row['stripe_account'];
                $or[] = $row['stripe_customer_id'];
                $or[] = $row['stripe_card_id'];
                $or[] = $row['brand'];
                $or[] = sprintf('%04d', $row['last4']);
                $or[] = sprintf('%02d', $row['exp_month']);
                $or[] = sprintf('%04d',$row['exp_year']);
                $or[] = $row['source'];
				//added stripe_account
                $out[] = $or;
            }
            $fn = 'AllEntries-'.$from.'-'.$to.'.csv';
            $csv = new parseCSV();
            $csv->output($fn, $out, $oh, ',');
            die();
        }
    } //end All Entries addition
}
// ****** EXPORT CHARGES BUTTON ACTION
if(isset($_POST['export']) && isset($_GET['p']) && $_GET['p'] == 'charges') {
    $from = strtotime($_POST['from']);
    $to = strtotime($_POST['to']);
    if(!$from) { $from = time() - 604800; }
    if(!$to) { $to = time(); }
    $good = true;
    if(!$_POST['source'] || !in_array(trim($_POST['source']), $chargesources)) {
        $good = false;
    }
// ****** EXPORT FILTERED SELECTION OF CHARGES
    if($good) {
        $res = mysql_query("SELECT cu.stripe_customer_id, cu.first_name, cu.last_name, cu.email, cu.stripe_account, ca.stripe_card_id, ca.last4, ca.brand, ch.* FROM charges ch, cards ca, customers cu WHERE ca.id = ch.card_id AND cu.id = ca.customer_id AND ch.tag = '".mysql_real_escape_string(trim($_POST['source']))."' AND ch.created > '".$from."' AND ch.created < '".$to."' ORDER BY ch.created ASC", $db);
		//added stripe_account
        if($res && mysql_num_rows($res) > 0) {
            $table = true;
            $th = false;
            $out = array();
            while($row = mysql_fetch_assoc($res)) {
                $or = array();
                if(count($out) == 0) {
                    $oh = array('Created','FirstName','LastName','Email','StripeAccount','StripeCustomerID','StripeCardID','Brand','LastFour','Amount','Description','Tag','Status','Error','StripeChargeID');
					// added Description
					// added StripeAccount
                }
                $or[] = date('m/d/Y', intval($row['created']));
                $or[] = $row['status'];
                $or[] = $row['first_name'];
                $or[] = $row['last_name'];
                $or[] = $row['email'];
                $or[] = $row['stripe_account'];
				//added stripe_account
                $or[] = $row['stripe_customer_id'];
                $or[] = $row['stripe_card_id'];
                $or[] = $row['brand'];
                $or[] = sprintf('%04d', $row['last4']);
                $or[] = $row['amount'];
                $or[] = $row['description'];
				// added description
                $or[] = $row['tag'];
                $or[] = $row['error'];
                $or[] = $row['stripe_charge_id'];
                $out[] = $or;
            }
            $fn = trim($_POST['source']).'-'.$from.'-'.$to.'.csv'; // added trim formatting
            $csv = new parseCSV();
            $csv->output($fn, $out, $oh, ',');
            die();
        }
// ****** EXPORT ALL CHARGES
    } else { // start All Charges addition
        $res = mysql_query("SELECT cu.stripe_customer_id, cu.first_name, cu.last_name, cu.email, cu.stripe_account, ca.stripe_card_id, ca.last4, ca.brand, ch.* FROM charges ch, cards ca, customers cu WHERE ca.id = ch.card_id AND cu.id = ca.customer_id AND ch.created > '".$from."' AND ch.created < '".$to."' ORDER BY ch.created ASC", $db);
		//added stripe_account
        if($res && mysql_num_rows($res) > 0) {
            $table = true;
            $th = false;
            $out = array();
            while($row = mysql_fetch_assoc($res)) {
                $or = array();
                if(count($out) == 0) {
                    $oh = array('Created','StripeCardID','Amount','Description','Tag','Status','Error','StripeChargeID');
					// added StripeAccount
                }
                $or[] = date('m/d/Y', intval($row['created']));
                $or[] = $row['stripe_card_id'];
                $or[] = $row['amount'];
                $or[] = $row['description'];
                $or[] = $row['tag'];
                $or[] = $row['status'];
                $or[] = $row['error'];
                $or[] = $row['stripe_charge_id'];
                $out[] = $or;
            }
            $fn = 'AllCharges-'.$from.'-'.$to.'.csv';
            $csv = new parseCSV();
            $csv->output($fn, $out, $oh, ',');
            die();
        }
    } // end All Charges addition
}
// ****** HTML HEADER
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properities -->
    <title>Dashboard</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Open+Sans:300italic,400,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="/assets/css/semantic.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/semantictweaks.css">
    <style>
        body {
            font-family: "Open Sans", "Helvetica Neue", "Helvetica", "Arial", sans-serif;
            background: #EEEEEE;
            margin: 0px;
            padding: 0px;
            color: #000000;
            text-rendering: optimizeLegibility;
            min-width: 320px;
            overflow-x: hidden;
        }
    </style>
    <script type="text/javascript" src="assets/javascript/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="assets/javascript/semantic.js"></script>
</head>
<body>
<?php
if(isset($_SESSION['loggedin'])) {
?>
    <div class="main container">
<?php
// ****** UPLOADS TAB
    if(isset($_GET['p']) && $_GET['p'] == 'upload') {
// ****** PROCESS UPLOADS AND DISPLAY RESULTS
        if(isset($_POST['upload'])) {
?>
<div class="ui horizontal menu">
            <a class="item" href="/dashboard.php">
              Entries
            </a>
            <a class="active teal item" href="/dashboard.php?p=charges">
              Charges
            </a>
            <a class="item" href="/dashboard.php?p=refunds">
              Refunds
            </a>
            <a class="item" href="/dashboard.php?p=logout">
              Log Out
            </a>
            <form class="right menu" method="post" action="/dashboard.php?p=charges">
                <div class="item">
                    <a class="ui blue button" href="/dashboard.php?p=upload">Upload</a>
                </div>
                <div class="ui dropdown item">
                    <input type="hidden" name="source" value="<?php echo (isset($_POST['source'])) ? $_POST['source'] : ''; ?>">
                    <div class="default text">Source</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">
<?php foreach($chargesources as $v) { ?>
                      <div class="item">
                        <?php echo $v; ?>
                      </div>
<?php } ?>
                    </div>
                </div>
                <div class="item">
                    <div class="ui input">
                        <input type="text" name="from" placeholder="From MM/DD/YYYY" value="<?php echo (isset($_POST['from'])) ? $_POST['from'] : ''; ?>">
                    </div>
                </div>
                <div class="item">
                    <div class="ui input">
                        <input type="text" name="to" placeholder="To MM/DD/YYYY" value="<?php echo (isset($_POST['to'])) ? $_POST['to'] : ''; ?>">
                    </div>
                </div>
                <div class="item">
                    <input type="submit" name="filter" value="Filter" class="ui blue submit button">
                </div>
                <div class="item">
                    <input type="submit" name="export" value="Export" class="ui blue submit button">
                </div>
            </form>
        </div>
        <div class="ui one column grid">
            <div class="column" style="overflow-x: auto; overflow-y: auto;">
<?php
// ****** PROCESS UPLOADS
                $table = false;
                $fn = $_FILES['userfile']['tmp_name'];
                $csv = new parseCSV();
                $csv->encoding(null, 'UTF-8');
                $csv->parse($fn);
                $now = time();
                foreach($csv->data as $row) {
                    $card_id = false;
                    if(isset($row['tag']) && isset($row['amount'])) {
                        $cu_id = false;
                        if(isset($row['stripe_customer_id'])) {
                            $res = mysql_query("SELECT id FROM customers WHERE stripe_customer_id='".mysql_real_escape_string($row['stripe_customer_id'])."' LIMIT 1");
                            if($res && mysql_num_rows($res) == 1) {
                                $customer = mysql_fetch_assoc($res);
                                $cu_id = $customer['id'];
                            }
                        } elseif(isset($row['first_name']) && isset($row['last_name']) && isset($row['email']) && isset($row['stripe_account'])) {
                            $res = mysql_query("SELECT id, stripe_customer_id FROM customers WHERE first_name='".mysql_real_escape_string($row['first_name'])."' AND last_name='".mysql_real_escape_string($row['last_name'])."' AND email='".mysql_real_escape_string($row['email'])."' AND stripe_account='".mysql_real_escape_string($row['stripe_account'])."' LIMIT 1");
            				//added stripe_account
                            if($res && mysql_num_rows($res) == 1) {
                                $customer = mysql_fetch_assoc($res);
                                $cu_id = $customer['id'];
                                $row['stripe_customer_id'] = $customer['stripe_customer_id'];
                            }
                        }
                        if($cu_id) {
                            $card_id = false;
                            if(isset($row['stripe_card_id'])) {
                                mysql_query("INSERT INTO cards (customer_id, stripe_card_id, brand, last4, exp_month, exp_year) VALUES('".mysql_real_escape_string($cu_id)."', '".mysql_real_escape_string($row['stripe_card_id'])."', '".mysql_real_escape_string($row['brand'])."', '".mysql_real_escape_string($row['last4'])."', '".mysql_real_escape_string($row['exp_month'])."', '".mysql_real_escape_string($row['exp_year'])."') ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)", $db);
                                $card_id = mysql_insert_id($db);
                            } else {
                                $res = mysql_query("SELECT card_id FROM entries WHERE customer_id='".$cu_id."' AND tag='".mysql_real_escape_string($row['tag'])."' ORDER BY modified DESC LIMIT 1");
                                if($res && mysql_num_rows($res) == 1) {
                                    $card = mysql_fetch_assoc($res);
                                    $card_id = $card['card_id'];
                                }
                            }

                        } elseif(isset($row['first_name']) && isset($row['last_name']) && isset($row['email']) && isset($row['stripe_account']) && isset($row['stripe_customer_id']) && isset($row['stripe_card_id'])) {
                            mysql_query("INSERT INTO customers (first_name, last_name, email, stripe_account, stripe_customer_id) VALUES('".mysql_real_escape_string($row['first_name'])."', '".mysql_real_escape_string($row['last_name'])."', '".mysql_real_escape_string($row['email'])."', '".mysql_real_escape_string($row['stripe_account'])."', '".mysql_real_escape_string($row['stripe_customer_id'])."') ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)", $db);
            				//added stripe_account
                            $cu_id = mysql_insert_id($db);
                            mysql_query("INSERT INTO cards (customer_id, stripe_card_id, brand, last4, exp_month, exp_year) VALUES('".mysql_real_escape_string($cu_id)."', '".mysql_real_escape_string($row['stripe_card_id'])."', '".mysql_real_escape_string($row['brand'])."', '".mysql_real_escape_string($row['last4'])."', '".mysql_real_escape_string($row['exp_month'])."', '".mysql_real_escape_string($row['exp_year'])."') ON DUPLICATE KEY UPDATE id=LAST_INSERT_ID(id)", $db);
                            $card_id = mysql_insert_id($db);
                        }
                        if($card_id) {
                            $res = mysql_query("SELECT * FROM cards WHERE id='".intval($card_id)."' LIMIT 1");
                            if($res && mysql_num_rows($res) == 1) {
                                $card = mysql_fetch_assoc($res);
                                $succ = true;
                                $charge = "";
                                $stripe_charge_id = "";
                                // new code, FROM HERE
                                $res_test = mysql_query("SELECT * FROM charges WHERE card_id='".intval($card_id)."' AND charge_id='".mysql_real_escape_string($row['charge_id'])."'"); // " AND (".$now." - created) < 43200 LIMIT 1" // Append query with this to allow re-charge attempts after 12 hours
                                if($res_test && mysql_num_rows($res_test) > 0) {
                                    $succ = false;
                                    $error = "This charge already attempted on this card."; // TO HERE, prevents duplicate charge attempts
                                } else {
                                    try {
                                        Setup::stripeKey($row['stripe_account']);
                                        // added stripe_account
                                        $charge = Stripe_Charge::Create(array(
                                            "amount" => intval(floatval($row['amount']) * 100),
                                            "currency" => "usd",
                                            "customer" => $row["stripe_customer_id"],
                                            "card" => $card["stripe_card_id"],
                                            "description" => (isset($row['description']) && $row['description']) ? $row['description'] : null,
                                            "statement_descriptor" => (isset($row['statement_descriptor']) && $row['statement_descriptor']) ? $row['statement_descriptor'] : null
                                            ));
                                    } catch (Exception $e) {
                                        $succ = false;
                                        $error = $e->getMessage();
                                        $stripe_charge_id = $e->getJsonBody()['error']['charge'];
                                    }
                                }
                                if(isset($charge['id'])) {
                                    $stripe_charge_id = $charge['id'];
                                } else if($stripe_charge_id == "") {
                                    list($usec, $time) = explode(' ', microtime());
                                    $usec = str_replace("0.", "", $usec);
                                    $usec = substr($usec, 0, 6);
                                    $microtime = $time.$usec;
                                    $stripe_charge_id = "error_".$microtime;
                                }
                                if($succ) {
                                    mysql_query("INSERT INTO charges SET card_id='".$card_id."', charge_id='".mysql_real_escape_string($row['charge_id'])."', stripe_charge_id='".$stripe_charge_id."', amount='".mysql_real_escape_string(floatval($row['amount']))."', description='".mysql_real_escape_string($row['description'])."', status='1', created='".$now."', tag='".mysql_real_escape_string($row['tag'])."', filename='".mysql_real_escape_string($fn)."'");
                                } else {
                                    mysql_query("INSERT INTO charges SET card_id='".$card_id."', charge_id='".mysql_real_escape_string($row['charge_id'])."', stripe_charge_id='".$stripe_charge_id."', amount='".mysql_real_escape_string(floatval($row['amount']))."', description='".mysql_real_escape_string($row['description'])."', status='0', error='".mysql_real_escape_string($error)."', created='".$now."', tag='".mysql_real_escape_string($row['tag'])."', filename='".mysql_real_escape_string($fn)."'");
                                }
            					//added description
                            }

                        }
                    }
                }
// ****** DISPLAY UPLOAD RESULTS
                $good = true;
                if($good) {
                    $res = mysql_query("SELECT cu.stripe_customer_id, cu.first_name, cu.last_name, cu.email, cu.stripe_account, ca.stripe_card_id, ca.last4, ca.brand, ch.* FROM charges ch, cards ca, customers cu WHERE ca.id = ch.card_id AND cu.id = ca.customer_id AND ch.filename = '".mysql_real_escape_string($fn)."' AND ch.created ='".$now."' AND ch.filename='".$fn."' ORDER BY status DESC", $db);
            		//added stripe_account
                    if($res && mysql_num_rows($res) > 0) {
                        $table = true;
                        $th = false;
                        $out = array();
                        $chargestatus = array(
                            '<i class="red attention icon"></i>',
                            '<i class="green ok sign icon"></i>'
                        );
?>
<table class="ui celled table segment nowrap"  style="margin: 10px;"> <!--added celled-->
<?php
                        while($row = mysql_fetch_assoc($res)) {
                            $or = array();
                            if(count($out) == 0) {
                                $out[] = array('Date','Status','FirstName','LastName','Email','Amount','Description','StripeAccount','LastFour','Brand','Error','StripeCustomerID','StripeCardID','StripeChargeID');
            				// added Description
            				// added StripeAccount
                            }
                            $or[] = date('m/d/Y', intval($row['created']));
                            $or[] = $chargestatus[intval($row['status'])];
                            $or[] = $row['first_name'];
                            $or[] = $row['last_name'];
                            $or[] = $row['email'];
                            $or[] = "<span style=\"float:right;\">$ ".number_format($row['amount'],2)."</span>";
                            $or[] = $row['description'];
                            $or[] = $row['stripe_account'];
                            // added stripe_account
                            $or[] = sprintf('%04d', $row['last4']);
                            $or[] = $row['brand'];
                            $or[] = $row['error'];
                            $or[] = $row['stripe_customer_id'];
                            $or[] = $row['stripe_card_id'];
                            $or[] = str_replace(' ','<br />',$row['stripe_charge_id']);
                            $out[] = $or;
                        }
                        foreach($out as $r) {
                            if(!$th) {
                                echo "<thead>\n";
                            }
                            echo "<tr>\n";
                            foreach($r as $c) {
                                echo "<td>".$c."</td>\n";
                            }
                            echo "</tr>\n";
                            if(!$th) {
                                echo "</thead>\n<tbody>\n";
                                $th = true;
                            }
                        }
                        echo "</tbody>\n</table>\n";
                    }
                }
                if(!$table) {
?>
<div class="ui segment"  style="margin: 10px;"><h1>No Results</h1></div>
<?php
                }
?>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.ui.dropdown').dropdown();
        });
    </script>
<?php
// ****** DISPLAY UPLOAD PAGE
        } else {
?>
<div class="ui horizontal menu">
            <a class="item" href="/dashboard.php">
              Entries
            </a>
            <a class="active teal item" href="/dashboard.php?p=charges">
              Charges
            </a>
            <a class="item" href="/dashboard.php?p=refunds">
              Refunds
            </a>
            <a class="item" href="/dashboard.php?p=logout">
              Log Out
            </a>
            <form class="right menu" method="post" action="/dashboard.php?p=charges">
                <div class="item">
                    <a class="ui blue button" href="/dashboard.php?p=upload">Upload</a>
                </div>
                <div class="ui dropdown item">
                    <input type="hidden" name="source" value="<?php echo (isset($_POST['source'])) ? $_POST['source'] : ''; ?>">
                    <div class="default text">Source</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">
<?php foreach($chargesources as $v) { ?>
                      <div class="item"><?php echo $v; ?></div>
<?php } ?>
                    </div>
                </div>
                <div class="item">
                    <div class="ui input">
                        <input type="text" name="from" placeholder="From MM/DD/YYYY" value="<?php echo (isset($_POST['from'])) ? $_POST['from'] : ''; ?>">
                    </div>
                </div>
                <div class="item">
                    <div class="ui input">
                        <input type="text" name="to" placeholder="To MM/DD/YYYY" value="<?php echo (isset($_POST['to'])) ? $_POST['to'] : ''; ?>">
                    </div>
                </div>
                <div class="item">
                    <input type="submit" name="filter" value="Filter" class="ui blue submit button">
                </div>
                <div class="item">
                    <input type="submit" name="export" value="Export" class="ui blue submit button">
                </div>
            </form>
        </div>
        <div class="ui one column stackable page grid">
            <div class="column">
                <form enctype="multipart/form-data" action="/dashboard.php?p=upload" method="POST" class="ui form relaxed segment">
                    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
                    <div class="field">
                    <label>Upload CSV</label><input name="userfile" type="file" />
                    </div>
                    <input type="submit" name="upload" value="Upload" class="ui blue submit button" />
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.ui.dropdown').dropdown();
        });
    </script>
<?php
        }
// ****** CHARGES TAB
    } elseif(isset($_GET['p']) && $_GET['p'] == 'charges') {
?>
        <div class="ui horizontal menu">
            <a class="item" href="/dashboard.php">
              Entries
            </a>
            <a class="active teal item" href="/dashboard.php?p=charges">
              Charges
            </a>
            <a class="item" href="/dashboard.php?p=refunds">
              Refunds
            </a>
            <a class="item" href="/dashboard.php?p=logout">
              Log Out
            </a>
            <form class="right menu" method="post" action="/dashboard.php?p=charges">
                <div class="item">
                    <a class="ui blue button" href="/dashboard.php?p=upload">Upload</a>
                </div>
                <div class="ui dropdown item">
                    <input type="hidden" name="source" value="<?php echo (isset($_POST['source'])) ? $_POST['source'] : ''; ?>">
                    <div class="default text">Source</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">
<?php foreach($chargesources as $v) { ?>
                      <div class="item"><?php echo $v; ?></div>
<?php } ?>
                    </div>
                </div>
                <div class="item">
                    <div class="ui input">
                        <input type="text" name="from" placeholder="From MM/DD/YYYY" value="<?php echo (isset($_POST['from'])) ? $_POST['from'] : ''; ?>">
                    </div>
                </div>
                <div class="item">
                    <div class="ui input">
                        <input type="text" name="to" placeholder="To MM/DD/YYYY" value="<?php echo (isset($_POST['to'])) ? $_POST['to'] : ''; ?>">
                    </div>
                </div>
                <div class="item">
                    <input type="submit" name="filter" value="Filter" class="ui blue submit button">
                </div>
                <div class="item">
                    <input type="submit" name="export" value="Export" class="ui blue submit button">
                </div>
            </form>
        </div>
        <div class="ui one column grid">
            <div class="column" style="overflow-x: auto; overflow-y: auto;">
<?php
        $table = false;
// ****** DISPLAY CHARGES PAGE WITH ALL CHARGES
        if(!isset($_POST['filter'])) { //start All Charges addition
        	$from = time() - 604800;
        	$to = time();
        	$res = mysql_query("SELECT cu.stripe_customer_id, cu.first_name, cu.last_name, cu.email, cu.stripe_account, ca.stripe_card_id, ca.last4, ca.brand, ch.* FROM charges ch, cards ca, customers cu WHERE ca.id = ch.card_id AND cu.id = ca.customer_id AND ch.created > '".$from."' AND ch.created < '".$to."' ORDER BY ch.created DESC", $db);
        	//added stripe_account
        	if($res && mysql_num_rows($res) > 0) {
        		$table = true;
        		$th = false;
        		$out = array();
        		$chargestatus = array(
        			'<i class="red attention icon"></i>',
        			'<i class="green ok sign icon"></i>'
        		);
?>
<table class="ui celled table segment nowrap" style="margin: 10px;"> <!--added celled-->
<?php
        		while($row = mysql_fetch_assoc($res)) {
        			$or = array();
        			if(count($out) == 0) {
        				$out[] = array('Date','Status','FirstName','LastName','Email','Amount','Description','StripeAccount','LastFour','Brand','Error','StripeCustomerID','StripeCardID','StripeChargeID');
        				// added StripeAccount
        			}
        			$or[] = date('m/d/Y', intval($row['created']));
                    $or[] = $chargestatus[intval($row['status'])];
        			$or[] = $row['first_name'];
        			$or[] = $row['last_name'];
        			$or[] = $row['email'];
                    $or[] = "<span style=\"float:right;\">$ ".number_format($row['amount'],2)."</span>";
                    $or[] = $row['description'];
                    $or[] = $row['stripe_account'];
                    // added stripe_account
                    $or[] = sprintf('%04d', $row['last4']);
                    $or[] = $row['brand'];
                    $or[] = $row['error'];
        			$or[] = $row['stripe_customer_id'];
        			$or[] = $row['stripe_card_id'];
                    $or[] = str_replace(' ','<br />',$row['stripe_charge_id']);
        			$out[] = $or;
        		}
        		foreach($out as $r) {
        			if(!$th) {
        				echo "<thead>\n";
        			}
        			echo "<tr>\n";
        			foreach($r as $c) {
        				echo "<td>".$c."</td>\n";
        			}
        			echo "</tr>\n";
        			if(!$th) {
        				echo "</thead>\n<tbody>\n";
        				$th = true;
        			}
        		}
                echo "</tbody>\n</table>\n";
            }
        } //end All Charges addition
// ****** DISPLAY FILTERED CHARGES
        if(isset($_POST['filter'])) {
            $from = strtotime($_POST['from']);
            $to = strtotime($_POST['to']);
            if(!$from) { $from = time() - 604800; }
            if(!$to) { $to = time(); }
            $sourceset = true;
            if(!$_POST['source'] || !in_array(trim($_POST['source']), $chargesources)) {
                echo $_POST['source'];
                $sourceset = false;
            }
            if($sourceset) {
        		$res = mysql_query("SELECT cu.stripe_customer_id, cu.first_name, cu.last_name, cu.email, cu.stripe_account, ca.stripe_card_id, ca.last4, ca.brand, ch.* FROM charges ch, cards ca, customers cu WHERE ca.id = ch.card_id AND cu.id = ca.customer_id AND ch.tag = '".mysql_real_escape_string(trim($_POST['source']))."' AND ch.created > '".$from."' AND ch.created < '".$to."' ORDER BY ch.created DESC", $db);
        		// added stripe_account
        	} else {
        		$res = mysql_query("SELECT cu.stripe_customer_id, cu.first_name, cu.last_name, cu.email, cu.stripe_account, ca.stripe_card_id, ca.last4, ca.brand, ch.* FROM charges ch, cards ca, customers cu WHERE ca.id = ch.card_id AND cu.id = ca.customer_id AND ch.created > '".$from."' AND ch.created < '".$to."' ORDER BY ch.created DESC", $db);
        		// added stripe_account
        	}
        	if($res && mysql_num_rows($res) > 0) {
        		$table = true;
        		$th = false;
        		$out = array();
        		$chargestatus = array(
        			'<i class="red attention icon"></i>',
        			'<i class="green ok sign icon"></i>'
        		)
?>
<table class="ui celled table segment nowrap" style="margin: 10px;"> <!--added celled-->
<?php
        		while($row = mysql_fetch_assoc($res)) {
        			$or = array();
        			if(count($out) == 0) {
        				$out[] = array('Date','Status','FirstName','LastName','Email','Amount','Description','StripeAccount','LastFour','Brand','Error','StripeCustomerID','StripeCardID','StripeChargeID');
        			// added Description
        			// added StripeAccount
        			}
        			$or[] = date('m/d/Y', intval($row['created']));
                    $or[] = $chargestatus[intval($row['status'])];
                    $or[] = $row['first_name'];
                    $or[] = $row['last_name'];
                    $or[] = $row['email'];
                    $or[] = "<span style=\"float:right;\">$ ".number_format($row['amount'],2)."</span>";
                    $or[] = $row['description'];
                    $or[] = $row['stripe_account'];
                    // added stripe_account
                    $or[] = sprintf('%04d', $row['last4']);
                    $or[] = $row['brand'];
                    $or[] = $row['error'];
                    $or[] = $row['stripe_customer_id'];
                    $or[] = $row['stripe_card_id'];
                    $or[] = str_replace(' ','<br />',$row['stripe_charge_id']);
        			$out[] = $or;
        		}
        		foreach($out as $r) {
        			if(!$th) {
        				echo "<thead>\n";
        			}
        			echo "<tr>\n";
        			foreach($r as $c) {
        				echo "<td>".$c."</td>\n";
        			}
        			echo "</tr>\n";
        			if(!$th) {
        				echo "</thead>\n<tbody>\n";
        				$th = true;
        			}
        		}
        		echo "</tbody>\n</table>\n";
	       }
        }
        if(!$table) {
?>
<div class="ui segment" style="margin: 10px;"><h1>No Results</h1></div>
<?php
        }
?>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.ui.dropdown').dropdown();
        });
    </script>
<?php 
// ****** REFUNDS TAB
    } elseif(isset($_GET['p']) && $_GET['p'] == 'refunds') {
// ****** REFUND BUTTON ACTION - DISPLAY REFUND CONFIRMATION
        if(isset($_POST['ch'])) {
            $ch = array (
                'stripe_charge_id' => $_POST['ch'],
                'first_name' => $_POST['ch_firstname'],
                'last_name' => $_POST['ch_lastname'],
                'email' => $_POST['ch_email'],
                'amount' => $_POST['ch_amount'],
                'description' => $_POST['ch_description'],
                'account' => $_POST['ch_account'],
                'last4' => $_POST['ch_last4'],
                'brand' => $_POST['ch_brand'],
                'tag' => $_POST['ch_tag'],
                'card_id' => $_POST['ch_card_id']
            );
?>
        <div class="ui horizontal menu">
            <a class="item" href="/dashboard.php">
              Entries
            </a>
            <a class="item" href="/dashboard.php?p=charges">
              Charges
            </a>
            <a class="active teal item" href="/dashboard.php?p=refunds">
              Refunds
            </a>
            <a class="item" href="/dashboard.php?p=logout">
              Log Out
            </a>
            <form class="right menu" method="post" action="/dashboard.php?p=refunds">
                <div class="ui dropdown item">
                    <input type="hidden" name="source" value="<?php echo (isset($_POST['source'])) ? $_POST['source'] : ''; ?>">
                    <div class="default text">Source</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">
<?php foreach($chargesources as $v) { ?>
                      <div class="item"><?php echo $v; ?></div>
<?php } ?>
                    </div>
                </div>
                <div class="item">
                    <div class="ui input">
                        <input type="text" name="from" placeholder="From MM/DD/YYYY" value="<?php echo (isset($_POST['from'])) ? $_POST['from'] : ''; ?>">
                    </div>
                </div>
                <div class="item">
                    <div class="ui input">
                        <input type="text" name="to" placeholder="To MM/DD/YYYY" value="<?php echo (isset($_POST['to'])) ? $_POST['to'] : ''; ?>">
                    </div>
                </div>
                <div class="item">
                    <input type="submit" name="filter" value="Filter" class="ui blue submit button">
                </div>
            </form>
        </div>
        <div class="ui one column stackable page grid">
            <div class="column">
                <form action="/dashboard.php?p=refunds" method="POST" class="ui form relaxed segment">
                    <input type="hidden" name="re_card_id" value="<?php echo $ch['card_id'] ?>" />
                    <input type="hidden" name="re_charge_id" value="<?php echo $ch['stripe_charge_id'] ?>" />
                    <input type="hidden" name="re_description" value="<?php echo $ch['description'] ?>" />
                    <input type="hidden" name="re_tag" value="<?php echo $ch['tag'] ?>" />
                    <input type="hidden" name="re_account" value="<?php echo $ch['account'] ?>" />
                    <div class="two fields">
                        <div class="field">
                            <div class="field">
                                <b><?php echo $ch['first_name'].' '.$ch['last_name']; ?></b> - <?php echo $ch['email']; ?>
                            </div>
                            <div class="field">
                                Stripe account: <b><?php echo $ch['account'] ?></b>
                            </div>
                            <div class="field">
                                <b><?php echo $ch['brand'].'</b> ending in <b>'.$ch['last4']; ?></b>
                            </div>
                        </div>
                        <div class="field">
                            <div class="field">
                                <b><?php echo $ch['description']; ?></b>
                            </div>
                            <div class="field">
                                Charged amount: <b>$ <?php echo number_format((float)$ch['amount'],2,'.',''); ?></b>
                            </div>
                            <div class="field">
                                Refund amount: <input type="text" name="re_amount" value="<?php echo number_format((float)$ch['amount'],2,'.',''); ?>" />
                            </div>
                            <div class="field">
                                <label>Refund this charge?</label>
                            </div>
                            <input type="submit" name="refund_it" value="REFUND" class="ui blue button" />
                            <a class="ui blue submit button" href="/dashboard.php?p=refunds">CANCEL</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.ui.dropdown').dropdown();
        });
    </script>
<?php
// ****** REFUND CONFIRMATION BUTTON ACTION - PROCESS REFUND
        } else if(isset($_POST['refund_it'])) {
            $now = time();
            $charge_id = $_POST['re_charge_id'];
            $re_amount = $_POST['re_amount'];
            $re_description = 'REFUND - '.$_POST['re_description'];
            $re_account = $_POST['re_account'];
            $re_tag = $_POST['re_tag'];
            $re_card = $_POST['re_card_id'];
            $re_error = '';
            $re_status = 1;
            try {
                Setup::stripeKey($re_account);
                $ch = Stripe_Charge::retrieve($charge_id);
                $re = $ch->refunds->create(array(
                    "amount" => intval(floatval($re_amount) * 100),
                    ));
            } catch (Exception $e) {
                $re_status = 0;
                $re_error = $e->getMessage();
            }
            if(isset($re['id'])) {
                $re_id = $re['id'];
            } else {
                $re_id = 're_error_'.$now;
            }
            $re_id = $charge_id.' '.$re_id;
            $re_amount = -1* $re_amount;
            mysql_query("INSERT INTO charges SET card_id='".intval($re_card)."', stripe_charge_id='".mysql_real_escape_string($re_id)."', amount='".floatval($re_amount)."', description='".mysql_real_escape_string($re_description)."', status='".intval($re_status)."', error='".mysql_real_escape_string($re_error)."', created='".$now."', tag='".mysql_real_escape_string($re_tag)."'");
?>
        <div class="ui horizontal menu">
            <a class="item" href="/dashboard.php">
              Entries
            </a>
            <a class="item" href="/dashboard.php?p=charges">
              Charges
            </a>
            <a class="active teal item" href="/dashboard.php?p=refunds">
              Refunds
            </a>
            <a class="item" href="/dashboard.php?p=logout">
              Log Out
            </a>
            <form class="right menu" method="post" action="/dashboard.php?p=refunds">
                <div class="ui dropdown item">
                    <input type="hidden" name="source" value="<?php echo (isset($_POST['source'])) ? $_POST['source'] : ''; ?>">
                    <div class="default text">Source</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">
<?php foreach($chargesources as $v) { ?>
                      <div class="item"><?php echo $v; ?></div>
<?php } ?>
                    </div>
                </div>
                <div class="item">
                    <div class="ui input">
                        <input type="text" name="from" placeholder="From MM/DD/YYYY" value="<?php echo (isset($_POST['from'])) ? $_POST['from'] : ''; ?>">
                    </div>
                </div>
                <div class="item">
                    <div class="ui input">
                        <input type="text" name="to" placeholder="To MM/DD/YYYY" value="<?php echo (isset($_POST['to'])) ? $_POST['to'] : ''; ?>">
                    </div>
                </div>
                <div class="item">
                    <input type="submit" name="filter" value="Filter" class="ui blue submit button">
                </div>
            </form>
        </div>
        <div class="ui one column stackable page grid">
            <div class="column">
<?php if ($re_status == 1) { ?>
                <div class="ui positive message">
                    <div class="header">
                        Refund Successful
                    </div>
                    <div class="field"><a class="ui blue submit button" href="/dashboard.php?p=refunds">OK</a></div></div>
                </div>
<?php } else { ?>
                <div class="ui negative message">
                    <div class="header">
                        Error
                    </div>
                    <label><?php echo $re_error; ?></label>
                    <div class="field"><a class="ui blue submit button" href="/dashboard.php?p=refunds">OK</a></div>
                </div>
<?php } ?>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.ui.dropdown').dropdown();
        });
    </script>
<?php
// ****** DISPLAY REFUNDS PAGE
        } else { 
?>
        <div class="ui horizontal menu">
            <a class="item" href="/dashboard.php">
              Entries
            </a>
            <a class="item" href="/dashboard.php?p=charges">
              Charges
            </a>
            <a class="active teal item" href="/dashboard.php?p=refunds">
              Refunds
            </a>
            <a class="item" href="/dashboard.php?p=logout">
              Log Out
            </a>
            <form class="right menu" method="post" action="/dashboard.php?p=refunds">
                <div class="ui dropdown item">
                    <input type="hidden" name="source" value="<?php echo (isset($_POST['source'])) ? $_POST['source'] : ''; ?>">
                    <div class="default text">Source</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">
<?php foreach($chargesources as $v) { ?>
                      <div class="item"><?php echo $v; ?></div>
<?php } ?>
                    </div>
                </div>
                <div class="item">
                    <div class="ui input">
                        <input type="text" name="from" placeholder="From MM/DD/YYYY" value="<?php echo (isset($_POST['from'])) ? $_POST['from'] : ''; ?>">
                    </div>
                </div>
                <div class="item">
                    <div class="ui input">
                        <input type="text" name="to" placeholder="To MM/DD/YYYY" value="<?php echo (isset($_POST['to'])) ? $_POST['to'] : ''; ?>">
                    </div>
                </div>
                <div class="item">
                    <input type="submit" name="filter" value="Filter" class="ui blue submit button">
                </div>
            </form>
        </div>
        <div class="ui one column grid">
            <div class="column" style="overflow-x: auto; overflow-y: auto;">
<?php
            $table = false;
// ****** DISPLAY ALL REFUNDABLE CHARGES
            if(!isset($_POST['filter'])) { 
                $from = time() - 604800;
                $to = time();
                $res = mysql_query("SELECT cu.stripe_customer_id, cu.first_name, cu.last_name, cu.email, cu.stripe_account, ca.stripe_card_id, ca.last4, ca.brand, ch.* FROM charges ch, cards ca, customers cu WHERE ca.id = ch.card_id AND cu.id = ca.customer_id AND ch.created > '".$from."' AND ch.created < '".$to."' AND ch.status = 1 AND ch.amount > 0 ORDER BY ch.created DESC", $db);
                if($res && mysql_num_rows($res) > 0) {
                    $table = true;
                    $th = false;
                    $out = array();
                    $chargestatus = array(
                        '<i class="red attention icon"></i>',
                        '<i class="green ok sign icon"></i>'
                    );
?>
<table class="ui celled table segment nowrap" style="margin: 10px;">
<?php
                    while($row = mysql_fetch_assoc($res)) {
                        $or = array();
                        if(count($out) == 0) {
                            $out[] = array('Date','Status','FirstName','LastName','Email','Refund','Amount','Description','StripeAccount','LastFour','Brand','StripeCustomerID','StripeCardID','StripeChargeID');
                        }
                        $or[] = date('m/d/Y', intval($row['created']));
                        $or[] = $chargestatus[intval($row['status'])];
                        $or[] = $row['first_name'];
                        $or[] = $row['last_name'];
                        $or[] = $row['email'];
                        $or[] = '<div class="item"><form action="/dashboard.php?p=refunds" method="POST">
<input type="hidden" name="ch" value="'.$row['stripe_charge_id'].'" />
<input type="hidden" name="ch_firstname" value="'.$row['first_name'].'" />
<input type="hidden" name="ch_lastname" value="'.$row['last_name'].'" />
<input type="hidden" name="ch_email" value="'.$row['email'].'" />
<input type="hidden" name="ch_amount" value="'.$row['amount'].'" />
<input type="hidden" name="ch_description" value="'.$row['description'].'" />
<input type="hidden" name="ch_account" value="'.$row['stripe_account'].'" />
<input type="hidden" name="ch_last4" value="'.$row['last4'].'" />
<input type="hidden" name="ch_brand" value="'.$row['brand'].'" />
<input type="hidden" name="ch_tag" value="'.$row['tag'].'" />
<input type="hidden" name="ch_card_id" value="'.$row['card_id'].'" />
<input type="submit" name="refund" value="REFUND" class="ui small blue submit button" /></form></div>'; // Refund Button goes here
                        $or[] = "<span style=\"float:right;\">$ ".number_format($row['amount'],2)."</span>";
                        $or[] = $row['description'];
                        $or[] = $row['stripe_account'];
                        $or[] = sprintf('%04d', $row['last4']);
                        $or[] = $row['brand'];
                        $or[] = $row['stripe_customer_id'];
                        $or[] = $row['stripe_card_id'];
                        $or[] = $row['stripe_charge_id'];
                        $out[] = $or;
                    }
                    foreach($out as $r) {
                        if(!$th) {
                            echo "<thead>\n";
                        }
                        echo "<tr>\n";
                        foreach($r as $c) {
                            echo "<td>".$c."</td>\n";
                        }
                        echo "</tr>\n";
                        if(!$th) {
                            echo "</thead>\n<tbody>\n";
                            $th = true;
                        }
                    }
                    echo "</tbody>\n</table>\n";
                }
            }
// ****** DISPLAY FILTERED REFUNDABLE CHARGES
            if(isset($_POST['filter'])) {
                $from = strtotime($_POST['from']);
                $to = strtotime($_POST['to']);
                if(!$from) { $from = time() - 604800; }
                if(!$to) { $to = time(); }
                $sourceset = true;
                if(!$_POST['source'] || !in_array(trim($_POST['source']), $chargesources)) {
                    echo $_POST['source'];
                    $sourceset = false;
                }
                if($sourceset) {
                    $res = mysql_query("SELECT cu.stripe_customer_id, cu.first_name, cu.last_name, cu.email, cu.stripe_account, ca.stripe_card_id, ca.last4, ca.brand, ch.* FROM charges ch, cards ca, customers cu WHERE ca.id = ch.card_id AND cu.id = ca.customer_id AND ch.tag = '".mysql_real_escape_string(trim($_POST['source']))."' AND ch.created > '".$from."' AND ch.created < '".$to."' AND ch.status = 1 AND ch.amount > 0 ORDER BY ch.created DESC", $db);
                } else {
                    $res = mysql_query("SELECT cu.stripe_customer_id, cu.first_name, cu.last_name, cu.email, cu.stripe_account, ca.stripe_card_id, ca.last4, ca.brand, ch.* FROM charges ch, cards ca, customers cu WHERE ca.id = ch.card_id AND cu.id = ca.customer_id AND ch.created > '".$from."' AND ch.created < '".$to."' AND ch.status = 1 AND ch.amount > 0 ORDER BY ch.created DESC", $db);
                }
                if($res && mysql_num_rows($res) > 0) {
                    $table = true;
                    $th = false;
                    $out = array();
                    $chargestatus = array(
                        '<i class="red attention icon"></i>',
                        '<i class="green ok sign icon"></i>'
                    )
?>
<table class="ui celled table segment nowrap" style="margin: 10px;">
<?php
                    while($row = mysql_fetch_assoc($res)) {
                        $or = array();
                        if(count($out) == 0) {
                            $out[] = array('Date','Status','FirstName','LastName','Email','Refund','Amount','Description','StripeAccount','LastFour','Brand','StripeCustomerID','StripeCardID','StripeChargeID');
                        }
                        $or[] = date('m/d/Y', intval($row['created']));
                        $or[] = $chargestatus[intval($row['status'])];
                        $or[] = $row['first_name'];
                        $or[] = $row['last_name'];
                        $or[] = $row['email'];
                        $or[] = '<div class="item"><form action="/dashboard.php?p=refunds" method="POST">
<input type="hidden" name="ch" value="'.$row['stripe_charge_id'].'" />
<input type="hidden" name="ch_firstname" value="'.$row['first_name'].'" />
<input type="hidden" name="ch_lastname" value="'.$row['last_name'].'" />
<input type="hidden" name="ch_email" value="'.$row['email'].'" />
<input type="hidden" name="ch_amount" value="'.$row['amount'].'" />
<input type="hidden" name="ch_description" value="'.$row['description'].'" />
<input type="hidden" name="ch_account" value="'.$row['stripe_account'].'" />
<input type="hidden" name="ch_last4" value="'.$row['last4'].'" />
<input type="hidden" name="ch_brand" value="'.$row['brand'].'" />
<input type="hidden" name="ch_tag" value="'.$row['tag'].'" />
<input type="hidden" name="ch_card_id" value="'.$row['card_id'].'" />
<input type="submit" name="refund" value="REFUND" class="ui small blue submit button" /></form></div>'; // Refund Button goes here
                        $or[] = "<span style=\"float:right;\">$ ".number_format($row['amount'],2)."</span>";
                        $or[] = $row['description'];
                        $or[] = $row['stripe_account'];
                        $or[] = sprintf('%04d', $row['last4']);
                        $or[] = $row['brand'];
                        $or[] = $row['stripe_customer_id'];
                        $or[] = $row['stripe_card_id'];
                        $or[] = $row['stripe_charge_id'];
                        $out[] = $or;
                    }
                    foreach($out as $r) {
                        if(!$th) {
                            echo "<thead>\n";
                        }
                        echo "<tr>\n";
                        foreach($r as $c) {
                            echo "<td>".$c."</td>\n";
                        }
                        echo "</tr>\n";
                        if(!$th) {
                            echo "</thead>\n<tbody>\n";
                            $th = true;
                        }
                    }
                    echo "</tbody>\n</table>\n";
                }
            }
            if(!$table) {
?>
<div class="ui segment" style="margin: 10px;"><h1>No Results</h1></div>
<?php
            }
?>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.ui.dropdown').dropdown();
        });
    </script>
<?php   }
// ****** ENTRIES TAB
    } else { ?>
        <div class="ui horizontal menu">
            <a class="active teal item" href="/dashboard.php">
              Entries
            </a>
            <a class="item" href="/dashboard.php?p=charges">
              Charges
            </a>
            <a class="item" href="/dashboard.php?p=refunds">
              Refunds
            </a>
            <a class="item" href="/dashboard.php?p=logout">
              Log Out
            </a>
            <form class="right menu" method="post" action="/dashboard.php">
                <div class="ui dropdown item">
                    <input type="hidden" name="source" value="<?php echo (isset($_POST['source'])) ? $_POST['source'] : ''; ?>">
                    <div class="default text">Source</div>
                    <i class="dropdown icon"></i>
                    <div class="menu">
<?php foreach($sources as $k => $v) { ?>
                      <div class="item">
                        <i class="dropdown icon"></i>
                        <?php echo $k; ?>
                        <div class="menu">
<?php foreach($v as $s) { ?>
                          <div class="item"><?php echo $s; ?></div>
<?php } ?>
                        </div>
                      </div>
<?php } ?>
                    </div>
                </div>
                <div class="item">
                    <div class="ui input">
                        <input type="text" name="from" placeholder="From MM/DD/YYYY" value="<?php echo (isset($_POST['from'])) ? $_POST['from'] : ''; ?>">
                    </div>
                </div>
                <div class="item">
                    <div class="ui input">
                        <input type="text" name="to" placeholder="To MM/DD/YYYY" value="<?php echo (isset($_POST['to'])) ? $_POST['to'] : ''; ?>">
                    </div>
                </div>
                <div class="item">
                    <input type="submit" name="filter" value="Filter" class="ui blue submit button">
                </div>
                <div class="item">
                    <input type="submit" name="export" value="Export" class="ui blue submit button">
                </div>
            </form>
        </div>
        <div class="ui one column grid">
            <div class="column" style="overflow-x: auto; overflow-y: auto;">
<?php
        $table = false;
// ****** DISPLAY ALL ENTRIES
        if(!isset($_POST['filter'])) { //start All Entries addition
        	$from = time() - 604800;
        	$to = time();
        	$res = mysql_query("SELECT cu.stripe_customer_id, cu.first_name, cu.last_name, cu.email, cu.stripe_account, ca.stripe_card_id, ca.last4, ca.brand, ca.exp_month, ca.exp_year, e.*, m.data, m.source, m.created AS date FROM entries_meta m, entries e, cards ca, customers cu WHERE e.id = m.entry_id AND cu.id = e.customer_id AND ca.id = e.card_id AND m.created > '".$from."' AND m.created < '".$to."' ORDER BY m.created DESC", $db);
        	// added stripe_account
        	if($res && mysql_num_rows($res) > 0) {
        		$table = true;
        		$th = false;
        		$out = array();
?>
<table class="ui celled table segment nowrap" style="margin: 10px;"> <!--added celled-->
<?php
        		while($row = mysql_fetch_assoc($res)) {
        			$or = array();
        			$meta = unserialize($row['data']);
        			if(count($out) == 0) {
        				$oh = array('Date','FirstName','LastName','Email','StripeAccount','StripeCustomerID','StripeCardID','StripeCardBrand','StripeCardLastFour','ExpMonth','ExpYear','Source','Form');
        				// added StripeAccount, Source (which is actually 'tag'; Form is 'source')
        				$out[] = $oh;
        			}
        			$or[] = date('m/d/Y', intval($row['date']));
        			$or[] = $row['first_name'];
        			$or[] = $row['last_name'];
        			$or[] = $row['email'];
        			$or[] = $row['stripe_account'];
        			// added stripe_account
        			$or[] = $row['stripe_customer_id'];
        			$or[] = $row['stripe_card_id'];
        			$or[] = $row['brand'];
        			$or[] = sprintf('%04d',$row['last4']);
        			$or[] = sprintf('%02d', $row['exp_month']);
        			$or[] = sprintf('%04d',$row['exp_year']);
                    $or[] = $row['tag'];
                    // added tag
        			$or[] = $row['source'];
        			$out[] = $or;
        		}
        		foreach($out as $r) {
        			if(!$th) {
        				echo "<thead>\n";
        			}
        			echo "<tr>\n";
        			foreach($r as $c) {
        				echo "<td>".$c."</td>\n";
        			}
        			echo "</tr>\n";
        			if(!$th) {
        				echo "</thead>\n<tbody>\n";
        				$th = true;
        			}
        		}
        		echo "</tbody>\n</table>\n";
        	}
        } //end All Entries addition
// ****** DISPLAY FILTERED ENTRIES
        if(isset($_POST['filter'])) {
            $from = strtotime($_POST['from']);
            $to = strtotime($_POST['to']);
            if(!$from) { $from = time() - 604800; }
            if(!$to) { $to = time(); }
            $sourceset = true;
            if(!$_POST['source'] || !in_array($_POST['source'], $validsources)) {
                $sourceset = false;
            }
            if($sourceset) {
                $res = mysql_query("SELECT cu.stripe_customer_id, cu.first_name, cu.last_name, cu.email, cu.stripe_account, ca.stripe_card_id, ca.last4, ca.brand, ca.exp_month, ca.exp_year, e.*, m.data FROM entries_meta m, entries e, cards ca, customers cu WHERE e.id = m.entry_id AND cu.id = e.customer_id AND ca.id = e.card_id AND m.source = '".mysql_real_escape_string($_POST['source'])."' AND m.created > '".$from."' AND m.created < '".$to."' ORDER BY m.created DESC", $db);
                //added exp_month & exp_year
        		//added stripe_account
        	} else {
                $res = mysql_query("SELECT cu.stripe_customer_id, cu.first_name, cu.last_name, cu.email, cu.stripe_account, ca.stripe_card_id, ca.last4, ca.brand, ca.exp_month, ca.exp_year, e.*, m.data, m.source FROM entries_meta m, entries e, cards ca, customers cu WHERE e.id = m.entry_id AND cu.id = e.customer_id AND ca.id = e.card_id AND m.created > '".$from."' AND m.created < '".$to."' ORDER BY m.created DESC", $db);
        		//added stripe_account
        	}
        	if($res && mysql_num_rows($res) > 0) {
        		$table = true;
        		$th = false;
        		$out = array();
?>
<table class="ui celled table segment nowrap" style="margin: 10px;"> <!--added celled-->
<?php
        		while($row = mysql_fetch_assoc($res)) {
        			$or = array();
        			$meta = unserialize($row['data']);
        			if(count($out) == 0) {
        				$oh = array('Date','FirstName','LastName','Email','StripeAccount','StripeCustomerID','StripeCardID','StripeCardBrand','StripeCardLastFour','ExpMonth','ExpYear');
        				// added StripeAccount
        				if($sourceset) {
        					$out[] = array_merge($oh, array_keys($meta));
        				} else {
                            $oh[] = 'Form';
        					$out[] = $oh;
        				}
        			}
        			//added exp_month & exp_year
        			$or[] = date('m/d/Y', intval($row['created']));
        			$or[] = $row['first_name'];
        			$or[] = $row['last_name'];
        			$or[] = $row['email'];
        			$or[] = $row['stripe_account'];
        			// added stripe_account
        			$or[] = $row['stripe_customer_id'];
        			$or[] = $row['stripe_card_id'];
        			$or[] = $row['brand'];
        			$or[] = sprintf('%04d',$row['last4']);
        			$or[] = sprintf('%02d', $row['exp_month']);
        			$or[] = sprintf('%04d',$row['exp_year']);
        			//added exp_month & exp_year
        			if($sourceset) {
        				$out[] = array_merge($or, array_values($meta));
        			} else {
                        $or[] = $row['source'];
        				$out[] = $or;
        			}
        		}
        		foreach($out as $r) {
        			if(!$th) {
        				echo "<thead>\n";
        			}
        			echo "<tr>\n";
        			foreach($r as $c) {
        				echo "<td>".nl2br($c)."</td>\n"; // added nl2br function to show inputted line breaks
        			}
        			echo "</tr>\n";
        			if(!$th) {
        				echo "</thead>\n<tbody>\n";
        				$th = true;
        			}
        		}
        		echo "</tbody>\n</table>\n";
        	}
        }
        if(!$table) {
?>
<div class="ui segment" style="margin: 10px;"><h1>No Results</h1></div>
<?php
        }
?>

            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.ui.dropdown').dropdown();
        });
    </script>
<?php
    }
// ****** DISPLAY LOG-IN PAGE
} else {
?>
<div class="main container">
    <div class="ui one column stackable page grid">
        <div class="column">
            <form method="post" action="/dashboard.php" class="ui form relaxed segment">
                <input type="hidden" name="login" value="true">
                <div class="field">
                    <label>Username</label>
                    <div class="ui left labeled icon input">
                      <input type="text" placeholder="Username" name="username">
                      <i class="user icon"></i>
                    </div>
                </div>
                <div class="field">
                    <label>Password</label>
                    <div class="ui left labeled icon input">
                      <input type="password" name="password">
                      <i class="lock icon"></i>
                    </div>
                </div>
                <div class="ui error message">
                    <div class="header">We noticed some issues</div>
                </div>
                <button class="ui blue submit button">Login</button>
<?php
	if(isset($_POST['login'])) { echo '<div class="ui negative message">Username or Password is incorrect.</div>'; }
?>
            </form>
        </div>
    </div>
</div>
<?php
}
?>
</body>
</html>
