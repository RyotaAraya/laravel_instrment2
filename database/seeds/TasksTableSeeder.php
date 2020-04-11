<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            DB::table('tasks')->insert([
                'plant_name' => $i.'BH',
                'tag_no' => 'FIC-'.$i,
                'trouble_content' => '指示不審',
                'details_repair' => 'ノズル貫通',
                'task_status' => '完了',
                'picture1' => 'no_image.png',
                'picture2' => 'no_image.png',
                'delete_flg' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_id' => 1
            ]);
        }
    }
}
