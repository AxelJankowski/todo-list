/*jQuery(document).ready(function() {

    jQuery('#new_task_form').submit(function(event) { // Trigger on submit
        event.preventDefault();

        jQuery.ajax({ // No luck here...
                    type: 'POST',
                    dataType: 'json',
                    data: jQuery("#new_task_form").serialize(),
                    action: 'add_task',
                    url: ajaxurl,
                    complete: function (response) {
                        
                    },
                    success: function(data) {

                        alert('Form submit success!');

                    },
                    error: function (errorThrown) {

                        console.log(errorThrown);

                    }
        });
        
    });

});*/

jQuery(document).ready(function($) {

    jQuery('#new_task_form').submit(function(event) { // Trigger on submit
        event.preventDefault();

        var data = {
            'action': 'my_action',
            'whatever': 1234
        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data, function(response) {
            alert('Got this from the server: ' + response);
        });
    });
});