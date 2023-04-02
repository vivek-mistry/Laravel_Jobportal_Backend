<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function list()
    {
        $category = Category::all();

        return response()->json([
            'status' => true,
            'message' => 'Found Category',
            'data'   => $category
        ]);
    }
}
