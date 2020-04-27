<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function getTasks()
    {
        $tasks = Task::where('delete_flg', '=', 0)->get();

        return $tasks;
    }
    public function alltasks()
    {
        $tasks = Task::all();

        return view('tasks.alltasks', ['tasks' => $tasks]);
    }

    public function index()
    {
        $tasks = Task::where('delete_flg', '=', 0)->paginate(10);
        //Log::debug(print_r($tasks, true));
        return view('tasks.index', ['tasks' => $tasks]);
    }
    public function mypage()
    {
        //ログインしているユーザーが作成したタスクを取得する
        //tasksはユーザーモデルで定義したもの
        $tasks = Auth::user()->tasks()->paginate(10);
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
            'picture1' => 'nullable|file|image|mimes:jpeg,png|max:1024',
            'picture2' => 'nullable|file|image|mimes:jpeg,png|max:1024',
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
        $task = Task::find($id);

        //ログインユーザーが作成したtaskを集めてIDで検索して取得
        //$task = Auth::user()->tasks()->find($id);

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
        $request->validate([
            'plant_name' => 'required|string|max:20',
            'tag_no' => 'required|string|max:20',
            'trouble_content' => 'required|string|max:255',
            'details_repair' => 'required|string|max:255',
            'task_status' => 'required|string|max:20',
            'picture1' => 'nullable|file|image|mimes:jpeg,png|max:1024',
            'picture2' => 'nullable|file|image|mimes:jpeg,png|max:1024',
        ]);

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
        } elseif ($request->file('picture1') != '' && $task->picture1 == 'no_image.png') {
            //画像をpublic下に保存しpathを作成 public/img/xxxx.png
            $path1 = $request->file('picture1')->store('public/img');
            //画像のpathをデータベースに保存 ,パス名を変更 storage/img/xxx.png,データベースにpath名で保存
            $task->picture1 = basename($path1);
        } elseif ($request->file('picture1') != '' && $task->picture1 != 'no_image.png') {
            //画像をpublic下に保存しpathを作成 public/img/xxxx.png
            $path1 = $request->file('picture1')->store('public/img');
            //画像のpathをデータベースに保存 ,パス名を変更 storage/img/xxx.png,データベースにpath名で保存
            $task->picture1 = basename($path1);
        }


        if ($request->file('picture2') != '') {
            if ($request->file('picture1') == '' && $task->picture1 == 'no_image.png') {
                //画像1が空で画像2のリクエストがあったら画像1に入れる
                //画像をpublic下に保存しpathを作成 public/img/xxxx.png
                $path1 = $request->file('picture2')->store('public/img');
                //画像のpathをデータベースに保存 ,パス名を変更 storage/img/xxx.png,データベースにpath名で保存
                $task->picture1 = basename($path1);
            } elseif ($task->picture2 == 'no_image.png') {
                //画像をpublic下に保存しpathを作成 public/img/xxxx.png
                $path2 = $request->file('picture2')->store('public/img');
                //画像のpathをデータベースに保存 ,パス名を変更 storage/img/xxx.png,データベースにpath名で保存
                $task->picture2 = basename($path2);
            } elseif ($task->picture2 != 'no_image.png') {
                //画像をpublic下に保存しpathを作成 public/img/xxxx.png
                $path2 = $request->file('picture2')->store('public/img');
                //画像のpathをデータベースに保存 ,パス名を変更 storage/img/xxx.png,データベースにpath名で保存
                $task->picture2 = basename($path2);
            }
        } else {
            $task->picture2 = 'no_image.png';
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

        //Auth::user()->tasks();
        $task = Task::find($id);
        $task->delete_flg = 1;
        $task->save();

        return redirect('/mypage')->with('flash_message', __('Deleted.'));
    }
    //削除したデータを復活させる
    public function resurrection($id)
    {
        //idが数字でなければエラー、事前にチェックしてDBへの無駄なアクセスを減らせる
        if (!ctype_digit($id)) {
            return redirect('/tasks/new')->with('flash_message', __('Invalid operation was Performed.'));
        }

        //Auth::user()->tasks();
        $task = Task::find($id);
        $task->delete_flg = 0;
        $task->save();

        return redirect('/mypage')->with('flash_message', __('Resurrection.'));
    }
}
