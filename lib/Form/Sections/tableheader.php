<?php
if (!debug_backtrace()) {
    // shouldn't be accessed directly
    die();
}
?>
<?php if($param1=="") { $param1="700"; } ?>

<table border="0" cellpadding="5" cellspacing="5" width="<?php echo $param1; ?>">
    <tbody>