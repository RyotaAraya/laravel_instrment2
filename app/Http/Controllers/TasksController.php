<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

class TasksController extends Controller
{
    public function getTasks()
    {
        $tasks = Task::all();
        return $tasks;
    }

    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', ['tasks' => $tasks]);
    }
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
    public function edit($id)
    {
        //idが数字でなければエラー、事前にチェックしてDBへの無駄なアクセスを減らせる
        if (!ctype_digit($id)) {
            return redirect('/tasks/new')->with('flash_message', __('Invalid operation was Performed.'));
        }

        //idを指定してTaskテーブルからデータ取得
        $task = Task::find($id);

        //Taskテーブルにデータがなかった場合
        if (empty($task)) {
            return redirect('/tasks/new')->with('flash_message', __('No data.'));
        }
        //viewにtaskに$taskを詰めて渡す、view側では$taskとして使用可能
        return view('tasks.edit', ['task' => $task]);
    }
    public function update(Request $request, $id)
    {
        //idが数字でなければエラー、事前にチェックしてDBへの無駄なアクセスを減らせる
        if (!ctype_digit($id)) {
            return redirect('/tasks/new')->with('flash_message', __('Invalid operation was Performed.'));
        }

        $task = Task::find($id);

        //Taskテーブルにデータがなかった場合
        if (empty($task)) {
            return redirect('/tasks/new')->with('flash_message', __('No data.'));
        }
        $task->plant_name = $request->plant_name;
        $task->tag_no = $request->tag_no;
        $task->trouble_content = $request->trouble_content;
        $task->details_repair = $request->details_repair;
        $task->task_status = $request->task_status;
        $task->picture1 = $request->picture1;
        $task->picture2 = $request->picture2;
        $task->delete_flg = 0;
        $task->save();

        return redirect('/tasks')->with('flash_message', __('Update Registered.'));
    }
    public function destroy($id)
    {
        //idが数字でなければエラー、事前にチェックしてDBへの無駄なアクセスを減らせる
        if (!ctype_digit($id)) {
            return redirect('/tasks/new')->with('flash_message', __('Invalid operation was Performed.'));
        }

        $task = Task::find($id);
        $task->delete_flg = 1;
        $task->save();

        return redirect('/tasks')->with('flash_message', __('Deleted.'));
    }
}
