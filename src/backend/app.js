jQuery(document).ready(function($) {

    // Count tasks.
    function count_tasks() {
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: ({
                action: 'count_tasks'
            }),
            success: function (response){
                console.log('The number of rows in table: ' + response);
            }
        });
    }
    count_tasks();



    // Add new task.
    jQuery('#new_task_form').submit(function(event) { // Trigger on submit.
        event.preventDefault();

        var data = {
            'action': 'add_task',
            'task':   $('form#new_task_form #new_task').val()
        };

        jQuery.post(ajaxurl, data, function(response) {
            console.log('Got this from the server: ' + response);
        });
    });
});