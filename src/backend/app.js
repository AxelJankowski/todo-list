jQuery(document).ready(function() {

    jQuery('#new_task_form').submit(function(event) { // Trigger on submit
        event.preventDefault();

        jQuery.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: jQuery("#new_task_form").serialize(),
                    url: ajaxurl,
                    success: function(data)
                    {
                        alert('Form submit success!');
                    }
        });
        
    });

});