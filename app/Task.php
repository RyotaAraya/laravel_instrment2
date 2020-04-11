<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['plant_name', 'tag_no', 'trouble_content', 'details_repair','task_status', 'picture1', 'picture2'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
