jQuery(document).ready(function($) {

    // Get list element.
    const todoList = document.querySelector("#todo_list");

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

                    todoList.innerHTML += listItem;

                });

            },
            error: function() {

                console.log('AJAX error getting tasks.');

            }
        });
    }
    get_tasks();



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


// "Add" does not work, when "Get" does. WHY?