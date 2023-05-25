<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Link;
use App\Http\Resources\LinkResource;

class LinksController extends Controller
{
    public function index(Link $link)
    {
        $links = $link->getAllCached();

        LinkResource::wrap('data');
        return LinkResource::collection($links);
    }
}
