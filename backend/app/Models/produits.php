<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class produits extends Model
{
    use HasFactory,SoftDeletes;
   
  
    protected $fillable = [
    
    'nom',
    'description',
   'reference',
'prix', 
   'prix_achat',
    'photo',
   'id_promotion',
  'category_id',
  'id_shop',
    'stock',
    'statut',
    'photos',
    'free_shipping  ',
    'top',
    'active',
    'new',
     'points'
    ];
    protected $casts = [
        'photos' => 'json',
    ];

    protected $appends = [
    'final_price',
    'has_promotion',
    'total_sold',
    'slug',
    
];
    public function shop()
{
    return $this->belongsTo(Shop::class,'id_shop' );
}
public function promotion()
{
    return $this->belongsTo(promotions::class, 'id_promotion');
}
   public function vendus()
    {
        return $this->hasMany(contenu_commande::class, 'id_produit');
    }


public function getPrice()
{
    if ($this->promotion && $this->promotion->pourcentage) {
        return $this->prix - ($this->prix * $this->promotion->pourcentage / 100);
    }

    return $this->prix;
}

public function getFinalPriceAttribute()
{
    return $this->getPrice();
}

public function getHasPromotionAttribute()
{
    return $this->promotion !== null;
}

public function getTotalSoldAttribute()
{
    return $this->vendus()->sum('quantite') ?? 0;
}

public function getTotalSoldAttribute1()
{
    return $this->vendus()->count();
}
    public function getPrice1()
    {
        if ($this->id_promotion) {
            $promotion = promotions::find($this->id_promotion);
            if ($promotion) {
                $price = $this->prix - ($this->prix * ($promotion->pourcentage / 100));
                return $price;
            } else {
                return $this->prix;
            }
        } else {
            return $this->prix;
        }

    }

    public function inPromotion()
    {
        if ($this->id_promotion) {
            $promotion = promotions::find($this->id_promotion);
            if ($promotion) {
                return $promotion;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function diminuer_stock(int $quantite): void
    {
        if ($this->stock >= $quantite) {
            $this->stock -= $quantite;
            $this->save();
        }
    }

    public function retourner_stock(int $quantite): void
    {
        $this->stock += $quantite;
        $this->save();
    }
    

    public function historique_stock(){
        return $this->hasMany(historiques_stock::class, 'id_produit');
    }


    public function vues()
    {
        return $this->hasMany(views::class, 'id_produit');
    }


   public function category()
{
    return $this->belongsTo(Category::class, 'category_id', 'id');
}

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function marques()
    {
        return $this->belongsTo(Marque::class, 'marque_id', 'id');
    }


public function getSlugAttribute()
{
    return \Str::slug($this->nom . '-' . $this->id);
}

}
