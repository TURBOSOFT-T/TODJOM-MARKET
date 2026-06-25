<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\config;

class ConfigController  extends BaseController
{
     public function index()
    {
        $config = config::first(); // ou ->latest()->first()

        if (!$config) {
            return response()->json([
                'success' => false,
                'message' => 'Aucune configuration trouvée',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $config,
        ], 200);
    }
}
