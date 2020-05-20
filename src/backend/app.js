jQuery(document).ready(function($) {

    get_tasks();



    var tasks_container = $('#tasks-container')[0]; // Get tasks container element.



    // Get tasks.
    function get_tasks() {
        
        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: ({
                action: 'get_tasks'
            }),
            success: function(response) {

                    var tasks = JSON.parse(response);
                    tasks.forEach(function(task) {

                        if(task['status'] == 1) { // Check if task is done.
                            var status = 'checked';
                        } else {
                            var status = '';
                        }

                        var listItem = '<li class="item list-hover">' +
                                            '<label class="item-checkbox" style="padding-right: 4px;">' + // These 4 pixels literally vanished, I don't have the slightest clue what happened.
                                                '<input class="checkbox" id="' + task['id'] + '" type="checkbox" ' + status + '>' +
                                            '</label>' +
                                            '<label class="item-text list-hover" id="task-' + task['id'] + '">' + task['task'] + '</label>' +
                                        '</li>';

                        tasks_container.innerHTML += listItem; // Display tasks.

                    });

            },
            error: function() {

                    console.log('AJAX error getting tasks.');

            }
        });
    }



    // Refresh list.
    function refresh() {

        tasks_container.innerHTML = ""; // Empty the container before displaying tasks.

        get_tasks();

    }



    // Add new task.
    jQuery('#new_task_form').submit(function(event) { // Trigger on submit.
        event.preventDefault();

        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'add_task',
                task: $('#new_task').val()
            },
            success: function(response) {

                    console.log('New task added: ' + response);

                    refresh();
            
            },
            error: function() {

                    console.log('Error addding task.');

            }
        });

        $('#new_task_form')[0].reset(); // Clear input in form.

    });



    // Change task status (mark as done or not).
    jQuery(document).on('click', '.checkbox', function() { // Trigger on click.

        jQuery.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'mark_task',
                task_id: $(this).attr('id'),
                checked: $(this).attr('checked')
            },
            success: function(response) {

                    console.log('Task ' + response + '.');

            },
            error: function() {

                    console.log('Error updating task status.');

            }
        });

    });



    // Edit task.
    jQuery(document).on('click', '.item-text', function() { // Trigger on click.
        $(this).attr('contenteditable', 'true'); // Allow task edit.

        jQuery(document).on('keyup', '.item-text', function(event) { // Trigger on key.

            var task_id = $(this).attr('id');
            var text = $('#' + task_id)[0].textContent; // Get text.

            if (event.keyCode === 13) { // Key 13 is Enter.
                event.preventDefault();

                jQuery.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'edit_task',
                        task_id: task_id,
                        text: text,
                    },
                    success: function(response) {
    
                            console.log('Task ' + response + ' edited.');
    
                    },
                    error: function() {
    
                            console.log('Error editing task.');
    
                    }
                })

            }

        });

    });

});