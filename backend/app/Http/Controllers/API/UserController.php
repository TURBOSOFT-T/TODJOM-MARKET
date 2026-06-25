<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserInfo;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;

class UserController extends  BaseController
{


  public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getuser', 'updateProfile', 'login', 'register']]);
    }
    // LISTE
    public function updateProfile(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'nom' => 'required',
        'email' => 'required|email',
        'avatar' => 'nullable|image',
    ]);

    if ($request->hasFile('avatar')) {

        if ($user->avatar && file_exists(public_path('Image/Users/' . $user->avatar))) {
            unlink(public_path('Image/Users/' . $user->avatar));
        }

        $image = $request->file('avatar');
        $filename = time() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('Image/Users'), $filename);

        $user->avatar = $filename;
    }

    $user->nom = $request->nom;
    $user->email = $request->email;
    $user->phone = $request->phone;
    
    $user->adresse = $request->adresse;
   

    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'Profil mis à jour avec succès',
        'user' => $user
    ]);
}

    // AJOUT

}