<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('priority')->get();
        $projects = Project::all()->pluck('project_name', 'id');
        
        return view('tasks.index', compact('tasks', 'projects'));
    }

    public function edit($id)
    {
        $task = Task::find($id);
        if($task){
            return response()->json($task);
        }else{
            return response()->json(['error' => 'Task not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {   
        $validatedData = $request->validate([
            'taskName' => 'required',
            'taskPriority' => 'required|numeric',
        ]);
        
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['error' => 'Task not found'], 404);
        }

        $task->update([
            'task_name' => $request->taskName,
            'priority' => $request->taskPriority,
        ]);

        return response()->json(['message' => 'Task updated successfully'], 201);
    
    }

    public function destroy($id)
    {
        $task = Task::find($id);

        if ($task) {
            $task->delete();
            return response()->json(['success' => true, 'message' => 'Task deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Task not found'], 404);
        }
    }

}
