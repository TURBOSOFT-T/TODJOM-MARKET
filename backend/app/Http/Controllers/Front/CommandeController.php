<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;



use App\Http\Requests\commandes\CommandesRequest;
use Illuminate\Http\Request;
use App\Models\{commandes, produits,Coupon, contenu_commande, config, Historique_points, notifications, Transaction, Transport, User};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;
//use Illuminate\Support\Facade\Mail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\OrderMail;
use App\Mail\FirstOrder;
use Illuminate\Support\Facades\DB;
use App\Notifications\NewOrder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Contracts\Mail\Mailable;
use App\Services\PayUService\Exception;
use Illuminate\Validation\ValidationException;

use App\Http\Traits\ListGouvernorats ;


class CommandeController extends Controller
{

  public $cart;
  use ListGouvernorats;


 /*  public function __construct()
  {
    $this->middleware('auth');
  } */



  public function commander()
  {
    $configs = config::firstOrFail();
   // $paniers_session = session('cart');

   $paniers_session = session('cart', []);

  // Vérifier que $paniers_session est bien un tableau
  if (!is_array($paniers_session)) {
      $paniers_session = [];
  }
    $paniers = [];
    $total = 0;
    if(empty($paniers_session)){
      request()->session()->flash('error','La panier est vide !');
      return back();
  }

    
  if (session()->has('coupon')) {
    $coupon = session()->get('coupon');
    $value = Coupon::where('code', $coupon)->first();
    $discuont = session('coupon')['value'];
 
}

    foreach ($paniers_session as $session) {
      $produit = produits::find($session['id_produit']);
      if ($produit) {
        $paniers[] = [
          'nom' => $produit->nom,
          'id_produit' => $produit->id,
          'photo' => $produit->photo,
          'quantite' => $session['quantite'],
          'prix' => $produit->getPrice(),
          'total' => $session['quantite'] * $produit->getPrice(),
        ];
        if (session()->has('coupon')) {
        $total += $session['quantite'] * $produit->getPrice() - session('coupon')['value'];
        }else{
        $total += $session['quantite'] * $produit->getPrice();
        }
       
     //  dd($total);
      }
    }
   
   $gouvernorats = $this->getListGouvernorat();
      $transports = Transport ::all();

    return view('front.commandes.checkout', compact('configs', 'paniers', 'total','gouvernorats','transports'));
  }





