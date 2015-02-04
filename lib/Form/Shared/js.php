<?php
if (!debug_backtrace()) {
    // shouldn't be accessed directly
    die();
}
?>
<script>
    var handler = StripeCheckout.configure({
        key: '<?php echo Setup::getKey($config['stripe account']); ?>',
        image: '<?php echo Setup::getLogo($config['stripe account']); ?>',
        token: function(token) {
            $('#stripeToken').val(token.id);
            $('#stripeEmail').val(token.email);
            postForm();
        }
    });
      
    $('#form').validate({onsubmit: false});
    function onSubmit(e) {
        e.preventDefault();
        if ($('#form').valid()) {
            handler.open({
                name: '<?php echo Setup::getName($config['stripe account']); ?>',
                description: '<?php echo $config['title']; ?>',
                panelLabel: '<?php echo $config['button label']; ?>'
            });
        }
    }
      
    function postForm() {
        $.blockUI({message: '<h1>Submitting...</h1>'});
        $.post( "<?php echo $_SERVER['REQUEST_URI']; ?>?xhr=true", $( "#form" ).serialize() ).done(function(data) {
            if (data == 'success') {
                $('#form').hide();
                $('#success').show();
                $.unblockUI();
            } else if(data == 'notfound') {
                $.blockUI({message: $('#notfound')});
            } else {
                $.blockUI({message: $('#fail')});
            }
        }).fail(function() {
            $.blockUI({message: $('fail')});
        });
    }
    
    $(document).ready(function() {
        $('#customButton').on("click", onSubmit);
        $('#form').on("submit", onSubmit);
        $('#failContinueButton').on('click', function() { $.unblockUI(); });
        $('#notFoundContinueButton').on('click', function() { $.unblockUI(); });
    });
</script>