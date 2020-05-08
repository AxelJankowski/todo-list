jQuery(document).ready(function() {

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

});