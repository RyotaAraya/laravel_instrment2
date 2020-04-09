<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TasksController extends Controller
{
    public function new()
    {
        return view('tasks.new');
    }
    public function create(Request $request)
    {
        $request->validate([
            'plant_name' => 'required|string|max:20',
            'tag_no' => 'required|string|max:20',
            'trouble_content' => 'required|string|max:255',
            'details_repair' => 'required|string|max:255',
            'task_status' => 'required|string|max:20',
            'picture1' => 'string|nullable|max:255',
            'picture2' => 'string|nullable|max:255'
        ]);

        $task = new Task;

        $task->plant_name = $request->plant_name;
        $task->tag_no = $request->tag_no;
        $task->trouble_content = $request->trouble_content;
        $task->details_repair = $request->details_repair;
        $task->task_status = $request->task_status;
        $task->picture1 = $request->picture1;
        $task->picture2 = $request->picture2;
        $task->delete_flg = 0;
        $task->save();

        return redirect('/tasks/new')->with('flash_message', __('Registered.'));
    }
}
