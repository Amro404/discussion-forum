<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\ReplyMarkedAsBestReply;



class Discussion extends Model
{
    protected $fillable = ["title", "content", "channel_id" ,"slug", "reply_id"];

    public function user()
    {
    	return $this->belongsTo(User::class, "user_id");
    }

    public function replies()
    {
    	return $this->hasMany(Reply::class);
    }

    public function bestReply()
    {
        return $this->belongsTo(Reply::class, "reply_id");
    }

    public function scopeFilterByChannels($builder)
    {
        if(request()->query("channel"))
        {
            $channel = Channel::where("slug", request()->query("channel"))->first();

            if($channel)
            {
                return $builder->where("channel_id", $channel->id);
            }

            return $builder;
        }
    }

    public function getRouteKeyName()
    {
    	return "slug";
    }

    public function markAsBestReply(Reply $reply)
    {
        $this->update([
            "reply_id" => $reply->id
        ]);

        if ($reply->user->id == $this->user_id) {
           return 0;
        }

        $reply->user->notify(new ReplyMarkedAsBestReply($reply->discussion));
       
    }
}
