<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\TopicResource;
use App\Models\User;
use App\Models\Topic;

class TopicsController extends Controller
{
    public function index()
    {
        $topics = $query->paginate();

        return TopicResource::collection($topics);
    }

    public function show()
    {

    }
}
