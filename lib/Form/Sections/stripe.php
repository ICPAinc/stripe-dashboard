<?php
if (!debug_backtrace()) {
    // shouldn't be accessed directly
    die();
}
?>

<button id="customButton"><?php echo $config['button label']; ?></button>
<input type="hidden" name="stripeToken" id="stripeToken" />
<input type="hidden" name="stripeEmail" id="stripeEmail" />