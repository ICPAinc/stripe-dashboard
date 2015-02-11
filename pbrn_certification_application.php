<?php
include_once(dirname(__FILE__).'/lib/Form.php');


$config['template'] = 'ICPA';
$config['title'] = 'ICPA PBRN For Certification Registration';
$config['button label'] = 'Submit';
$config['tag'] = 'pbrn';
$config['action'] = 'create';
$config['stripe account'] = 'icpa';
//$config['email_to'] = ''; // set if you need to override default notification email in lib/setup.php

Form::header();
?>
<div id="top">
    <h1>ICPA PBRN For Certification Registration</h1>
						<br/>
							<p>The ICPA has been and continues to be committed to family chiropractic
						    research. We are leading the profession in the evidenced
							  based research for our practices. Your PBRN participation
							  is what makes this possible. You are supporting
							  the chiropractic research that substantiates the
							  care you want to offer.  </p>
		              <p><strong>For PBRN Participation for Certification and Full credit:</strong> ICPA membership must be current. If your membership
                  is not current please renew with us below.<br/>
                  </p>
<?php
Form::section('tableheader','700');
Form::section('contactinfo');
?>
							<tr>
							  <td colspan="2"><h2><strong>Registration:</strong></h2></td>
							</tr>
							<tr>
							  <td><p><strong>Registration for Certification Credit:</strong></p>
						      <p>If you are enrolled in the auto-payment and have been paying $329 per seminar module, your registration to the PBRN would be considered your 15th and 16th module.</p></td>
                              <td><select name="PBRNRegistration" >
                                <option  selected="selected">------ For Certification Candidates
                                  -----</option>
                                <option value=" Research PBRN Module I - DC - $329"> Research PBRN
                                  Module I- DC - $329</option>
                                  <option value=" Research PBRN Module II - DC - $329"> Research PBRN
                                  Module II- DC - $329</option>
                                  <option value=" Research PBRN Module I &amp; II - DC - $658"> Research PBRN Module I &amp; II- DC - $658</option>
                          
                              </select>                                </h2>							    </td>
							</tr>
							<tr>
								<td valign="top"><p><strong>Want to contribute more? 
							  </strong></p></td>
							    <td valign="top">
							      <p>Yes - 
							        <input type="hidden" name="PBRNBenefits" value=" " />
							        <input type="checkbox" name="PBRNBenefits" value="$250" />
						      </p>
						      <p><em>Please visit this <a href="icpa_donation.php" target="_blank">link</a> after the completion of your </em></p>
						      <p><em>PBRN for certification form.</em></p></td>
							</tr>
                            <tr>
                            	<td colspan="2"><strong>Additonal Contribution Benefits</strong><br />
<ul>
           	    <li>                            	    Your patients will see the commitment you have in ensuring safe and effective
                            	    care for their families.</li>
                            	  <li>                            	    You will receive a certificate for your office to display
                            	    your Distinguished Participation. </li>
                            	  <li> You will receive an ICPA/ PBRN Distinguished Participant logo for your web site.</li>
                   	          </ul></td>
                          </tr>
							<tr>
						      <td><strong>Also become an ICPA Member:</strong></td>
							  <td><select name="MembershipType" >
                                <option>Join or Renew the ICPA</option>
                                <option value="ICPA DC Membership - $229">ICPA DC Membership - $229</option>
                                <option value="ICPA First Year DC Membership - $129">ICPA First-Year DC Membership - $129</option>
                              </select></td>
							</tr>
							<tr>
								<td colspan="2" align="center"><p>Unsure if you are a member or not? Cllick <a href="http://icpa4kids.org/memberstatus/" target="_blank">Here</a> to check your membership status.</br>
                                  <p>To find out when your ICPA membership expires, please <em>click on your name in blue.</em></br>
					          </td>
							</tr>
							<tr>
							  <td colspan="2"><br><hr><br></td>
							</tr>
							<tr>
							  <td colspan="2"><br/>
							  <p>By clicking &quot;Submit Form&quot; below I agree to the
							      following:</p>
							<p>For DC status:</p>
							<ol>
								<li>I have a degree from an accredited chiropractic college and or I am licensed/recognized to practice chiropractic.</li>
								<li>I have current malpractice insurance if required by my state or country. </li>
							</ol></td>
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
