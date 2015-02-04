<?php
if (!debug_backtrace()) {
    // shouldn't be accessed directly
    die();
}
// $param1 = optional text about Cell Phone requirement or usage
// $param2 = optional 'required' toggle for Cell Phone
?>

    	<tr>
        	<td colspan="2"><h3>Contact Information </h3></td>
        </tr>
        <tr>
            <td width="180"><span class="required">*</span> First Name:</td>
            <td width="auto"><input size="35" name="FirstName" type="text" required></td>
        </tr>
        <tr>
            <td><span class="required">*</span> Last Name:</td>
            <td><input size="35" name="LastName" type="text" required></td>
        </tr>
        <tr>
            <td>Suffix:</td>
             <td><input size="35" name="Suffix" type="text"></td>
        </tr>
        <tr>
            <td>Office Name:</td>
            <td><input size="35" name="OfficeName" type="text"></td>
        </tr>
        <tr>
            <td><span class="required">*</span> Office or Primary Address:</td>
            <td><input size="35" name="Address1" type="text" required></td>
        </tr>
        <tr>
            <td>Office Address (continued):</td>
            <td><input size="35" name="Address2" type="text"></td>
        </tr>
        <tr>
            <td><span class="required">* </span>City:</td>
            <td><input size="35" name="City" type="text" required></td>
        </tr>
        <tr>
            <td><span class="required">* </span>State / Province:</td>
            <td><input size="35" name="State" type="text" required></td>
        </tr>
        <tr>
            <td><span class="required">*</span> Zip / Postal Code:</td>
            <td><input size="35" name="ZipCode" type="text" required></td>
        </tr>
        <tr>
            <td><span class="required">* </span>Country:</td>
            <td>
                <?php Form::section('countrylist','Country','required'); ?>
            </td>
        </tr>
        <tr>
            <td><span class="required">* </span>Office or Primary Phone Number:</td>
            <td><input size="35" name="PhoneNumber" type="text" required></td>
        </tr>
        <tr>
            <td><?php if ($param2=="required") { echo "<span class=\"required\">* </span>"; } ?>Cell Phone Number:</td>
            <td><input size="35" name="CellNumber" type="text" <?php echo $param2; ?>></td>
        </tr>
        <?php if($param1!="") { ?>
        <tr>
        	<td colspan="2"><p><em><?php echo $param1; ?></em></p></td>
        </tr>
        <?php } ?>
        <tr>
            <td>Fax Number:</td>
            <td><input size="35" name="FaxNumber" type="text"></td>
        </tr>
        <tr>
            <td>Web Page Address:</td>
            <td><input size="35" name="WebAddress" type="text"></td>
        </tr>
        <tr>
            <td colspan="2"><br><hr><br></td>
        </tr>