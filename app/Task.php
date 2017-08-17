<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['content', 'user_id'];

    //一対多
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
