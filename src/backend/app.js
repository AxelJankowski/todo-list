jQuery(document).ready(function($) {

    get_tasks();



    var tasks_container = document.querySelector("#tasks-container"); // Get tasks container element.



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

                    var listItem = '<li class="item list-hover">' +
                                        '<label class="item-checkbox" style="padding-right: 4px;">' + // These 4 pixels literally vanished, I don't have the slightest clue what happened.
                                            '<input type="checkbox" checked="checked">' +
                                            '<span class="checkmark"></span>' +
                                        '</label>' +
                                        '<label class="item-text list-hover">' + task['task'] + '</label>' +
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
                task: $('form#new_task_form #new_task').val()
            },
            success: function(response) {

                console.log('New task added: ' + response);

                refresh();
            
            },
            error: function() {

                console.log('Error addding task.');

            }
        });
    });

});