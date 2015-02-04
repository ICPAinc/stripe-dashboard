<?php
include_once(dirname(__FILE__).'/lib/Form.php');


$config['template'] = 'HPA';
$config['title'] = 'HPA Membership Application';
$config['button label'] = 'Join Us';
$config['tag'] = 'membership';
$config['action'] = 'create';
$config['stripe account'] = 'hpa';

Form::header();
?>
<div id="top">
    <div>
        <h1>HPA Membership Application </h1>
        <p>ICPA Members: Please use the Affiliate Membership application <a href="hpa_affiliate_membership_application.php">HERE</a></p>
		<p><span class="required">*</span> - Required information</p>
	  </div>
<br>
<?php
Form::section('tableheader','642');
Form::section('contactinfo');
Form::section('shippinginfo');
?>
            				<tr>
							  <td colspan="2"><h3>Membership Information</h3></td>
							</tr>
							<tr>
								<td><span class="required">*</span> Select Your Membership Type:</td>
								<td><select name="MembershipType" required>
										<option selected="selected"></option>
										<option value="Licensed Practitioner- $79">Licensed Practitioner- $79</option>
										<option value="Non-licensed Practitioner - $39">Non-licensed Practitioner - $39</option>
										<option value="Student - $19">Student - $19</option>
			                      </select>								  </td>
							</tr>
							<tr>
								<td>Automatic Membership Renewal:</td>
							  <td>
							    <input type="hidden" name="AutomaticRenewal" value="NoAutoRenew" />
							    <input type="checkbox" name="AutomaticRenewal" value="AutomaticRenewal" />							  </td>
							</tr>
							<tr>
								<td colspan="2">I give the HPA permission to charge my
								  card annually upon my membership expiration<br/><br/>								  </td>
							</tr>
							<tr>
								<td><span class="required">*</span> Primary Practice Specialty:</td>
								<td><?php Form::section('hpaspecialties','','required'); ?></td>
							</tr>
							<tr>
								<td>Additional Practice Specialty:</td>
							    <td><?php Form::section('hpaspecialties','2'); ?> Additional Specialty Listing $10</td>
							</tr>
							<tr>
								<td>Additional Practice Specialty:</td>
								<td><?php Form::section('hpaspecialties','3'); ?> Additional Specialty  Listing $10</td>
							</tr>
							<tr>
								<td>Additional Practice Specialty:</td>
								<td><?php Form::section('hpaspecialties','4'); ?> Additional Specialty  Listing $10</td>
							</tr>
							<tr>
								<td>Additional Practice Specialty:</td>
								<td><?php Form::section('hpaspecialties','5'); ?> Additional Specialty Listing  $10</td>
							</tr>
							
							<tr>
								<td><span class="required">*</span> Where did you first hear about us:</td>
								<td><select name="MembershipReferral" required>
								<option selected="selected"></option>
                               	<option value="Pathways Magazine">Pathways Magazine</option>
                               	<option value="Pathways Connect Group">Pathways Connect Group</option>
								<option value="From Another Member">From Another Member</option>
								<option value="Promotional Flyer">Promotional Flyer</option>
								<option value="E-Mail Promotion">E-Mail Promotion</option>
							  	<option value="Other">Other</option>
							  </select>							  </td>
							</tr>
                            <tr><td>If Other, please tell us more:</td>
								<td><input type="text" size="35" name="OtherReferral" /></td></tr>
<?php
Form::section('tablefooter');
?>
    <div align="center">
<?php
Form::section('stripe');
?>
    </div>
</div>
<?php
Form::footer();
?>