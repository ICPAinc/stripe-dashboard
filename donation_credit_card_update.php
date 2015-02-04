<?php
include_once(dirname(__FILE__).'/lib/Form.php');


$config['template'] = 'ICPA';
$config['title'] = 'Donation Credit Card Update Form';
$config['button label'] = 'Submit';
$config['tag'] = 'donation';
$config['action'] = 'update';

Form::header();
?>
<div id="top">
    <h1>ICPA Donation Credit Card Update Form</h1>
    <br/>
    <p><span class="required">*</span> - Required information</p>
    <h3>Personal Information </h3>
    <table border="0" cellpadding="5" cellspacing="5" width="675">
	<tr>
	    <td width="210"><span class="required">*</span> First Name:</td>
	    <td width="430"><input type="text" size="35" name="FirstName" required /></td>
	</tr>
	<tr>
	    <td><span class="required">*</span> Last Name:</td>
	    <td><input type="text" size="35" name="LastName" required /></td>
	</tr>
      </table>
    <div align="center">
<?php
Form::section('stripe');
?>
    </div>
    <div>
        <a href="http://www.icpa4kids.com/ICPAMembershipReturn.htm">Refund Policy</a>
    </div>
</div>
<?php
Form::footer();
?>