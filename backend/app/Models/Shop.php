<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Mail;

use Illuminate\Contracts\Auth\MustVerifyEmail;



class Shop extends Authenticatable
{



    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles, SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'email',
        'avatar',
        'cover',
        'password',
        'adresse',

        'whatsapp',
        'location',
        'phone',
        'code_postal',
        'role',
        'two_factor_code',
        'two_factor_expires_at',
        'token',
        'statut',
        'top',
        'active',
        'isbarn',

    ];
public function produits()
{
    return $this->hasMany(produits::class, 'id_shop');
}
    public function resetTwoFactor()
    {
        $this->update([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function avatar()
    {
        if (is_null($this->avatar)) {
            return "/icons/default-no-profile-pic.webp";
        } else {
            return Storage::url($this->avatar);
        }
    }








    public function getIsAdminAttribute()
    {
        $admins = User::where('role', 'seller')
            ->get();

        // return $this->role()->where('id', 1)->exists();
        return $this->$admins;
    }

    public function isSeller()
    {
        return $this->role === 'seller'; // ou selon ton système (ex: 'is_admin' == true)
    }
}