  public function confirmOrder(Request $request)
  {
    $data =   $request->validate([

      'nom' => ['nullable', 'string', 'max:255'],
      'prenom' => ['nullable', 'string', 'max:255'],
      'email' => 'required',
      'coupon' => 'nullable|numeric',
      'buy_with_point' => 'nullable|boolean',
      'phone' => 'required',
      'mode' => 'nullable|string|in:espèce,orange money,momo,solde,points',
      'transport_id' => 'nullable|exists:transports,id',
    ]);


    $transport = null;
if ($request->type_commande === 'livraison') {
    $transport = Transport::findOrFail($request->transport_id);
}
//$transport = Transport::findOrFail($request->transport_id);
    $connecte = Auth::user();
    $configs = config::firstOrFail();

    $total_gain_points = 0;
    $historiquePoints = [];
   
    $reference = 'CMD-' . date('Ymd') . '-' . strtoupper(Str::random(6));

    if (Auth::check()) {
      $userId = Auth::id();
    } else {
      $user = User::where('email', $request->email)->first();

      if (!$user) {
        $temporaryPassword = Str::random(8);
        $user = User::create([
          'nom' => $request->input('nom'),
          'prenom' => $request->input('prenom'),
          'email' => $request->input('email'),

          'password' => Hash::make($request->input('phone')),
          // 'password' => Hash::make($temporaryPassword),
          'phone' => $request->input('telephone'),
        ]);

        // Mail::to($user->email)->send(new WelcomeUserMail($user, $temporaryPassword));
      }

      $userId = $user->id;
    }
    // Calcul du total de la commande
    $paniers_session = session('cart', []);
    if (empty($paniers_session)) {
      return back()->withErrors(['cart' => 'Le panier est vide !']);
    }

    $totalCommande = 0;
    foreach ($paniers_session as $item) {
      $produit = produits::find($item['id_produit']);
      if ($produit) {
        $totalCommande += $produit->getPrice() * $item['quantite'];
      }
    }

    

   

    // Appliquer coupon
    $totalCommande -= session('coupon')['value'] ?? 0;
// Ajouter frais de transport si livraison
$totalCommande += $transport->frais ?? 0;

    // Vérification solde si mode = solde
    if ($data['mode'] === 'solde') {
      $user = User::where('email', $request->email)->first();

      if ($user->solde < $totalCommande) {
        // Stocker l'erreur dans la session
        return redirect()->back()->with('swal_error', 'Votre solde est insuffisant pour cette commande.');
      }

      $user->solde -= $totalCommande;
      $user->save();
      Transaction::create([
        'user_id' => $user->id,
        'montant' => $totalCommande,
        'type' => 'Debit',
        'description' => 'Paiement pour une commande',
      ]);
    }

    if ($data['mode'] === 'points') {
      $user = User::where('email', $request->email)->first();

      if ($user->points < $totalCommande) {
        return redirect()->back()->with('swal_error', 'Votre total de points est insuffisant pour cette commande.');
      }
    }

    $order = new commandes([
      'user_id' => $userId,
     
      'reference' => $reference,
      'nom' => $request->input('nom'),
      'prenom' => $request->input('prenom'),
      'email' => $request->input('email'),
      'adresse' => $request->input('adresse'),
      'phone' => $request->input('phone'),
      'pays' => $request->input('pays'),
      'note' => $request->input('note'),
     
     // 'mode' => $request->input('mode'),
     'mode' => $request->mode,
     // 'transport_id' => $transport->id,

//'frais' => $transport->frais ?? 0,
    //  'frais' => $request->type_commande === 'table' ? 0 : ($configs->frais ?? 0),
      'coupon' => isset(session('coupon')['value']) ? session('coupon')['value'] : null,
     // 'montant_total' => $totalCommande,
    //  'montant_total' => $totalCommande + $transport->frais ?? 0,

      'type_commande' => $request->type_commande,
    'transport_id' => $transport->id ?? null,
    'frais' => $transport->frais ?? 0,
    //'coupon' => session('coupon')['value'] ?? null,
    'montant_total' => $totalCommande,
    ]);

    if ($request->mode === 'solde') {
      $order->etat = 'confirmé';
      $order->statut = 'traitement';
      $order->solde_utilise = $totalCommande;
      $order->mode = 'solde';
    }

    if ($request->mode === 'points') {
      $order->etat = 'confirmé';
      $order->statut = 'traitement';
      $order->points_utilise = $totalCommande;
      $order->mode = 'points';

      $connecte->points -= $totalCommande;
      $connecte->save();
    }

    $order->save();

    $existingUsersWithEmail = User::where('email', $request['email'])->exists();

    if (!$existingUsersWithEmail) {
      // Mail::to($user->email)->send(new FirstOrder($user));
      // $user->save();
    }

    $paniers_session = Session::get('cart') ?? [];
   

    foreach ($paniers_session as $session) {
      $produit = produits::find($session['id_produit']);
      if ($produit) {
        $contenu =  $contenu = new contenu_commande();
        $contenu->id_commande = $order->id;
        $contenu->id_produit =  $produit->id;
       
        $contenu->prix_unitaire = $produit->getPrice();
        $contenu->quantite = $session['quantite'];
        $contenu->benefice = ($produit->getPrice() - $produit->prix_achat) * $session['quantite'];

        $contenu->total_gain_points += $produit->points * $session['quantite'];
        $contenu->save();

        $total_gain_points += $produit->points * $session['quantite'];

        $historiquePoints[] = [
          "produit_id" => $produit->id,
          "montant" => $produit->points,
        ];

        $produit->diminuer_stock($session['quantite']);
      }
    }

    if ($connecte) {
      foreach ($historiquePoints as $historique) {
        $his = new Historique_points();
        $his->user_id = $connecte->id;
        $his->produit_id = $historique['produit_id'];
        $his->commande_id = $order->id;
        $his->montant = $produit->points * $session['quantite'];
        $his->save();
      }
    }

    //envoyer les emails
    // $this->sendOrderConfirmationMail($order);

    //effacer le panier
     session()->forget('cart');
    session()->forget('coupon');

    //generate notification
    $notification = new notifications();
    $notification->url = route('details_commande', ['id' => $order->id]);
    $notification->titre = "Nouvelle commande.";
    $notification->message = "Commande passée par " . $order->nom;
    $notification->type = "commande";
    $notification->save();


    return redirect()->route('thank-you');
  }






  public function sendOrderConfirmationMail($order)
  {
   
      Mail::to($order->email)->send(new OrderMail($order));
   
  }

  public function index(Request $request)
  {

    return view('front.commandes.thankyou');
  }
}
