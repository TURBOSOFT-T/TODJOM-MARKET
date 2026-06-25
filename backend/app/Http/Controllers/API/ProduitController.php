<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\produits;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\API\BaseController;

class ProduitController  extends BaseController
{
    // LISTE
    public function index()
    {
        $produits = produits::with(['shop', 'category','promotion'])->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $produits
        ]);
    }

    public function get_all_products()
{
    $products = produits::with(['shop', 'promotion','vendus'])
        ->latest()
       
        ->get();

    return response()->json([
        'success' => true,
        'products' => $products
    ]);
}
public function search(Request $request)
{
    $search = $request->search;

    $products = produits::where('nom', 'LIKE', "%{$search}%")
        ->orWhere('reference', 'LIKE', "%{$search}%")
        ->get();

    return response()->json($products);
}

public function searchProducts(Request $request)
{
    $query = $request->input('q');

    $products = produits::where('nom', 'LIKE', "%$query%")
        ->orWhere('reference', 'LIKE', "%$query%")
        
->orWhere('description', 'LIKE', "%$query%")
        ->with(['category', 'shop'])
        ->get();

    return response()->json([
        'success' => true,
        'data' => $products
    ]);
}
/////////////////PRODUITS PAR CAT

public function productsByCategory($id)
{
    $products = produits::with('category')
        ->where('category_id', $id)
        ->latest()
        ->get();

    return response()->json([
        'success' => true,
        'data' => $products
    ]);
}
 // ================= PRODUITS D'UN SHOP =================
public function getShopProducts($id)
{
    $products = produits::with(['shop','promotion','vendus'])->where('id_shop', $id)
   
        ->latest()
        ->get();

    return response()->json([
        'success' => true,
        'products' => $products
    ]);
}

public function getBestSellingProducts()
{
    $products = produits::with(['shop', 'promotion', 'vendus'])
        ->whereHas('vendus')
        ->withSum('vendus as total_sold', 'quantite')
        ->orderByDesc('total_sold')
        ->get();

    return response()->json([
        'success' => true,
        'products' => $products
    ]);
}

public function getHomeProducts()
{
    $products = produits::with(['shop', 'promotion','vendus'])
        ->latest()
        ->take(10)
        ->get();

    return response()->json([
        'success' => true,
        'products' => $products
    ]);
}
 public function getByShop($id)
{
    $produits = produits::where('id_shop', $id)
        ->with(['shop', 'category'])
        ->latest()
        ->get();

    return response()->json([
        'success' => true,
        'data' => $produits
    ]);
}
public function produits_shop($id_shop)
{
    $produits = produits::with([
            'shop',
            'category'
        ])
        ->where('id_shop', $id_shop)
        ->latest()
        ->get();

    return response()->json([
        'success' => true,
        'total' => $produits->count(),
        'data' => $produits
    ]);
}
    // CREATEuse Illuminate\Support\Facades\Storage;

public function create_product(Request $request)
{
   $request->validate([
        'nom' => 'required',
        'reference' => 'required|unique:produits',
        'prix' => 'required|numeric',
        'prix_achat' => 'required|numeric',
        'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,webp'
    ]);

    // ================= MAIN PHOTO =================
    $photoPath = null;

    if ($request->hasFile('photo')) {
        $photoPath = $request->file('photo')->store('produits', 'public');
    }

    // ================= GALLERY =================
    $photosPath = [];

    if ($request->hasFile('photos')) {
        foreach ($request->file('photos') as $file) {
            $photosPath[] = $file->store('produits/gallery', 'public');
        }
    }

    $produit = produits::create([
        'nom' => $request->nom,
        'description' => $request->description,
        'reference' => $request->reference,
        'prix' => $request->prix,
        'prix_achat' => $request->prix_achat,
        'photo' => $photoPath,
        'photos' => json_encode($photosPath),
        'category_id' => $request->category_id,
        'id_shop' => $request->id_shop,
        'stock' => $request->stock ?? 0,
    ]);

    return response()->json([
        'success' => true,
        'dak' => $produit
    ]);
}
    // SHOW
    public function show($id)
    {
        $produit = produits::with(['shop', 'category'])->find($id);

        if (!$produit) {
            return response()->json([
                'success' => false,
                'message' => 'Produit introuvable'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $produit
        ]);
    }


public function update(Request $request, $id)
{
     $produit = produits::find($id);

    if (!$produit) {
        return response()->json(['message' => 'Produit introuvable'], 404);
    }

    // ================= MAIN PHOTO =================
    if ($request->hasFile('photo')) {

        if ($produit->photo && Storage::disk('public')->exists($produit->photo)) {
            Storage::disk('public')->delete($produit->photo);
        }

        $produit->photo = $request->file('photo')->store('produits', 'public');
    }

    // ================= GALLERY =================
    if ($request->hasFile('photos')) {

        $oldPhotos = json_decode($produit->photos, true) ?? [];

        foreach ($oldPhotos as $old) {
            if (Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
        }

        $newPhotos = [];

        foreach ($request->file('photos') as $file) {
            $newPhotos[] = $file->store('produits/gallery', 'public');
        }

        $produit->photos = json_encode($newPhotos);
    }

    $produit->update($request->except(['photo', 'photos']));

    return response()->json([
        'success' => true,
        'data' => $produit
    ]);
}
    // DELETEuse Illuminate\Support\Facades\Storage;
public function delete_shop_product($id)
{
    $produit = produits::find($id);

    if (!$produit) {
        return response()->json(['message' => 'introuvable'], 404);
    }

    // main photo
    if ($produit->photo && Storage::disk('public')->exists($produit->photo)) {
        Storage::disk('public')->delete($produit->photo);
    }

    // gallery
    $photos = json_decode($produit->photos, true) ?? [];

    foreach ($photos as $p) {
        if (Storage::disk('public')->exists($p)) {
            Storage::disk('public')->delete($p);
        }
    }

    $produit->delete();

    return response()->json([
        'success' => true
    ]);
}
}