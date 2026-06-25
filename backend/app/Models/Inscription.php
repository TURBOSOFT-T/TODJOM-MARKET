<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = [
     'formation_id',
        'nom',
        'prenom',
        'addresse',
        'ville',
        'message',
        'telephone',
      
        'email',
        'staut',
        'etat',
        'mode',
        'note',
        'user_id',
        'event_id',
        'vehicule_id',
      
        'type',
        'option',
        'country_id',
        'state_id',
        'city_id',
        'prix',
        'nbrplace',
        'prix_aller_retour',
        'prix_retour',
        'prix_aller',
        'nbrjours',
        'prix_total'

    ];

    

   
    public function city(){
        return $this->belongsTo(City::class,'city_id');
    }

     public function formation()
    {
        return $this->belongsTo(Formation::class , 'formation_id', 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class , 'event_id', 'id');
    }

      public function vehicule()
    {
        return $this->belongsTo(Vehicule::class , 'vehicule_id', 'id');
    }


 
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function contenus()
    {
        return $this->hasMany(Contenu_Inscription::class, 'inscription_id');
    }

}
