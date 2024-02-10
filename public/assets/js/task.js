$(document).ready(function() {
    $('#projectFilter').change(function() {
        var projectId = this.value; 
        var foundTask = false;
        console.log(projectId );
        var rows = document.querySelectorAll('#taskList tbody tr');

        rows.forEach(function(row) {
            var taskId = row.getAttribute('data-id'); 

            if (projectId === '' || row.dataset.projectId === projectId) {
                row.style.display = ''; 
                foundTask = true;
            } else {
                row.style.display = 'none';
            }
        });

        if (!foundTask) {
            $('#noTasksFound').show();
        } else {
            $('#noTasksFound').hide(); 
        }
    });
});

function openEditModal(taskId) {
    $('#editTaskErr').text('Error updating task').css('display', 'none');
    $.ajax({
        url: `tasks/${taskId}/edit`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            $('#editTaskID').val(data.id);
            $('#editTaskName').val(data.task_name);
            $('#editPriority').val(data.priority);
            $('#editTaskModal').modal('show');
        },
        error: function (xhr, status, error) {
            console.error(xhr, status, error);
        }
    });
}

function updateTask(){

    if ($('#editTaskName').val().trim() === ''){
        $('#editTaskErr').text('Task name cannot be empty.').show();
        $('#editTaskName').addClass('is-invalid');
        return;
    }else {
        $('#editTaskErr').hide();
        $('#editTaskName').removeClass('is-invalid');
    }

    if ($('#editPriority').val().trim() === '' || isNaN($('#editPriority').val())){
        $('#editTaskErr').text('Task priority cannot be empty and  must be a number.').show();
        $('#editPriority').addClass('is-invalid');
        return;
    }else {
        $('#editTaskErr').hide();
        $('#editPriority').removeClass('is-invalid');
    }

    let taskId =  $('#editTaskID').val();
    
    let data = {
        taskName: $('#editTaskName').val(),
        taskPriority: $('#editPriority').val(),
    }

    $.ajax({
        url: 'tasks/'+ taskId,
        type: 'PUT',
        dataType: 'json',
        data : data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response, xhr) {

            if (response.message === "Task updated successfully" && xhr === "success") {
                $('#editTaskSuccess').text('Task update successfully').css('display', 'block');
            }else{
                $('#editTaskErr').text('Error updating task').css('display', 'block');
            }

            setTimeout(()=>{
                $('#editTaskModal').modal('hide');
                location.reload();
            }, 2000);
        },
        error: function (xhr, status, error) {
            $('#editTaskErr').text('Error updating task').css('display', 'block');
        }
    });
}

function openDeleteModal(taskId) {
    $('#confirmDeleteModal').modal('show');

    $('#confirmDeleteBtn').click(function() {

        $.ajax({
            url: `tasks/${taskId}`,
            type: 'DELETE',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    $('#deleteTaskSuccess').text(response.message).css('display', 'block');
                    setTimeout(() => {
                        $('#confirmDeleteModal').modal('hide');
                        location.reload();
                    }, 2000);
                } else {
                    $('#deleteTaskErr').text(response.message).css('display', 'block');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr, status, error);
            }
        });
    });
}

const taskList = document.getElementById('taskList').getElementsByTagName('tbody')[0];
new Sortable(taskList, {
    animation: 150,
    onEnd: function (evt) {
        
        const rows = Array.from(taskList.children);
        
        rows.forEach((row, index) => {
            const taskId = row.getAttribute('data-id');
            const taskName = row.cells[0].innerText; 
            
            $.ajax({
                url: `tasks/${taskId}`,
                type: 'PUT',
                dataType: 'json',
                data: { 
                    taskName: taskName,
                    taskPriority: index + 1 
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    row.cells[1].innerText = index + 1;
                },
                error: function (xhr, status, error) {
                    console.error(xhr, status, error);
                }
            });
        });
    }
});

