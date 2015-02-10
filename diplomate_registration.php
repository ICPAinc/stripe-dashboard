<?php
include_once(dirname(__FILE__).'/lib/Form.php');


$config['template'] = 'ICPA';
$config['title'] = 'ICPA Diplomate Registration Form';
$config['button label'] = 'Enroll';
$config['tag'] = 'diplomate';
$config['action'] = 'create';
$config['stripe account'] = 'icpa';

Form::header();
?>
<div id="top">
    <h1>ICPA Diplomate Program Enrollment</h1>
          <p>You can enroll at any time during the certification program.</p>
          <p><strong>ICPA Diplomate Program Fee - $100</strong></p>
<p><span class="required">*</span> - Required information</p>
<?php
Form::section('tableheader','581');
Form::section('contactinfo');
?>
						  <tr>
								<td colspan="2">
                  <span class="required">* </span><strong>To All Diplomate Candidates:</strong><br />
                  Please write a brief essay as to why you are looking to pursue Diplomate status.
                </td>
							</tr>
							<tr>
							  <td colspan="2">
                  <textarea rows="10" cols="70" wrap="hard" name="EssayResponse" required></textarea>
                </td>
						  </tr>
              <tr>
                <td colspan="2">
                  <br />
                  <span class="required">* </span><strong>ICPA Diplomate Agreement:</strong>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <input type="hidden" name="DiplomateTerms" value="NoAgree" />
                  <input type="checkbox" name="DiplomateTerms" value="Agreed" required />
                  By checking this box, I am confirming that I agree to the Diplomate Terms. Please read Diplomate terms here:
                  <a href="http://www.icpa4kids.com/ICPA_DiplomateTerms.htm" target="_blank">ICPA Diplomate Program</a><br />
                </td>
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
