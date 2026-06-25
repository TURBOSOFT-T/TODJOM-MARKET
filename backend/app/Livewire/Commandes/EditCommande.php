<?php

namespace App\Livewire\Commandes;

use App\Http\Traits\ListGouvernorats as TraitsListGouvernorats;
use App\Models\config;
use App\Models\contenu_commande;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EditCommande extends Component
{
    use TraitsListGouvernorats;

    public $commande, $gouvernoratsTunisie, $nom, $prenom, $adresse, $gouvernorat, $phone, $frais,  $commercial_id, $solde = 0, $caisse_id;


    public function mount($commande)
    {
        $this->commande = $commande;
        $this->commercial_id = $commande->commercial_id  ?? null;
        $this->caisse_id = $commande->caisse_id  ?? null;

        $this->frais = $commande->frais;
        $this->nom = $commande->nom;
        $this->prenom = $commande->prenom;
        $this->adresse = $commande->adresse;
        $this->gouvernorat = $commande->gouvernorat;
        $this->phone = $commande->phone;
    }

    public function render()
    {
        $this->gouvernoratsTunisie = $this->getListGouvernorat();
        return view('livewire.commandes.edit-commande');
    }

    public function update_user_info()
    {
        $data =    $this->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'nullable|string|max:100',
            'adresse' => 'nullable|string|max:150',
            'phone' => 'required|string|max:100',

            'frais' => 'nullable',
        ]);
        $caisse_id = Auth::id();

        $config = config::first();
        $this->commande->nom = $this->nom;
        $this->commande->prenom = $this->prenom;
        $this->commande->adresse = $this->adresse;
        $this->commande->phone = $this->phone;
        $this->commande->commercial_id =  $this->commercial_id ?? null;
        $this->commande->caisse_id =  Auth::id();
        $this->commande->frais = $this->frais ? $config->frais : null;


        // Mise à jour du solde si mode = solde
        if ($this->commande->mode == 'solde') {
            if ($this->frais) {
                // Ajout au solde
                $this->commande->user->solde += $config->frais;
            } else {
                // Retrait si frais supprimés
                $this->commande->user->solde -= $config->frais;
            }
        }

        // Mise à jour des points si mode = points
        if ($this->commande->mode == 'points') {
            if ($this->frais) {
                $this->commande->user->points += $config->frais;
            } else {
                $this->commande->user->points -= $config->frais;
            }
        }
        //dd($this->commande->user->points);
        $this->commande->user->save();
        $this->commande->save();

        session()->flash('success', __('Les informations de la commandes ont été  modifiés !'));
    }



    public function change($id_contenu, $quantite, $type)
    {
        $contenu = contenu_commande::find(intval($id_contenu));
        //  $client = $contenu->commandes->user;

        $client = $contenu->commandes->user; // le client
        $produit = $contenu->produit;
        // dd($produit);

        //  dd($client);
        if (!$contenu) {
            session()->flash('warning', 'Contenu non trouvé');
            return;
        }

        $ancienneQuantite = $contenu->quantite;
        $quantite = intval($quantite);
        $diff = $quantite - $ancienneQuantite;

        // Vérifier que la nouvelle quantité est supérieure à 0
        if ($quantite <= 0) {
            session()->flash('error', 'La quantité doit être supérieure à 0');
            return;
        }
        $montantVariation = $produit->getPrice() * abs($diff);

        // dd($montantVariation);
        // Si augmentation
        if ($diff > 0) {
            if ($contenu->produit->stock < $diff) {
                session()->flash('error', 'Quantité demandée excède le stock disponible');
                return;
            }
            if ($contenu->commandes->mode === 'solde') {
                // Solde client diminue (mais vérifier qu'il y a assez de solde)
                if ($client->solde < $montantVariation) {
                    session()->flash('error', 'Solde insuffisant pour augpenter la quantité');
                    return;
                }
                $client->solde -= $montantVariation;
            }

            if ($contenu->commandes->mode === 'points') {
                // Solde client diminue (mais vérifier qu'il y a assez de solde)
                if ($client->points < $montantVariation) {
                    session()->flash('error', 'Le nombre de points insuffisant pour augpenter la quantité');
                    return;
                }
                $client->points -= $montantVariation;
            }


            $contenu->produit->diminuer_stock($diff);
            // $client->solde -= $montantVariation;
            $client->save();
        }
        // Si diminution
        elseif ($diff < 0) {


            if ($contenu->commandes->mode === 'solde') {

                $client->solde += $montantVariation;
            }

            if ($contenu->commandes->mode === 'points') {

                $client->points += $montantVariation;
            }
            $contenu->produit->retourner_stock(abs($diff));
            // $client->solde += $montantVariation;
            $client->save();
        }

        // Mettre à jour la quantité
        $contenu->quantite = $quantite;
        $contenu->total_gain_points = $contenu->produit->points * $quantite;
        $contenu->save();
    }



    public function delete($id)
    {
        $contenu = contenu_commande::find(intval($id));
        $client = $contenu->commandes->user;

        //   dd($newsolde);
        // dd($client->solde);


        if (!$contenu) {
            session()->flash('warning', 'Contenu non trouvé');
            return;
        }

        if ($client) {
            //  $client->points = $client->points  + $contenu->commandes->points_utilise ;
            if ($contenu->commandes->mode === 'solde') {
                $client->solde += $contenu->prix_unitaire * $contenu->quantite;;
            }

            if ($contenu->commandes->mode === 'points') {
                $client->points += $contenu->produit->points * $contenu->quantite;
            }
            $client->save();
        }

        // Retourner le stock du produit avant suppression
        $contenu->produit->retourner_stock($contenu->quantite);

        // Supprimer le contenu
        $contenu->delete();
        session()->flash('success', 'Le contenu a été supprimé de votre commande');

        // Vérifier s'il reste des contenus dans la commande
        $contenusRestants = $this->commande->contenus()->count();

        if ($contenusRestants == 0) {
            // Supprimer la commande si vide
            $this->commande->delete();
            return redirect()->route('commandes')->with('success', 'La commande a été supprimée car elle était vide');
        }
    }
}
