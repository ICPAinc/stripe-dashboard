<?php
include_once(dirname(__FILE__).'/lib/Form.php');


$config['template'] = 'ICPA';
$config['title'] = 'ICPA Seminar Registration Form';
$config['button label'] = 'Register';
$config['tag'] = 'seminar';
$config['action'] = 'create';
$config['stripe account'] = 'icpa';
//$config['email_to'] = ''; // set if you need to override default notification email in lib/setup.php

Form::header();
?>
<script  type="text/javascript">
function shToggle(content) {
  if (document.getElementById(content).style.display == "none")
    document.getElementById(content).style.display = "block"
  else
    document.getElementById(content).style.display = "none"
}
</script>
<div id="top">
    <h1>ICPA Seminar Registration Form</h1>
					<p><strong>Individual Class Attendance Fees: </strong></p>
                  <table width="578" border="1">
                      <tr>
                        <td width="353"><div align="center"><strong>Category</strong></div></td>
                        <td width="105"><div align="center"><strong><span style="font-size: 1em">ICPA Member</span></strong></div></td>
                        <td width="98"><div align="center"><strong><span style="font-size: 1em">Non- Member</span></strong></div></td>
                      </tr>
                      <tr>
                        <td height="24"><div align="center" style="font-size: 1em">D.C.</div></td>
                        <td><div align="center" style="font-size: 1em">$329</div></td>
                        <td><div align="center">$379</div></td>
                      </tr>
                      <tr>
                        <td><div align="center"> D.C. - 
                          First/Second Year of Practice</div></td>
                        <td><div align="center" style="font-size: 1em">$279</div></td>
                        <td><div align="center">$379</div></td>
                      </tr>
                      <tr>
                        <td height="26"><div align="center" style="font-size: 1em">Faculty D.C.</div></td>
                        <td><div align="center" style="font-size: 1em">$279</div></td>
                        <td><div align="center">$379</div></td>
                      </tr>
                      <tr>
                        <td height="26"><div align="center">Non-Practicing D.C.</div></td>
                        <td><div align="center">$279</div></td>
                        <td><div align="center" style="font-size: 1em">
                          <div align="center">$379</div>
                        </div></td>
                      </tr>
                      <tr>
                        <td height="26"><div align="center" style="font-size: 1em">
                          <div align="center" style="font-size: 1em">Spouse D.C.: when spouse is enrolled in the entire series Spouse </div>
                        </div></td>
                        <td><div align="center" style="font-size: 1em">$279</div></td>
                        <td><div align="center">
                          <div align="center">$379</div>
                        </div></td>
                      </tr>
                      <tr>
                        <td height="26"><div align="center" style="font-size: 1em">Student</div></td>
                        <td><div align="center" style="font-size: 1em">$279</div></td>
                        <td><div align="center">$379</div></td>
                      </tr>
                    </table>
            <p>&nbsp;</p>
            <p><strong>ICPA Member Discount Specials for the entire series: </strong></p>
            <p> These discount options are available only for  ICPA doctors signed up for the ICPA <em>auto-renewal membership</em>.(These discount options do not apply to the Parker University in Dallas, TX and Northwestern Health Sciences University in Minneapolis, MN.)</p>
            <table width="578" border="1">
              <tr>
                <td width="118"><div align="center"><strong>Category</strong></div></td>
                <td width="201"><div align="center"><strong>Pay In Full (PIF)</strong></div></td>
                <td width="237"><div align="center"><strong>Auto-Payment (AP)</strong></div></td>
              </tr>
              <tr>
                <td height="24"><div align="center">D.C.</div></td>
                <td><div align="center">
                  <div align="center">Total Cost: $4,185<br />
                    16 modules @ $279.00 per module.<br />
                    -$279 for 1 complimentary module.</div>
                </div></td>
                <td><div align="center">$279 per module for 16 modules. This   will be automatically deducted the Monday before each  module.</div></td>
              </tr>
              <tr>
                <td><div align="center">First/Second Year of Practice</div></td>
                <td><div align="center">Total Cost: $3,435<br />
                  16 modules @ $229.00 per module.<br />
                  -$279 for 1 complimentary module.</div></td>
                <td><div align="center">$229 per module for 16 modules. This   will be automatically deducted the Monday before each  module.</div></td>
              </tr>
              <tr>
                <td height="26"><div align="center">Faculty D.C. </div></td>
                <td><div align="center">Total Cost: $3,435<br />
                  16 modules @ $229.00 per module.<br />
                  -$229 for 1 complimentary module.</div></td>
                <td><div align="center">$229 per module for 16 modules. This   will be automatically deducted the Monday before each  module.</div></td>
              </tr>
              <tr>
                <td height="26"><div align="center">Non-Practicing D.C.</div></td>
                <td><div align="center">Total Cost: $3,435<br />
                  16 modules @ $229.00 per module.<br />
                  -$229 for 1 complimentary module.</div></td>
                <td><div align="center">
                  <div align="center">
                    <div align="center">$229 per module for 16 modules. This   will be automatically deducted the Monday before each  module.</div>
                  </div>
                </div></td>
              </tr>
              <tr>
                <td height="26"><div align="center">
                  <div align="center">Spouse D.C.: when spouse is enrolled in the entire series Spouse </div>
                </div></td>
                <td><div align="center">Total Cost: $3,435<br />
                  16 modules @ $229.00 per module.<br />
                  -$229 for 1 complimentary module.</div></td>
                <td><div align="center">
                  <div align="center">
                    <div align="center">$229 per module for 16 modules. This   will be automatically deducted the Monday before each  module.</div>
                  </div>
                </div></td>
              </tr>
              <tr>
                <td height="26"><div align="center">Student</div></td>
                <td><div align="center">Total Cost: $3, 435<br />
                  16 modules @ $229.00 per module.<br />
                  -$229 for 1 complimentary module.</div></td>
                <td><div align="center">
                  <div align="center">$229 per module for 16 modules. This   will be automatically deducted the Monday before each  module.</div>
                </div></td>
              </tr>
            </table>
            <p><br/>
            </p>
