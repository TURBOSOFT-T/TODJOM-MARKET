<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends BaseController
{
    //
   public function store(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    // Vérifier doublon
    $exists = Subscriber::where('email', $request->email)->exists();

    if ($exists) {
        return response()->json([
            'success' => false,
            'message' => 'Cet email est déjà abonné.'
        ], 409); // 409 = Conflict
    }

    $subscriber = Subscriber::create([
        'email' => $request->email,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Abonnement réussi.',
        'data' => $subscriber
    ], 201);
}
}
