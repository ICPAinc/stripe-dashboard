<?php
include_once(dirname(__FILE__).'/lib/Form.php');


$config['template'] = 'ICPA';
$config['title'] = 'ICPA Membership Application';
$config['button label'] = 'Join Us';
$config['tag'] = 'membership';
$config['action'] = 'create';
$config['stripe account'] = 'icpa';
//$config['email_to'] = ''; // set if you need to override default notification email in lib/setup.php

Form::header();
?>
<div id="top">
    <h1>ICPA Membership Application Form </h1>
        <p>The ICPA has been and continues to be committed to bringing chiropractic
          care for pregnant mothers and children to a whole
          new level. Your continued membership makes this
          happen.</p>
        <p> <a href="http://www.icpa4kids.com/membership/" target="_blank"><strong>View all of our membership benefits here</strong></a></p>
        <p>Please use this secure online registration
          form. <strong>You may also join as a member on the <a href="seminar_registration.php">seminar registration form</a>.</strong> The address provided below will be used to mail your issues of Pathways
          Magazine and will be the City, State/Province,
          Zip/Postal Code, and Telephone Number used in our
	  online family chiropractor locator.</p>
        <p><strong>Investment:</strong></p>
        <table align="center" border="1" width="90%">
            <tbody>
                <tr>
                    <th width="29%">D.C.</th>
                    <td align="center" width="44%">$279</td>
                </tr>
                <tr>
                    <th>First/Second Year D.C. (years in practice)</th>
                    <td align="center">$179</td>
                </tr>
                <tr>
                    <th>Associate D.C. (Primary D.C. in the office is an ICPA member)</th>
                    <td align="center">$179</td>
                </tr>
                <tr>
                    <th>Non-Practicing D.C.</th>
                    <td align="center">$179</td>
                </tr>
                <tr>
                    <th>Faculty Member D.C.</th>
                    <td align="center">$179</td>
                </tr>
                <tr>
                    <th>Married Couple D.C.</th>
                    <td align="center">$329</td>
                </tr>
                <tr>
                    <th height="18">First Yr D.C.  Married Couple</th>
                    <td align="center">$229</td>
                </tr>
                <tr>
                    <th height="18">Student </th>
                    <td align="center">$129</td>
                </tr>
                <tr>
                    <th height="15">Student Married Couple</th>
                    <td align="center">$179</td>
                </tr>
            </tbody>
        </table>
        <p><br></p>
<?php
Form::section('autorenew');
?>
<p><span class="required">*</span> - Required information</p>
<p><strong>Please note: </strong>All ICPA members will receive a free print and free digital subscription to <em>Pathways </em>magazine. <em>Digital content will be emailed a few weeks ahead of the print magazine</em>.</p>
<br>
<?php
Form::section('tableheader','584');
Form::section('contactinfo','Your cell phone number will be kept private and will not appear on your directory listing.','required');
?>
        <tr>
            <td><em>Married Couple</em> - First Name:</td>
            <td><input size="35" name="MCFirstName" type="text"></td>
        </tr>
        <tr>
            <td><em>Married Couple</em> - Last Name:</td>
            <td><input size="35" name="MCLastName" type="text"></td>
        </tr>
        <tr>
            <td><em>Married Couple </em>- Suffix:</td>
            <td><input size="35" name="MCSuffix" type="text"></td>
        </tr>
        <tr>
            <td colspan="2"><br><hr><br></td>
        </tr>
         <tr>
            <td><span class="required">* </span>DC or Student:</td>
            <td>
                <select name="Type" required>
                    <option selected="selected"></option>
                    <option value="DC">DC</option>
                    <option value="Student">Student</option>
                </select>
            </td>
        </tr>
        <tr>
            <td><span class="required">* </span>Chiropractic College:</td>
            <td><input size="35" name="Chiropractic College" type="text" required></td>
        </tr>
        <tr>
            <td><span class="required">* </span>Month and Year of Graduation:</td>
            <td><input size="35" name="Graduation Year" type="text" required></td>
        </tr>
        <tr>
            <td colspan="2"><br><hr><br></td>
        </tr>
        <tr>
            <td>Change of Address:</td>
            <td>Yes - <input name="ChangeAddress" value="NoChange" type="hidden">
                      <input name="ChangeAddress" value="ChangeAddress" type="checkbox"></td>
        </tr>
        <tr>
            <td>Change of Name:</td>
            <td>Yes - <input name="ChangeName" value="NoChange" type="hidden">
                      <input name="ChangeName" value="ChangeName" type="checkbox">
                &nbsp;&nbsp;&nbsp; Old Name: 
                <input size="35" name="OldName" type="text">
            </td>
        </tr>
        <tr>
            <td>Webster Technique Certified: </td>
            <td>
                <label>
                    <select name="Webster Certified">
                        <option selected="selected"></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="2"><br><hr><br></td>
        </tr>
<?php
Form::section('shippinginfo');
Form::section('membershipinfo');
?>
            <tr>
                <td colspan="2">
                    <p>By clicking "<?php echo $config['button label'] ?>" below I agree to the following:</p>
                    <p>For DC status:</p>
                    <ol>
                        <li>I have a degree from an accredited chiropractic college and or I am licensed/recognized to practice chiropractic.</li>
                        <li>I have current malpractice insurance if required by my country. </li>
                        <li>I agree to keep my mailing and e-mail address current with the ICPA for important alerts and updates. </li>
                        <li>If my address changes and I do not notify ICPA, I will be responsible to pay for delivery of my missed Pathways issue.</li>
                        <li>I realize I will be signed up to the ICPA/PedEx 
                        newsletter which keeps meinformed about ICPA activities, projects 
                        related to the mission. If I choose not to be subscribed to PedEx, I 
                        have the ability to opt out.</li>
                    </ol>
                    <p>For Students:</p>
                    <ol>
                        <li>I am actively attending an accredited chiropractic college.</li>
                        <li>I agree to keep my mailing and e-mail address current with the
                        ICPA for important alerts and updates. </li>
                        <li>If my address changes and I do not notify ICPA, I will be responsible to pay for delivery of my missed Pathways issue.</li>
                        <li>I realize I will be signed up to the ICPA/PedEx 
                        newsletter which keeps meinformed about ICPA activities, projects 
                        related to the mission. If I choose not to be subscribed to PedEx, I 
                        have the ability to opt out.</li>
                    </ol>
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