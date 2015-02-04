<?php
if (!debug_backtrace()) {
    // shouldn't be accessed directly
    die();
}
?>
<tr>
    <td colspan="2"><h3>Membership Information</h3></td>
</tr>
<tr>
    <td><span class="required">*</span> Select Your Membership Type:</td>
    <td>
        <select name="MembershipType" required>
            <option selected="selected"></option>
            <option value="DC">D.C.</option>
            <option value="First Year DC">First Year DC</option>
            <option value="Second Year DC">Second Year DC</option>
            <option value="Associate DC"> Associate DC</option>
            <option value="Non-Practicing DC">Non-Practicing DC</option>
            <option value="Faculty DC">Faculty D.C.</option>
            <option value="Married Couple">Married Couple DC</option>
            <option value="First Year Married Couple DC ">First Year Married Couple DC</option>
            <option value="Student">Student</option>
            <option value="Pathways Connect Student Club">Pathways Connect Student Club</option>
            <option value=" Student Married Couple ">Student Married Couple</option>
        </select>
    </td>
</tr>
<tr>
    <td>								</td>
    <td>
        <ul>
            <li>The "First Year DC" refers to chiropractors in their first full year of practice.</li>
            <li>Associate D.C.'s, please list primary D.C. under name of referring ICPA member. Check your primary D.C.'s <a href="http://icpa4kids.org/memberstatus/" target="_blank">Membership Status</a>.</li>
        </ul>
    </td>
</tr>
<tr>
</tr>
<tr>
    <td><span class="required">*</span> Where did you hear about us:</td>
    <td>
        <select name="MembershipReferral" required>
            <option selected="selected"></option>
            <option value="National conference">National Conference</option>
            <option value="From another member">From Another Member</option>
            <option value="Form in the mail">Form in the Mail</option>
            <option value="E-Mail notice">E-Mail Notice</option>
            <option value="Phone call from ICPA">Phone Call From ICPA</option>
            <option value="Seminar registration discount">Seminar Registration Discount</option>
            <option value="Through a chiropractic college">Through a Chiropractic College</option>
            <option value="Other">Other</option>
        </select>
    </td>
</tr>
<tr>
    <td>Name of referring ICPA member:</td>
    <td><input size="35" name="ReferringMember" type="text"></td>
</tr>
<tr>
  <td><span class="required">*</span> Malpractice Insurance Provider:</td>
  <td><select name="malpracticInsurance" required>
            <option selected="selected"></option>
            <option value="ACE American Insurance Company">ACE American Insurance Company</option>
            <option value="ACORD">ACORD</option>
            <option value="Allied Professionals Insurance Company">Allied Professionals Insurance Company</option>
            <option value="AXA Insurance">AXA Insurance</option>
            <option value="Canadian Chiropractic Protective Association">Canadian Chiropractic Protective Association</option>
            <option value="ChiroFutures">ChiroFutures</option>
            <option value="CNA">CNA</option>
            <option value="NCMIC">NCMIC</option>
            <option value="OUM">OUM</option>
            <option value="Pi Omega Delta Insurance Services">Pi Omega Delta Insurance Services</option>
            <option value="Not Applicable">Student/International D.C. - Not Applicable</option>
            <option value="Other">Other</option>
        </select>
    </td>
</tr>

<tr>
    <td>If Other:</td>
    <td><input size="35" name="miOther" type="text"></td>
</tr>
<tr>

</tr> 
<tr>
    <td colspan="2"><br><hr><br></td>
</tr>