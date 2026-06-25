<?php

namespace App\Http\Controllers;

use App\Models\produits;
use App\Models\configs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class panier_client extends Controller
{
    
    public function count_panier1()
    {
        // Vérifier si la session 'panier' existe, sinon initialiser une session vide
        if (!session()->has('cart')) {
            session(['cart' => []]);
        }

        // Récupérer le panier de la session
        $panier_temporaire = session('cart');
        $total = count($panier_temporaire);
        $montant_total = 0;
        $Html = "";
        $produits = [];

        foreach ($panier_temporaire as $data) {
            $produit = produits::select('id','photo','prix','nom','taille')->find($data['id_produit']);
            if ($produit) {
                $produits[] = [
                    'id_produit' => $produit->id,
                    'nom' => $produit->nom,
                    'photo' => Storage::url($produit->photo),
                    'quantite' => $data['quantite'],
                    'taille' => $data['taille'],
                    'prix' => $produit->prix,
                    'total' => $data["quantite"] * $produit->prix,
                ];
                $montant_total += $data["quantite"] * $produit->prix;
            }
            $Html = view('components.cart',['produits' => $produits])->render();
        }
       

        return response()->json(
            [
                "total" => $total,
                "html" => $Html,
                "montant_total" => $montant_total
            ]
        );
    }
    public function count_panier()
    {
        // Vérifier si la session 'panier' existe, sinon initialiser une session vide
        if (!session()->has('cart')) {
            session(['cart' => []]);
        }

        // Récupérer le panier de la session
        $panier_temporaire = session('cart');
        $total = count($panier_temporaire);
        $list = [];
        $montant_total = 0;

        foreach ($panier_temporaire as $data) {
            $produit = produits::select('id','photo','prix','nom')->find($data['id_produit']);
            if ($produit) {
                
                $list[] = [
                    '
                    
                                <li class="single-item"  >
                                    <div class="item-area" >
                                       <div class="item-img">
                                           <img src="'.Storage::url($produit->photo).'" alt="">
                                       </div>
                                       <div class="content-and-quantity">
                                           <div class="content">
                                               <div
                                                   class="price-and-btn d-flex align-items-center justify-content-between">
                                                   <span>'.$produit->getPrice().' DT</span>
                                                   <button class="close-btn">
                                                      <a href="#"class="cart-item__remove"
                                   onclick="DeleteToCart('.$produit->id.')">
                                   
                                     <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        width="15" style=" fill:red" height="15"
                                                        fill="currentColor">
                                                        <path
                                                            d="M6.45455 19L2 22.5V4C2 3.44772 2.44772 3 3 3H21C21.5523 3 22 3.44772 22 4V18C22 18.5523 21.5523 19 21 19H6.45455ZM13.4142 11L15.8891 8.52513L14.4749 7.11091L12 9.58579L9.52513 7.11091L8.11091 8.52513L10.5858 11L8.11091 13.4749L9.52513 14.8891L12 12.4142L14.4749 14.8891L15.8891 13.4749L13.4142 11Z">
                                                        </path>
                                                    </svg>
                                </a>
                                                   </button>
                                               </div>
                                               <p><a href="#">'. Str::limit($produit->nom, 15) .'</a></p>
                                           </div>
                                           <div class="quantity-area">
                                           <div class="quantity">
                                            <a href="#" class="quantity__minus" onclick="changeQuantity(' . $produit->id . ', ' . max(1, $data['quantite'] - 1) . ')">
                                        <span><i class="bi bi-dash"></i></span>
                                    </a>
                                    <input name="quantity" type="text" class="quantity__input" value="' . $data['quantite'] . '" onchange="changeQuantity(' . $produit->id . ', this.value)">
                                    <a href="#" class="quantity__plus" onclick="changeQuantity(' . $produit->id . ', ' . ($data['quantite'] + 1) . ')">
                                        <span><i class="bi bi-plus"></i></span>
                                    </a>

                                               
                                           </div>
                                       </div>
                                   </div> 
                               </li>
                  
                            '
                ];
                $montant_total += $data["quantite"] * intval($produit->getPrice());
            }
        }

        return response()->json(
            [
                "total" => $total,
                "list" => $list,
                "montant_total" => $montant_total
            ]
        );
    }

    public function updateQuantity(Request $request)
    {
        $panier = session('cart', []);
    
        foreach ($panier as &$item) {
            if ($item['id_produit'] == $request->id_produit) {
                $item['quantite'] = max(1, intval($request->quantite));  // Assurer que la quantité est au moins 1
                break;
            }
        }
    
        session(['cart' => $panier]);
    
        // Retourner la mise à jour du panier
        return $this->count_panier();
    }
    


    public function cart()
    {
      //  $configs = configs::first();
        return view('front.cart.cart');
    }



    public function add(Request $request)
    {
        $id_produit = $request->input('id_produit');
        $type = $request->input('type', 'produit');
        $quantite = $request->input('quantite', 1);
        

        $user = Auth::user();


        $produit = produits::where('id', $id_produit)
            ->first();


        //verifier que le produit existe et est disponible
        if (!$produit) {
            return response()->json([
                'statut' => false,
                'message' => "Le produit est  introuvable !",
            ]);
        }


        if ($produit->statut == "disponible") {
            return response()->json([
                'statut' => false,
                'message' => " Le produit est  indisponible !",
            ]);
        }

         //si l'user est un grossite on ajute sa quantite si il a prix moind de la quantite_minimal_grossiste	
         if ($user && $user->role == "grossiste") {
            if ($quantite < $produit->quantite_minimal_grossiste) {
                $quantite = $produit->quantite_minimal_grossiste ;
            }
        }else{
            $quantite = $request->input('quantite', 1);
        }


        //verifier que le stock demander est disponible
        if ($produit->stock < $quantite) {
            return response()->json([
                'statut' => false,
                'message' => "Quantité insuffisante en stock !",
            ]);
        }

       


        $panier = session('cart', []);
        $produit_existe = false;

        foreach ($panier as &$item) {
            if ($item['id_produit'] == $id_produit) {
                $item['quantite'] += $quantite;
                
                $produit_existe = true;
                break;
            }
        }

        if (!$produit_existe) {
            $panier[] = [
                'id_produit' => $id_produit,
                'quantite' => $quantite,
            ];
        }

        session(['cart' => $panier]);

        return response()->json([
            'statut' => true,
            'message' => " Le produit ajouté au panier"
        ]);
    }


    public function delete_produit(Request $request)
    {
        
        $id_produit = $request->input('id_produit');
        $panier = session('cart', []);
        foreach ($panier as $key => $item) {
            if ($item['id_produit'] == $id_produit) {
                unset($panier[$key]);
                break;
            }
        }
        session(['cart' => $panier]);
        return response()->json([
            "statut" => true,
            "message" => "produit supprimé",
        ]);
    }








}
