<?php

namespace App\Http\Controllers;

use Storage;
use App\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


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
    public function scroll()
    {
        $tasks = Task::where('delete_flg', '=', 0)->paginate(5);
        //$tasks = Task::where('delete_flg', '=', 0)->paginate(5);
        //$tasks = Task::where('delete_flg', '=', 0)->get();
        //Log::debug(print_r($tasks, true));
        return view('tasks.scroll', ['tasks' => $tasks]);
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

        // ファイル名のタイムスタンプに使う
        $now = date_format(Carbon::now(), 'YmdHis');

        // picture1未登録の場合
        if ($request->file('picture1') == '') {
            $task->picture1 = 'no_image.png';
        } else {
            // picture1に画像登録した場合
            // 画像ファイルを変数に取り込む
            $imagefile1 = $request->file('picture1');
            // アップロードされたファイル名を取得
            $name1 = $imagefile1->getClientOriginalName();
            // S3の保存先のパスを生成
            $storePath1 = "tasks_image/" . $now . "_" . $name1;
            // 画像を横幅は400px、縦幅はアスペクト比維持の自動サイズへリサイズ
            $image1 = Image::make($imagefile1)
                ->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    //サイズが大きくなることを防ぐ
                    $constraint->upsize();
                });
            // S3に保存。ファイル名は$storePathで定義したとおり
            Storage::disk('s3')->put($storePath1, (string) $image1->encode('png', 90), 'public');


            $task->picture1 = basename($storePath1);
        }

        // picture2未登録の場合
        if ($request->file('picture2') == '') {
            $task->picture2 = 'no_image.png';
        } elseif ($request->file('picture1') == '') {
            // picture1に画像登録した場合
            // 画像ファイルを変数に取り込む
            $imagefile1 = $request->file('picture2');
            // アップロードされたファイル名を取得
            $name1 = $imagefile1->getClientOriginalName();
            // S3の保存先のパスを生成
            $storePath1 = "tasks_image/" . $now . "_" . $name1;
            // 画像を横幅は400px、縦幅はアスペクト比維持の自動サイズへリサイズ
            $image1 = Image::make($imagefile1)
                ->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    //サイズが大きくなることを防ぐ
                    $constraint->upsize();
                });
            // S3に保存。ファイル名は$storePathで定義したとおり
            Storage::disk('s3')->put($storePath1, (string) $image1->encode('png', 90), 'public');

            $task->picture1 = basename($storePath1);
            $task->picture2 = 'no_image.png';
        } else {
            // picture2に画像登録した場合
            // 画像ファイルを変数に取り込む
            $imagefile2 = $request->file('picture2');
            // アップロードされたファイル名を取得
            $name1 = $imagefile2->getClientOriginalName();
            // S3の保存先のパスを生成
            $storePath2 = "tasks_image/" . $now . "_" . $name1;
            // 画像を横幅は400px、縦幅はアスペクト比維持の自動サイズへリサイズ
            $image1 = Image::make($imagefile2)
                ->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    //サイズが大きくなることを防ぐ
                    $constraint->upsize();
                });
            // S3に保存。ファイル名は$storePathで定義したとおり
            Storage::disk('s3')->put($storePath2, (string) $image1->encode('png', 90), 'public');

            $task->picture2 = basename($storePath2);
        }

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

        // ファイル名のタイムスタンプに使う
        $now = date_format(Carbon::now(), 'YmdHis');


        //picture1が未登録の場合
        if ($request->file('picture1') == '' && $task->picture1 == 'no_image.png') {
            $task->picture1 = 'no_image.png';
            //picture1があり、no_imageが格納されてたら
        } elseif ($request->file('picture1') != '') {
            // picture1に画像登録した場合
            // 画像ファイルを変数に取り込む
            $imagefile1 = $request->file('picture1');
            // アップロードされたファイル名を取得
            $name1 = $imagefile1->getClientOriginalName();
            // S3の保存先のパスを生成
            $storePath1 = "tasks_image/" . $now . "_" . $name1;
            // 画像を横幅は400px、縦幅はアスペクト比維持の自動サイズへリサイズ
            $image1 = Image::make($imagefile1)
                ->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    //サイズが大きくなることを防ぐ
                    $constraint->upsize();
                });
            // S3に保存。ファイル名は$storePathで定義したとおり
            Storage::disk('s3')->put($storePath1, (string) $image1->encode('png', 90), 'public');
            $task->picture1 = basename($storePath1);
        }

        //picture2を格納しようとしていて
        if ($request->file('picture2') != '') {
            //picture1は未格納でもともとno_imgだった場合
            if ($request->file('picture1') == '' && $task->picture1 == 'no_image.png') {
                //画像1が空で画像2のリクエストがあったら画像1に入れる
                $imagefile1 = $request->file('picture2');
                // アップロードされたファイル名を取得
                $name1 = $imagefile1->getClientOriginalName();
                // S3の保存先のパスを生成
                $storePath1 = "tasks_image/" . $now . "_" . $name1;
                // 画像を横幅は400px、縦幅はアスペクト比維持の自動サイズへリサイズ
                $image1 = Image::make($imagefile1)
                    ->resize(400, null, function ($constraint) {
                        $constraint->aspectRatio();
                        //サイズが大きくなることを防ぐ
                        $constraint->upsize();
                    });
                // S3に保存。ファイル名は$storePathで定義したとおり
                Storage::disk('s3')->put($storePath1, (string) $image1->encode('png', 90), 'public');

                $task->picture1 = basename($storePath1);
                $task->picture2 = 'no_image.png';
            } else {
                // picture2に画像登録した場合
                // 画像ファイルを変数に取り込む
                $imagefile2 = $request->file('picture2');
                // アップロードされたファイル名を取得
                $name1 = $imagefile2->getClientOriginalName();
                // S3の保存先のパスを生成
                $storePath2 = "tasks_image/" . $now . "_" . $name1;
                // 画像を横幅は400px、縦幅はアスペクト比維持の自動サイズへリサイズ
                $image1 = Image::make($imagefile2)
                    ->resize(400, null, function ($constraint) {
                        $constraint->aspectRatio();
                        //サイズが大きくなることを防ぐ
                        $constraint->upsize();
                    });
                // S3に保存。ファイル名は$storePathで定義したとおり
                Storage::disk('s3')->put($storePath2, (string) $image1->encode('png', 90), 'public');

                $task->picture2 = basename($storePath2);
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
