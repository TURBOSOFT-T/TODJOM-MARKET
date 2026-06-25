<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Controllers\Controller;
use App\Models\Banners;

class BannerController extends BaseController
{
    public function index()
    {
        $banners = Banners::latest()->get();

        return response()->json([
            'success' => true,
            'banners' => $banners
        ]);
    }
}