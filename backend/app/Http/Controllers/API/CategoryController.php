<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Category;
use App\Models\config;


class CategoryController  extends BaseController
{
   public function index()
{
    $categories = Category::latest()->get();

    $categories->transform(function ($category) {
        $category->photo_url = $category->photo
            ? asset('storage/' . $category->photo)
            : null;

        return $category;
    });

    return response()->json([
        'success' => true,
        'data' => $categories
    ]);
}
}