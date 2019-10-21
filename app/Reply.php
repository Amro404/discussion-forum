<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = ["content", "discussion_id"];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function discussion()
    {
    	return $this->belongsTo(Discussion::class, "discussion_id");
    }
}
