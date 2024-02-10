@extends('layouts.layout')
@section('content')
    <div class="container">
        <h2>Task List</h2>

        <div class="form-group pt-2 pb-2">
            <label for="project_id">Filter by Project:</label>
            <select class="form-control" id="projectFilter">
                <option value="">All Projects</option>
                @foreach($projects as $id => $project_name)
                    <option value="{{ $id }}">{{ $project_name }}</option>
                @endforeach
            </select>
        </div>

        <table id="taskList" class="table">
            <thead>
                <tr>
                    <th>Task Name</th>
                    <th>Priority</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($tasks->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center">No records found.</td>
                    </tr>
                @else
                    <tr id="noTasksFound" class="text-center" style="display: none;">
                        <td colspan="4">No tasks found for selected project.</td>
                    </tr>
                    @foreach($tasks as $index => $task)
                            <tr data-id="{{ $task->id }}" data-project-id="{{ $task->project_id }}">
                            <td>{{ $task->task_name }}</td>
                            <td>{{ $task->priority }}</td>
                            <td>{{ $task->created_at }}</td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="openEditModal({{ $task->id }})"><i class="fas fa-pencil-alt" style="font-size: 10px;"></i></button>
                                <button class="btn btn-danger btn-sm" onclick="openDeleteModal({{ $task->id }})"><i class="fas fa-trash" style="font-size: 10px;"></i></button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

     <!-- Edit modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <input type="text" class="form-control" id="editTaskID" name="editTaskID" hidden/>
                <div class="modal-header">
                    <h3 class="modal-title" id="editClientModalLabel">Edit task</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Task Name</th>
                                <th>Priority</th>
                            </tr>
                        </thead>
                        <tbody>
                            <th><input type="text" class="form-control" id="editTaskName" name="editTaskName"/></th>
                            <th><input type="text" class="form-control" id="editPriority" name="editPriority"/></th>
                        </tbody>
                    </table>
                    <div id="editTaskSuccess" class="text-success" display="none"></div>
                    <div id="editTaskErr" class="text-danger" display="none"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="updateTask()" class="btn btn-success">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Delete Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this task?
                </div>
                    <div id="deleteTaskSuccess" class="text-success pl-3" display="none"></div>
                    <div id="deleteTaskErr" class="text-danger pl-3" display="none"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

@endsection