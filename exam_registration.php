<?php
include_once(dirname(__FILE__).'/lib/Form.php');


$config['template'] = 'Academy';
$config['title'] = 'ICPA Exam Registration';
$config['button label'] = 'Register for Exam';
$config['tag'] = 'exam';
$config['action'] = 'create';
$config['stripe account'] = 'academy';
//$config['email_to'] = ''; // set if you need to override default notification email in lib/setup.php

Form::header();
?>
<div id="top">
    <h1>Pediatric Certification Exam Registration Form</h1>
						<br/>
						<p><span class="required">*</span> - Required information</p>
<?php
Form::section('tableheader','480');
Form::section('contactinfo');
?>
							<tr>
								<td><span class="required">*</span>Chiropractic College:</td>
								<td><input type="text" size="35" name="ChiropracticCollege" required /></td>
							</tr>
							<tr>
								<td><span class="required">*</span>Year of Graduation:</td>
								<td><input type="text" size="35" name="GraduationYear" required /></td>
							</tr>
							<tr>
							  <td colspan="2"> </td>
							</tr>
							<tr>
							  <td colspan="2"><h3>Exam Registration </h3></td>
							</tr>
							<tr>
								<td><span class="required">* </span>Primary Seminar Location :</td>
								<td><input type="text" size="35" name="PrimaryLocation" required /></td>
							</tr>
							<tr>
								<td><span class="required">*</span> Certification Hours:</td>
								<td><select name="CertificationTest" required>
								<option selected="selected"></option>
								<option value="Pediatric Certification - $250"> Pediatric Certification - $250</option>
							  </select>							  
							  </td>
							</tr>
								<tr>
									<td colspan="2">
									  <div align="center"><a href="http://www.icpa4kids.com/ICPATerms.htm#Certification" target="_blank">The
									      ICPA Agreement for Certification </a><br/>
									    By checking this box, I am confirming that I have read and I agree
									    to the ICPA Agreement for Certification:
										  <input name="ICPAAgreement" type="hidden" value="NoAgree">
										  <input name="ICPAAgreement" type="checkbox" value="ICPAAgreement" required>
										<span class="required">*</span>
									  </div></td>
								</tr>
								<tr>
								  <td colspan="2"><div>
<h1><strong>Agreement of Ethical and Professional Standards:</strong></h1>
									  <p>By checking this box, I am agreeing to register for the ICPA CACCP Exam. I am agreeing that the contents of this exam, both questions and  answers will remain confidential and not be shared with any other  person, nor will I maintain a copy of the exam once I have completed  and submitted the exam to the ICPA for grading. I am also acknowledging  that all answers on this exam are my own, original work. Any  content that is not original, taken from another author or the internet  without specific reference to source will be considered ineligible and  considered plagiarism. If I choose to use information from the ICPA instructors' notes; I understand the appropriate citing in MLA Format: <a href="http://www.mla.org/" rel="nofollow" target="_blank">http://www.mla.org/</a> is required. I understand that any information cited must contain the   appropriate author credit. <br />
                                      <br />
                                    I  realize that failure to comply with this agreement of ethical and  professional standards will result in forfeiting my right to complete  the exam, my certification, my eligibility to proceed with the  diplomate and or my diplomate status. Plagiarism will not be  accepted. If my exam material is found to be plagiarized from the  internet and or taken from another person's exam; I understand I will  fail the exam.</p>
									  <p><br/>
									    By checking this box, I am confirming that I have read and I agree
								    to the Terms of Ethics:
									      <input name="TermsofEthics" type="hidden" value="NoAgree" />
									      <input name="TermsofEthics" type="checkbox" value="TermsofEthics" required />
<span class="required">*</span></p>
								  </div></td>
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
