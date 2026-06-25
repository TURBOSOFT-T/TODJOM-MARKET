<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'start',
        'end',
        'limit',
        'description',
        'image',
        'user_id',
        'category_id',
        'telephone',
        'heure',
        'location',
        'country',
        'type',
        'adresse',
        'active',
        'meta_description',
      

    ];
   
    public function user()
    {
        return $this->belongsTo(User::class);
    }



public function inscriptions()
{
    return $this->hasMany(Inscription::class, 'event_id', 'id');
}
   


public function vehicules()
{
    return $this->belongsToMany(Vehicule::class);
}
}
