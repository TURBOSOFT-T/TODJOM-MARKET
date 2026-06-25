<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    protected $fillable = [
        'frais',
        'ville',
       
 
     ];



     public function commandes(){
         return $this->hasMany(commandes::class, 'transport_id', 'id');
     }
}
