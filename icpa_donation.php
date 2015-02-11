<?php
include_once(dirname(__FILE__).'/lib/Form.php');


$config['template'] = 'ICPA';
$config['title'] = 'ICPA Donation Form';
$config['button label'] = 'Donate';
$config['tag'] = 'donation';
$config['action'] = 'create';
$config['stripe account'] = 'icpa';
//$config['email_to'] = ''; // set if you need to override default notification email in lib/setup.php

Form::header();
?>
<div id="top">
    
					<h1>ICPA Donation Form </h1>
						<br/>
							<p>The ICPA has been and continues to be committed to bringing chiropractic
							  care for pregnant mothers and children to a whole
							  new level. Your support and donations allow this
							  to continue.</p>
				  <p>The ICPA is a 501(c)3 Organization. All donations to the ICPA are tax deductible.</p>                                                        
                            <p>&nbsp;</p>
				  <p><span class="required">*</span> - Required information</p>
<?php
Form::section('tableheader','675');
Form::section('contactinfo');
?>
							<tr>
								<td>Chiropractic College:</td>
								<td><input type="text" size="35" name="Chiropractic College" /></td>
							</tr>
							<tr>
								<td>Year of Graduation:</td>
								<td><input type="text" size="35" name="Graduation Year" /></td>
                                </tr>
                                <tr><td>In memoriam of:</td>
								<td><input type="text" size="35" name="In memoriam of" /></td>
							</tr>
							<tr>
							  <td colspan="2"><br /><hr /><br /></td>
							</tr>
							<tr>
							  <td colspan="2"> <h1><strong><a name="ICPAOnlineDonationForm" id="ICPAOnlineDonationForm"></a> </strong>ICPA Online Donation Form:</h1></td>
							</tr>
							<tr>
								<td valign="top"><span class="required">*</span>Donation Amount:<br/>
								Amount in US Dollars</td>
							    <td><p>
							    <label>
							      <input type="radio" name="DonationAmount" value="50" required />
							      $50.00</label>
							    <br />
							    <label>
							      <input type="radio" name="DonationAmount" value="100" />
							      $100.00</label>
							    <br />
							    <label>
							      <input type="radio" name="DonationAmount" value="200" />
							      $200.00</label>
							    <br />
							    <label>
							      <input type="radio" name="DonationAmount" value="500" />
							      $500.00</label>
							    <br />
							    <label>
							      <input type="radio" name="DonationAmount" value="other" />
							      other $ </label>
							    <input name="OtherDonationAmount" type="text" size="7" />
							  </p>							    </td>
							</tr>
								  <td><input name="DonationType" type="radio" value="One-time" checked="checked" /> I want to make a one-time donation.</td>
						          <td>							</td>
							</tr>							
							<tr>
								<td><input type="radio" name="DonationType" value="Automatic" /> I want to make a recurring donation every</td>
							  <td>
							  <select name="DonationRecurrance">
							  	<option></option>
                                <option value="Monthly">Month</option>
                                <option value="Three Months">Three Months</option>
                                <option value="Annually">Year</option>
                              </select>							  </td>
							</tr>
							<tr>
								<td><span class="required">*</span>Donation Purpose:</td>
							  <td><select name="DonationPurpose" required>
                                <option></option>
                                <option value="Research">ICPA Research</option>
                                <option value="Advertising">National Advertising</option>
                                <option value="In Memoriam">In Memoriam</option>
                              </select></td>
                           
							</tr>
							<tr>
							  <td colspan="2"><br /><hr /><br /></td>
							</tr>
<?php
Form::section('tablefooter');
?>
    <div align="center">
<?php
Form::section('stripe');
?>
    </div>
    <div>
        <a href="http://www.icpa4kids.com/ICPAMembershipReturn.htm" target="_blank">Refund Policy</a>
    </div>
</div>
<?php
Form::footer();
?>
