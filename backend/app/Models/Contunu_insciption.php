<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenu_Inscription extends Model
{
    use HasFactory;
    protected $table ='contenu_inscriptions';
        protected $fillable = [
            'formation_id',
            'inscription_id',
            'event_id',
            'quantite',
            'prix_unitaire',
            'prix',
            'quantity',
            'benefice',
            'type',
        ];
    
        public function formations(){
            return $this->belongsTo(Formation::class ,'formation_id')->withDefault();
        }
        public function event(){
            return $this->belongsTo(Event::class ,'event_id')->withDefault();
        }
    
        public function inscriptions(){
            return $this->belongsTo(Inscription::class ,'inscription_id');
        }
       
      
    
}
