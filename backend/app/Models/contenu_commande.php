<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contenu_commande extends Model
{
    use HasFactory;
protected $table ='contenu_commandes';
    protected $fillable = [
      'id_produit',
        'id_commande',
        'id_pack',
        'quantite',
        'total_gain_points',
        'prix_unitaire',
        'prix',
        'quantity',
        'benefice',
       
        'commercial_id'
    ];

       public function commercial(){
        return $this->belongsTo(User::class ,'commercial_id')->withDefault();
    }

    public function produits(){
        return $this->belongsTo(produits::class ,'id_produit')->withDefault();
    }
    public function produit(){
        return $this->belongsTo(produits::class ,'id_produit')->withDefault();
    }

    public function commandes(){
        return $this->belongsTo(commandes::class ,'id_commande');
    }
   
    public function pack(){
        return $this->belongsTo(packs::class ,'id_pack');
    }

}
