<?php
if (!debug_backtrace()) {
    // shouldn't be accessed directly
    die();
}
?>
<tr>
    <td colspan="2">
        <table bgcolor="#E7E7E7" border="0" cellpadding="5" cellspacing="5" width="100%">
            <tbody>
                <tr>
                    <td colspan="2">
                        <h3>Shipping Information - For Pathways Magazine and Other Mailings</h3>
                        <em>If Different than Office Address</em>
                    </td>
                </tr>
                <tr>
                    <td>Address:</td>
                    <td><input size="35" name="ShippingAddress1" type="text"></td>
                </tr>
                <tr>
                    <td> Address (continued):</td>
                    <td>
                        <input size="35" name="ShippingAddress2" type="text">
                    </td>
                </tr>
                <tr>
                    <td>City:</td>
                    <td><input size="35" name="ShippingCity" type="text"></td>
                </tr>
                <tr>
                    <td>State / Province:</td>
                    <td><input size="35" name="ShippingState" type="text"></td>
                </tr>
                <tr>
                    <td>Zip / Postal Code:</td>
                    <td><input size="35" name="ShippingZip" type="text"></td>
                </tr>
                <tr>
                    <td>Country:</td>
                    <td>
                        <?php Form::section('countrylist','ShippingCountry'); ?>
                    </td>
                </tr>
                <tr>
                    <td>Phone Number:</td>
                    <td><input size="35" name="ShippingPhoneNumber" type="text"></td>
                </tr>
            </tbody>
        </table>
    </td>
</tr>
<tr>
    <td colspan="2"><br><hr><br></td>
</tr>