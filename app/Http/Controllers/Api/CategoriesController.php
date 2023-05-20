<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index(Category $category)
    {
        CategoryResource::wrap('data');
        return CategoryResource::collection($category->categories());
    }
}
