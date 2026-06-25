<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

use App\Models\Coupon;
use App\Models\produits;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use Illuminate\Http\Request;

class CouponController extends Controller
{
   

    public function couponStore(Request $request){
    
        $coupon=Coupon::where('code',$request->code)->first();
    
        if(!$coupon){
            request()->session()->flash('error','Invalid coupon code, Please try again');
            return back();
        }
        if($coupon){

            $paniers_session = session('cart', []);
            $paniers = [];
    $total = 0;
    foreach ($paniers_session as $session){
        $produit = Produit::find($session['id_produit']);
        if ($produit) {
            $paniers[] = [
              'nom' => $produit->nom,
              'id_produit' => $produit->id,
              'photo' => $produit->photo,
              'quantite' => $session['quantite'],
              'prix' => $produit->prix,
              'total' => $session['quantite'] * $produit->prix,
            ];
            session()->put('coupon',[
                'id'=>$coupon->id,
                'code'=>$coupon->code,
                'value'=>$coupon->discount($total)
            ]);
        }
    }
           
            request()->session()->flash('success','Coupon successfully applied');
            return redirect()->back();
        }
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', $request->input('code'))->first();

        if (!$coupon) {
            return redirect()->back()->with('error', 'Coupon non valide.');
        }
        $paniers_session = session('cart', []);
        $paniers = [];

        $total = 0;
        foreach ($paniers_session as $session) {
            $produit = produits::find($session['id_produit']);

                $paniers[] = [
                    'nom' => $produit->nom,
                    'id_produit' => $produit->id,
                    'photo' => $produit->photo,
                    'quantite' => $session['quantite'],
                    'prix' => $produit->prix,
                    'total' => $session['quantite'] * $produit->prix,
                ];
                $total += $session['quantite'] * $produit->prix;
               if($coupon->type=='percent'){
              
                $discount =   ($total*$coupon->value)/100;
                 session()->put('coupon', [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                  
                    'value' => $discount,
                ]);

               }
               if($coupon->type == 'fixed') {
            
                 $discount = $coupon->value;

                 session()->put('coupon', [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                
                    'value' => $discount,
                ]);
               }
                      
        }  
        $total -=  $discount;
        return redirect()->back()->with('success', "Coupon appliqué! Réduction de {$discount}.");
    }

}
