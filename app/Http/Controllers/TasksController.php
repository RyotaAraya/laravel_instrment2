<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
        //Log::debug(print_r($tasks, true));

        return view('tasks.index', ['tasks' => $tasks]);
    }
    public function mypage()
    {
        //ログインしているユーザーが作成したタスクを取得する
        //tasksはユーザーモデルで定義したもの
        $tasks = Auth::user()->tasks()->get();
        dump('tasks:' . $tasks);
        return view('tasks.mypage', compact('tasks'));
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
            'picture1' => 'nullable',
            'picture2' => 'nullable',
        ]);

        $task = new Task();

        $task->plant_name = $request->plant_name;
        $task->tag_no = $request->tag_no;
        $task->trouble_content = $request->trouble_content;
        $task->details_repair = $request->details_repair;
        $task->task_status = $request->task_status;
        $task->delete_flg = 0;

        if ($request->file('picture1') == '') {
            $task->picture1 = 'no_image.png';
        } else {
            //画像をpublic下に保存しpathを作成 public/img/xxxx.png
            $path1 = $request->file('picture1')->store('public/img');
            //画像のpathをデータベースに保存 ,パス名を変更 storage/img/xxx.png,データベースにpath名で保存
            $task->picture1 = basename($path1);
        }
        if ($request->file('picture2') == '') {
            $task->picture2 = 'no_image.png';
        } else {
            //画像をpublic下に保存しpathを作成 public/img/xxxx.png
            $path2 = $request->file('picture2')->store('public/img');
            //画像のpathをデータベースに保存 ,パス名を変更 storage/img/xxx.png,データベースにpath名で保存
            $task->picture2 = basename($path2);
        }

        //$task->save();
        //user_idを紐付ける $taskのインスタンスを渡す
        Auth::user()->tasks()->save($task);

        return redirect('/tasks/new')->with('flash_message', __('Registered.'));
    }

    public function details($id)
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
        return view('tasks.details', ['task' => $task]);
    }

    public function edit($id)
    {
        //idが数字でなければエラー、事前にチェックしてDBへの無駄なアクセスを減らせる
        if (!ctype_digit($id)) {
            return redirect('/tasks/new')->with('flash_message', __('Invalid operation was Performed.'));
        }

        //idを指定してTaskテーブルからデータ取得
        //$task = Task::find($id);

        //ログインユーザーが作成したtaskを集めてIDで検索して取得
        $task = Auth::user()->tasks()->find($id);

        //Taskテーブルにデータがなかった場合
        if (empty($task)) {
            return redirect('/tasks/new')->with('flash_message', __('Invalid operation was Performed.'));
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
        $task->delete_flg = 0;


        if ($request->file('picture1') == '' && $task->picture1 == 'no_image.png') {
            $task->picture1 = 'no_image.png';
        } elseif ($request->file('picture1') !== '') {
            //画像をpublic下に保存しpathを作成 public/img/xxxx.png
            $path1 = $request->file('picture1')->store('public/img');
            //画像のpathをデータベースに保存 ,パス名を変更 storage/img/xxx.png,データベースにpath名で保存
            $task->picture1 = basename($path1);
        }
        if ($request->file('picture2') == '' && $task->picture2 == 'no_image.png') {
            $task->picture2 = 'no_image.png';
        } elseif ($request->file('picture2') !== '' && $request->file('picture1') == '' && $task->picture1 === 'no_image.png') {
            //画像1が空で画像2のリクエストがあったら画像1に入れる
            //画像をpublic下に保存しpathを作成 public/img/xxxx.png
            $path1 = $request->file('picture2')->store('public/img');
            //画像のpathをデータベースに保存 ,パス名を変更 storage/img/xxx.png,データベースにpath名で保存
            $task->picture1 = basename($path1);
        } elseif ($request->file('picture2') !== '') {
            //画像をpublic下に保存しpathを作成 public/img/xxxx.png
            $path2 = $request->file('picture2')->store('public/img');

            //画像のpathをデータベースに保存 ,パス名を変更 storage/img/xxx.png,データベースにpath名で保存
            $task->picture2 = basename($path2);
        }

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
