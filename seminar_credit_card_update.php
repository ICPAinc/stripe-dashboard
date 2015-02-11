<?php
include_once(dirname(__FILE__).'/lib/Form.php');


$config['template'] = 'ICPA';
$config['title'] = 'Seminar Credit Card Update Form';
$config['button label'] = 'Submit';
$config['tag'] = 'seminar';
$config['action'] = 'update';
$config['stripe account'] = 'icpa';
//$config['email_to'] = ''; // set if you need to override default notification email in lib/setup.php

$first = '';
$last = '';
if(isset($_GET['first']) && isset($_GET['last'])) {
    $first = $_GET['first'];
    $last = $_GET['last'];
}

Form::header();
?>
<div id="top">
    <h1>ICPA Seminar Credit Card Update Form</h1>
    <br/>
    <p><span class="required">*</span> - Required information</p>
    <h3>Personal Information </h3>
    <table border="0" cellpadding="5" cellspacing="5" width="480">
    	<tr>
    	    <td width="210"><span class="required">*</span> First Name:</td>
    	    <td width="430"><input type="text" size="35" name="FirstName" value="<?php echo $first; ?>" required /></td>
    	</tr>
    	<tr>
    	    <td><span class="required">*</span> Last Name:</td>
    	    <td><input type="text" size="35" name="LastName" value="<?php echo $last; ?>" required /></td>
    	</tr>
    </table>
    <div align="center">
<?php
Form::section('stripe');
?>
    </div>
</div>
<?php
Form::footer();
?>
