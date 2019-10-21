<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;

class ChannelsController extends Controller
{
    public function index(Channel $channel)
    {
    	 return view("discussions.index", [
            "discussions" => $channel->discussions()->paginate(3)
        ]);
    }
}