<p><span class="required">*</span> - Required information</p>
<p>*Please provide office information if you are joining ICPA as a DC member. This information will go in the online directory.</p>
<?php
Form::section('tableheader','675');
Form::section('contactinfo','Your cell phone will be used only for an emergency contact, such as a seminar cancellation, and will not appear on your directory listing.','required');
?>
						
							<tr>
								<td><span class="required">* </span>D.C. or Student:</td>
								<td><select name="Type" required>
									<option></option>
								  <option value="DC">D.C.</option>
								  <option value="Student">Student</option>
								</select></td>
							</tr>
							<tr>
							  <td><span class="required">*</span> Chiropractic College:</td>
							  <td><input type="text" size="35" name="ChiropracticCollege" required /></td>
						  </tr>
							<tr>
								<td>Trimester/Quarter:</td>
								<td><input type="text" size="35" name="Trimester/Quarter" /></td>
							</tr>
							<tr>
								<td><span class="required">*</span> Date of Graduation:</td>
								<td>Month: <input type="text" size="10" name="GraduationMonth" required /> Year: <input type="text" size="10" name="GraduationYear" required /></td>
							</tr>
							<tr>
								<td>Change of Address?:</td>
								<td>Yes - 
								  <input type="hidden" name="ChangeAddress" value="NoChange" />
                                  <input type="checkbox" name="ChangeAddress" value="ChangeAddress" /></td>
							</tr>
							<tr>
								<td>Change of Name?:</td>
								<td>Yes - 
								  <input type="hidden" name="ChangeName" value="NoChange" />
                                  <input type="checkbox" name="ChangeName" value="ChangeName" />
								  Old Name: 
								  <input type="text" size="35" name="OldName" /></td>
							</tr>
                            
							<tr>
							  <td colspan="2"><br/><br /><h3>ICPA Membership Information</h3></td>
							</tr>
							<tr>
								<td colspan="2"><hr />
							      <p><br>
							      Unsure if you are a member or not? Click <a href="http://icpa4kids.org/memberstatus/" target="_blank">Here</a> to check your membership status.</br>
							      <br>To find out when your ICPA membership expires, please click on your name in blue.  </br>
							      <br>For ICPA seminar discounts (Auto-Payment Discount Plan or Pay in Full); your membership needs to remain current throughout your entire enrollment in the seminar series.</br>
							      </p></td>
						  </tr>
                            
                            <tr>
								<td><span class="required">* </span>Current ICPA Member: </td>
								<td><select name="ICPAMember" required>
								<option></option>
                                  <option value="Yes">Yes</option>
                                  <option value="No">No </option>
							    <option value="DC Membership - $279">No, join as a D.C. - $279</option>
							    <option value="DC Married Couple Membership - $329">No, join as a Married D.C. Couple - $329</option>
							    <option value="Student Membership - $129">No, join as a Student - $129</option>
							    
                                <option value="First Year DC Membership - $179">No, join as a First-Year D.C. - $179</option>
                					    <option value="Associate DC - $179">No, join as an Associate DC (other DC in office must be an ICPA member - $179</option>                <option value="First Year DC Married Couple - $229">No, join as a  Married Couple First-Year D.C. - $229</option>
							    <option value="Non-Practicing DC Membership - $179">No, join as a Non-Practicing D.C. - $179</option>
                                </select></td>
                            </tr>
                            <tr>
								<td colspan="2">
                                <p></p>
<?php
Form::section('autorenew');
?>
								</td>
						    </tr>
                         <tr>
                         
                          <td colspan="2">
              <em><a href="javascript:void(0);" onclick="shToggle('MarriedOption'); return false;">Click here if you are joining as a Married Couple</a></em></td>
						  </tr></td>
                            
                            <tr>
                            <td colspan="2">
<table id="MarriedOption" style="display:none;" cellpadding="5" cellspacing="5"> 
							<tr>
								<td width="155">Spouse First Name:</td>
							  <td width="350"><input type="text" size="35" name="SpouseFirstName" /></td>
							</tr>
							<tr>
								<td>Spouse Last Name:</td>
								<td><input type="text" size="35" name="SpouseLastName" /></td>
							</tr>
                            
                            </table>
                            </td>
                            </tr>
                          <tr>
                          <td colspan="2">
              <em><a href="javascript:void(0);" onclick="shToggle('StudentClubOption'); return false;">Click here if you are joining as a Student Club Member</a></em></td>
						  </tr>
                            
                            <tr>
                            <td colspan="2">
<table id="StudentClubOption" style="display:none;" cellpadding="5" cellspacing="5"> 
							<tr>
								<td width="155">Student Club President:</td>
							  <td width="350"><input type="text" size="35" name="StudentClubPresident" /></td>
							</tr>
                            
                            </table>
                            </td>
                            </tr>
                            
						  <tr>
						    <td colspan="2"><br/><br /><h3>Seminar Information</h3>
					        <p>Auto-Payment Discount Registrants and Pay In Full Registrants (PIF). Please choose the first weekend of the seminar series under Seminar Month/Seminar Date. Please choose the payment program under seminar cost.
                              Your credit will be charged the Monday before the first scheduled seminar weekend unless other arrangements have been made with the ICPA main office.</p>
                            <p></p></td>
						  </tr>
							<tr>
								<td colspan="2"><hr /><br /></td>
							</tr>
			              <tr>
								<td height="25"><span class="required">* </span>Seminar Location:</td>
								<td><select name="SeminarLocation" required >
								  <option></option>
								  <option value="Atlanta">Atlanta, GA</option>
						           <option value="Boston">Boston, MA</option>
                                   <option value="Boise">Boise, ID</option>
								   <option value="Calgary, AB">Calgary, AB</option>
								  <option value="Chicago">Chicago, IL</option>
                                  <option value="Columbus">Columbus, OH</option>
                                  <option value="Daytona">Daytona, FL</option>
                                  <option value="Denver">Denver, CO</option>
                                  <option value="Ft. Lauderdale">Ft. Lauderdale, FL</option>
                                  <option value="Los Angeles">Los Angeles, CA</option>
								  <option value="Long Island">Long Island, NY</option>
                                  <option value="Pittsburgh">Pittsburgh, PA</option>
                                  <option value="Philadelphia">Philadelphia, PA</option>
                                  <option value="Ottawa">Ottawa, ON</option>
                                  <option value="Overland Park">Overland Park, KS</option>
                                  <option value="Portland">Portland, OR</option>
                                  <option value="San Diego">San Diego, CA</option>
								   <option value="San Francisco">San Francisco, CA</option>
                                   <option value="Seattle">Seattle, WA</option>
                                   <option value="Spartanburg">Spartanburg, SC</option>
								  <option value="St. Louis">St. Louis, MO</option>
								  <option value="Syracuse, NY">Syracuse, NY</option>
								  <option value="Toronto">Toronto, ON</option>
								  <option value="Trois Rivières">Trois, Rivieres, QC</option> 
                                  <option value="Vancouver">Vancouver, BC</option>
                                  <option value="Virginia">Virginia</option>
                              </select></td>
						  </tr>
							<tr>
								<td><span class="required">* </span>Seminar Month: </td>
							  <td><select name="SeminarMonth" required > 
									<option></option>
									<option value="January">January</option>
									<option value="February">February</option>
									<option value="March">March</option>
									<option value="April">April</option>
									<option value="May">May</option>
									<option value="June">June</option>
									<option value="July">July</option>
									<option value="August">August</option>
									<option value="September">September</option>
									<option value="October">October</option>
									<option value="November">November</option>
									<option value="December">December</option>
								</select> 								  
								<span class="required">*</span>Seminar Date: 
										<input type="text" size="15" name="SeminarDate" required /></td>
							</tr>
							<tr>
								<td><span class="required">* </span>Seminar Cost:</td>
							    <td><select name="SeminarCost" required>
							      <option></option>
							      <option value="DC Member - $329">DC - ICPA Member - $329</option>
							      <option value="DC & Student Non-Member - $379">DC & Student Non-Member - $379</option>
							   <option value="DC First Year Member/Non-Practicing DC/Non-Practicing/Faculty Member - $279">DC - ICPA First Year DC Member/Non-Practicing DC/Faculty Member - $279</option>
					              <option value="Student Member - $279">Student - ICPA Student Member - $279</option>
							      <option value="DC PIF - $4,185">Entire Series - DC Member - Save 32% - $4,185</option>
							      <option value="First Year DC PIF - $3,435">Entire Series - DC First-Year Member - Save 44% - $3, 435</option>
							      <option value="Student PIF - $3,435">Entire Series - Student Member - Save 56% - $3, 435</option>
							      <option value="Auto-Payment Discount - DC Member - $279 per Module">Auto-Payment Discount - DC Member - $279 per Module</option>
							      <option value="Auto-Payment Discount - First Year DC Member - $229 per Module">Auto-Payment Discount - First Year DC Member - $229 per Module</option>
							      <option value="Auto-Payment Discount - Student Member - $229 per Module">Auto-Payment Discount - Student Member - $229 per Module</option>
							      <option value="Prior PIF">Previously Paid-in-Full - Current Member</option>
							      <option value="Refresher Course - DC Member - $229">Refresher Course - DC Member - $229</option>
					
							      <option value=" Chiropractic Assistant">Chiropractic Assistant - $79</option>
							      <option value=" Lay Public">Lay Public/Spouse- $79</option>
						        </select></td>
        					</tr>
							<tr>
								<td colspan="2"><p><strong>Auto-Payment Discount and PIF</strong><em> will  register you for the entire ICPA seminar
							  series in the selected city. <br/>
					          </em><strong>Auto-Payment Discount</strong> <em>is only available at the start of the  seminar series in your designated city.</em></p></td>
						  </tr>
                            
							<tr>
								<td colspan="2">								</td>
							</tr>
							<tr>
								<td>Are you bringing a CA or Guest (Non-DC)?</td>
								<td><select name="Guest">
								  <option value=""></option>
                                  <option value="Yes">Yes: $75 CA</option>
								  <option value="Yes">Yes: $75 Lay Public/Spouse</option>	
							    </select></td>
							</tr>
                            <tr>
                            	<td colspan="2"><p><em>Classes where you can bring a CA are Dr. Ohm, Dr. Marini and Dr. Kevorkian</em></p></td>
                          </tr>
                            <tr>
                              <td><p><span class="required">* </span>Will you be requesting  CE Hours?</p>
                                <p> <em>**Please note there is a $35 application fee payable onsite.</em></p></td>
                              <td><select name="Requesting CE Hours" required >
                                <option></option>
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                              </select></td>
                            </tr>
                            <tr>
                              <td>If yes, which state/province:</td>
                              <td><select name="SeminarLocation2" >
                                <option></option>
                                <option value="AB">AB</option>
                                <option value="AL">AL</option>
                                <option value="AK">AK</option>
                                <option value="AZ">AZ</option>
                                <option value="AR">AR</option>
                                <option value="BC">BC</option>
                                <option value="CA">CA</option>
                                <option value="CO">CO</option>
                                <option value="CT">CT</option>
                                <option value="DE">DE</option>
                                <option value="FL">FL</option>
                                <option value="GA">GA</option>
                                <option value="HI">HI</option>
                                <option value="IA">IA</option>
                                <option value="ID">ID</option>
                                <option value="IL">IL</option>
                                <option value="IN">IN</option>
                                <option value="KS">KS</option>
                                <option value="KY">KY</option>
                                <option value="LA">LA</option>
                                <option value="MA">MA</option>
                                <option value="MD">MD</option>
                                <option value="ME">ME</option>
                                <option value="MI">MI</option>
                                <option value="MN">MN</option>
                                <option value="MO">MO</option>
                                <option value="MS">MS</option>
                                <option value="MT">MT</option>
                                <option value="NC">NC</option>
                                <option value="ND">ND</option>
                                <option value="NE">NE</option>
                                <option value="NH">NH</option>
                                <option value="NJ">NJ</option>
                                <option value="NM">NM</option>
                                <option value="NV">NV</option>
                                <option value="NY">NY</option>
                                <option value="OH">OH</option>
                                <option value="OK">OK</option>
                                <option value="OR">OR</option>
                                <option value="PA">PA</option>
                                <option value="RI">RI</option>
                                <option value="SC">SC</option>
                                <option value="SD">SD</option>
                                <option value="TN">TN</option>
                                <option value="TX">TX</option>
                                <option value="UT">UT</option>
                                <option value="VT">VT</option>
                                <option value="VA">VA</option>
                                <option value="WA">WA</option>
                                <option value="WI">WI</option>
                                <option value="WV">WV</option>
                                <option value="WY">WY</option>
                              </select></td>
                            </tr>
                            
							<tr>
							  <td colspan="2"><br/>
							    <p><strong>How did you hear about the seminar:</strong></p>
							    <p>How did you hear about the seminar? Please check all  that applies:</p>
							    <p>
							      <input name="Source1" type="hidden" value=" "/>
							      <input name="Source1" type="checkbox" value="PAChiroAssn"/>
						        Pennsylvania Chiropractic Association
							    </br>
							    <br>
							      <input name="Source2" type="hidden" value=" "/>
							      <input name="Source2" type="checkbox" value="Facebook"/> 
							      Facebook</br>
							      <br><input name="Source3" type="hidden" value=" "/>
                                      <input name="Source3" type="checkbox" value="LinkedIN"/>
							      LinkedIN</br>
							      <br><input name="Source4" type="hidden" value=" "/>
                                      <input name="Source4" type="checkbox" value="Twitter"/> 
							      Twitter </br> 
							      <br ><input name="Source5" type="hidden" value=" "/>
                                      <input name="Source5" type="checkbox" value="Friend"/>
							      A Friend</br>
							      <br><input name="Source6" type="hidden" value=" "/>
                                      <input name="Source6" type="checkbox" value="ICPAPostcard"/>
							      ICPA Postcard</br>
							      <br><input name="Source7" type="hidden" value=" "/>
                                      <input name="Source7" type="checkbox" value="CECruncher"/>
							      CE Cruncher</br>
							      <br><input name="Source8" type="hidden" value=" "/>
                                      <input name="Source8" type="checkbox" value="PlanetChiro"/>
							      PLANET Chiropractic</br>
							      <br><input name="Source9" type="hidden" value=" "/>
                                      <input name="Source9" type="checkbox" value="DynamicChiro"/>
							      Dynamic Chiropractic<br />
				              </p>							    
							
							<tr>
							  <td colspan="2">&nbsp;</td>
							</tr>
							<tr>
								<td colspan="2"><hr />
								  <table border="0" cellpadding="5" cellspacing="5" width="675">
								    <tbody>
								      <tr>
								        <td colspan="2"><h3>Terms and Agreements</h3></td>
							          </tr>
								      <tr>
								        <td colspan="2"><hr />
								          <br /></td>
							          </tr>
								      <tr>
								        <td colspan="2"><p><strong>All attendees must read and agree to the ICPA Seminar Terms &amp; ICPA Adjusting Technique Release Form</strong></p>
								          <p><a href="http://www.icpa4kids.com/ICPATerms.htm#SeminarTerms" target="_blank">I confirm that I read and I agree to the ICPA Seminar Terms&nbsp;</a><br />
								            <span class="required">* </span>
								            <input name="TermsAgreement" type="hidden" value="NoAgree" required />
								            <input name="TermsAgreement" type="checkbox" value="TermsAgreed" required />
								            &nbsp;I confirm that I read and I agree to the ICPA Seminar Terms.</p>
								          <p><a href="http://www.icpa4kids.com/ICPATerms.htm#ReleaseForm" target="_blank">I confirm that I read and I agree to the ICPA Adjusting Technique Release Form</a><br />
								            <span class="required">* </span>
								            <input name="ReleaseForm" type="hidden" value="NoAgree" required />
								            <input name="ReleaseForm" type="checkbox" value="ReleaseForm" required />
								            &nbsp;I confirm that I read and I agree to the ICPA Adjusting Technique Release Form</p>
								          <p>&nbsp;</p></td>
							          </tr>
								      <tr>
								        <td colspan="2"><br />
								          <p><strong>Pay-In-Full (PIF) or Auto-Payment Discount.&nbsp;Must Read and Agree To The Following Appropriate Term To Participate.</strong></p>
								          <ul>
								            <li><a href="http://www.icpa4kids.com/ICPATerms.htm#DCPIF/Autopayment" target="_blank">I confirm that I read and I agree to the DC PIF/Autopayment Terms</a><br />
								              <input name="DCPIF/Autopayment" type="hidden" value="NoAgree" />
								              <input name="DCPIF/Autopayment" type="checkbox" value="DCPIF/Autopayment" />
								              &nbsp;I confirm that I read and I agree to the ICPA DC PIF/Autopayment Terms</li>
							              </ul>
								          <ul>
								            <li><a href="http://www.icpa4kids.com/ICPATerms.htm#StudentPIF/Autopayment" target="_blank">I confirm that I read and I agree to the Student PIF/Autopayment Terms</a><br />
								              <input name="StudentPIF/Autopayment" type="hidden" value="NoAgree" />
								              <input name="StudentPIF/Autopayment" type="checkbox" value="StudentPIF/Autopayment" />
								              &nbsp;I confirm that I read and I agree to the ICPA Student PIF/Autopayment Terms
								              <p>&nbsp;</p>
								              <strong>Automatic Membership</strong>:
								              <p>To make this most convenient for you, you are being signed up for ICPA automatic renewal with your seminar payment program.&nbsp;</p>
							                </li>
							              </ul></td>
							          </tr>
							        </tbody>
						      </table>								  <br /></td>
							</tr>
							<tr>
							  <td colspan="2"><br/></td>
						  </tr>
							<tr>
							  <td colspan="2"><p>Application Fees  for Certification vary
								depending on location, length of course, sponsor
							      etc. Please refer to website for requested location and fee. Registration
								charges will be processed up to two weeks prior
							      to date of class. Cancellations are subject to penalty according
							      to the discretion of the ICPA.</p>
								<p><strong>Registrations recieved after 12 PM EST the Thursday prior to the seminar will be charged a $50 late fee.</strong></p>
								<p>If your registration is received Monday - Friday between the hours of 9am to 5pm, you will receive a registration e-mail confirmation at 9 PM EST the day you register.
								    If you do not receive this e-mail confirmation, it is possible the e-mail was sent to your bulk/junk mail, please check and then e-mail the seminar dept. at <a href="mailto:seminars@icpa4kids.com" target="_blank">seminars@icpa4kids.com</a>                              
							    to have this e-mail confirmation resent to
							    you. </p>
							    <p>All fees are in US Funds.</p>                              </td>
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
