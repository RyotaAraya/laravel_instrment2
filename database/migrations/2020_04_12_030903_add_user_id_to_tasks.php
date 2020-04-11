<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            //statementメソッドの引数に指定した処理を実施する
            DB::statement('DELETE FROM tasks');
            //tasksテーブルにuser_idカラムを作る
            $table->unsignedBigInteger('user_id');
            //外部キーを設定
            //references user_idと紐づくものを指定、id usersテーブル
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            //外部キー付きのカラムを削除するには、必ず外部キー制約を外す必要がある
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id']);
        });
    }
}
