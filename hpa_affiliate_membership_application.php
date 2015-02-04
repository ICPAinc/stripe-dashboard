<?php
include_once(dirname(__FILE__).'/lib/Form.php');


$config['template'] = 'HPA';
$config['title'] = 'HPA Affiliate Membership Application';
$config['button label'] = 'Join Us';
$config['tag'] = 'membership';
$config['action'] = 'create';
$config['stripe account'] = 'hpa';

Form::header();
?>
<div id="top">
    <div>
        <h1>HPA Affiliate Membership Application </h1>
        <p>If you are NOT an ICPA member, please use the standard membership application <a href="hpa_membership_application.php">HERE</a></p>
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
								<td><span class="required">*</span> Join HPA as an ICPA Affiliate:</td>
								<td><select name="ICPAAffiliate" required>
										<option selected="selected"></option>
										<option value="Yes">Yes - $19</option>
										<option value="No">No</option>
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
								<td><span class="required">*</span> Current ICPA Member:</td>
							  <td><select name="ICPAMember" required>
										<option selected="selected"></option>
										<option value="Yes">Yes</option>
										<option value="No - Renew - $229">No - Renew - $229</option>
		                        </select></td>
							</tr>
							<tr>
								<td colspan="2">Unsure about your membership status? <a href="http://icpa4kids.org/memberstatus/" target="_blank">Check here</a></td>
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