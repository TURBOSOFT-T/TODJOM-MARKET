<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\produits;
  
class ProductController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $products = produits::all();
        return view('products', compact('products'));
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function cart()
    {
        return view('front.cart.cart');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function addToCart($id)
    {
        $product = produits::findOrFail($id);
          
        $cart = session()->get('cart', []);
  
        if(isset($cart[$id])) {
            $cart[$id]['quantite']++;
        } else {
            $cart[$id] = [
                "nom" => $product->name,
                "quantite" => 1,
                "prix" => $product->price,
                "photo" => $product->image
            ];
        }
          
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produit ajouté ao panier avec succèss');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function update(Request $request)
    {
        if($request->id && $request->quantite){
            $cart = session()->get('cart');
            $cart[$request->id]["quantite"] = $request->quantite;
            session()->put('cart', $cart);
            session()->flash('success', 'Cart updated successfully');
        }
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Product removed successfully');
        }
    }
}