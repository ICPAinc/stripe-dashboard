<?php
include_once(dirname(__FILE__).'/lib/Form.php');


$config['template'] = 'Academy';
$config['title'] = 'Academy Membership Application';
$config['button label'] = 'Join Us';
$config['tag'] = 'membership';
$config['action'] = 'create';
$config['stripe account'] = 'academy';

Form::header();
?>
<div id="top">
    <h1>Academy Membership Application Form </h1>
        <p>Membership to the Academy is open to all licensed Doctors of Chiropractic who have achieved Certification and Diplomate Status in any aspect of family practice.</p>
        <p>The cost of membership is $45 a year.</p>
        <p>Join us in unifying the profession, the colleges and practitioners in the vital care of children and pregnant mothers. </p>
		<p><span class="required">*</span> - Required information</p>
<?php
Form::section('tableheader','480');
Form::section('contactinfo');
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