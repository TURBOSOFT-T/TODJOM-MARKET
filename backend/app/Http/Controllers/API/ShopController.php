<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Models\Shop;
use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;


use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use App\Models\User;

use App\Mail\VerifyEmail;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;


use Guzzle\Http\Message\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator as ValidationValidator;
use JsonException;
use Illuminate\Support\Facades\Validator;

use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;




class ShopController extends BaseController
{
  public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getseller', 'logout', 'login_shop','updateAvatar' ,'create_shop','update_seller_info']]);
    }

    public $successStatus = 200;

      /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */
    public function create_shop(Request $request)
    {
        // 🔥 CHECK EMAIL AVANT TOUT
        $userExists = Shop::where('email', $request->email)->first();

        if ($userExists) {
            return response()->json([
                'success' => false,
                'message' => 'Cet email existe déjà........'
            ], 409);
        }

        // VALIDATION
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|email|unique:shops,email',
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ], [
            'email.unique' => 'Cet email est déjà utilisé.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // UPLOAD AVATAR
        $avatarName = null;

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $avatarName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('Image/Shops'), $avatarName);
        }

    
        $seller = Shop::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'adresse' => $request->adresse,
            'password' => Hash::make($request->password),
            'avatar' => $avatarName,

        ]);

        
        $token = $seller->createToken('myapptoken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Compte créé avec succès',
            'token' => $token,
            'user' => $seller
        ], 201);
    }
  /*
    |--------------------------------------------------------------------------
    | SELLER INFO
    |--------------------------------------------------------------------------
    */
public function getseller(Request $request)
{
    $seller = $request->user();

    if (!$seller) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized'
        ], 401);
    }

    return response()->json([
        'success' => true,
        'data' => [
            'seller' => $seller
        ]
    ]);
}


  /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */
public function login_shop(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors(),
        ], 422);
    }

    $shop = Shop::where('email', $request->email)->first();

    if (!$shop || !Hash::check($request->password, $shop->password)) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials',
        ], 401);
    }

    $token = $shop->createToken('shop_token')->plainTextToken;

    return response()->json([
        'success' => true,
        'token' => $token,
        'seller' => $shop,
    ]);
}


    public function profile(Request $request)
    {
        return response()->json([

            'status' => true,

            'shop' => $request->user(),

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PROFILE
    |--------------------------------------------------------------------------
    */
public function update_seller_info(Request $request)
{
  
 $shop = auth('shop')->user();

    if (!$shop) {
        return response()->json([
            'message' => 'Unauthorized..........'
        ], 401);
    }

    $shop->update([
        'name' => $request->name,
        'description' => $request->description,
        'phone' => $request->phone,
        'whatsapp' => $request->whatsapp,
        'adresse' => $request->adresse,
        'location' => $request->location,
        'code_postal' => $request->code_postal,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Profil mis à jour',
        'shop' => $shop,
    ]);
}
    
    /*
    |--------------------------------------------------------------------------
    | UPDATE AVATAR
    |--------------------------------------------------------------------------
    */

    public function updateAvatar(Request $request)
{
     
 $shop = auth('shop')->user();

    if (!$shop) {
        return response()->json([
            'message' => 'Unauthorized..........'
        ], 401);
    }
if ($request->avatar) {

        $image = $request->avatar;

        // enlever header base64
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace('data:image/jpeg;base64,', '', $image);
        $image = str_replace(' ', '+', $image);

        $filename = time() . '.png';

        $path = public_path('Image/Shops/');

        // 🔥 SUPPRESSION ANCIENNE IMAGE
        if ($shop->avatar && file_exists($path . $shop->avatar)) {
            unlink($path . $shop->avatar);
        }

        // 🔥 SAUVEGARDE NOUVELLE IMAGE
        file_put_contents($path . $filename, base64_decode($image));

        // update DB
        $shop->avatar = $filename;
        $shop->save();
    }

    return response()->json([
        'status' => true,
        'avatar' => asset('Image/Shops/' . $shop->avatar),
    ]);
}

    /*
    |--------------------------------------------------------------------------
    | UPDATE COVER
    |--------------------------------------------------------------------------
    */

    public function updateCover(Request $request)
    {
        $request->validate([
            'cover' => 'required|image|mimes:jpg,jpeg,png,webp',
        ]);

        $shop = $request->user();

        if ($request->hasFile('cover')) {

            $file = $request->file('cover');

            $filename = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('Image/Shops'), $filename);

            $shop->cover = $filename;

            $shop->save();
        }

        return response()->json([

            'status' => true,

            'message' => 'Cover mise à jour',

            'cover' => asset('Image/Shops/'.$shop->cover),

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */


    public function logoutSeller(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([

            'status' => true,

            'message' => 'Déconnexion réussie',

        ]);
    }
}






