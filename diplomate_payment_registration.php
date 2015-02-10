<?php
include_once(dirname(__FILE__).'/lib/Form.php');


$config['template'] = 'ICPA';
$config['title'] = 'ICPA Diplomate Payment Registration Form';
$config['button label'] = 'Register for Payment';
$config['tag'] = 'diplomate';
$config['action'] = 'create';
$config['stripe account'] = 'icpa';

Form::header();
?>
<div id="top">
    <h1>ICPA Diplomate Program Payment</h1>
          <p>Pay in Full (PIF) option: $2780</p>
          <p>Auto Payment option: $3000 (three payments of $1000 each)</p>
<p><span class="required">*</span> - Required information</p>
<?php
Form::section('tableheader','581');
Form::section('contactinfo');
?>
						  <tr>
								<td>
                  <span class="required">* </span>Please choose Payment Program:<br />
                </td>
                <td>
                  <select name="PaymentProgram" required>
                    <option selected="selected"></option>
                    <option value="Pay in Full - $2780">Pay in Full (PIF) - $2,780</option>
                    <option value="Auto Pay - 3 x $1000">Auto Payment - 3 payments of $1,000</option>
                  </select>
							</tr>
              <tr>
                <td colspan="2" align="center">
                  <br />
                  <a href="http://www.icpa4kids.com/ICPA_DiplomateTerms.htm" target="_blank">ICPA Diplomate Program Terms</a>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <input type="hidden" name="DiplomateTerms" value="NoAgree" />
                  <span class="required">* </span>
                  <input type="checkbox" name="DiplomateTerms" value="Agreed" required />
                  By checking this box, I am confirming that I have read and agree to the ICPA Diplomate Program Terms<br />
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
