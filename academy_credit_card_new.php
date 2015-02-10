<?php
include_once(dirname(__FILE__).'/lib/Form.php');


$config['template'] = 'Academy';
$config['title'] = 'Academy Credit Card Submission';
$config['button label'] = 'Submit';
$config['tag'] = 'other';
$config['action'] = 'create';
$config['stripe account'] = 'academy';

Form::header();
?>
<div id="top">
    <h1>Submit a New Credit Card to Academy of Chiropractic Family Practice</h1>
    <br/>
    <p><span class="required">*</span> - Required information</p>
    <h3>Personal Information </h3>
    <table border="0" cellpadding="5" cellspacing="5" width="480">
		<tr>
		    <td width="210"><span class="required">*</span> First Name:</td>
		    <td width="430"><input type="text" size="35" name="FirstName" required /></td>
		</tr>
		<tr>
		    <td><span class="required">*</span> Last Name:</td>
		    <td><input type="text" size="35" name="LastName" required /></td>
		</tr>
		<tr>
			<td>Reason or Other Information (optional):</td>
			<td><input type="text" size="35" name="Memo" /></td>
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
