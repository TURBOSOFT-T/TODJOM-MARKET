<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;


use App\Http\Requests\StoreOnline_ClasseRequest;
use App\Http\Requests\UpdateOnline_ClasseRequest;
use App\Notifications\SendEmailZoom;
use App\Http\Traits\MeetingZoomTrait;
use App\Models\Inscription;
use App\Models\InscriptionVehicule;
use App\Models\Online_classe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Notifiable;

use Illuminate\Contracts\Mail\Mailable;
use App\Services\PayUService\Exception;
use Illuminate\Validation\ValidationException;


class EventController extends Controller
{

public function addVehicule(Request $request)
{
    try {

        $request->validate([
            'event_id' => 'required|exists:events,id',
            'vehicule_id' => 'required|exists:vehicules,id',

            'telephone' => 'nullable|string|max:20',
            'addresse' => 'nullable|string|max:255',
           

            'prix_aller' => 'nullable|numeric',
            'prix_retour' => 'nullable|numeric',
            'prix_aller_retour' => 'nullable|numeric',
        ]);

        // Vérifier si l'utilisateur est connecté
        if (!auth()->check()) {

            return response()->json([
                'status' => 'error',
                'message' => 'Veuillez vous connecter.'
            ], 401);
        }



        // Vérifier si le véhicule est déjà inscrit
        $exists = InscriptionVehicule::where('vehicule_id', $request->vehicule_id)
            ->where('event_id', $request->event_id)
            ->exists();

        if ($exists) {

            return response()->json([
                'status' => 'duplicate',
                'message' => 'Ce véhicule est déjà inscrit à cet évènement.'
            ]);
        }

        // Enregistrement
        $inscription = new InscriptionVehicule();
        $inscription->user_id = auth()->id();
        $inscription->nom = auth()->user()->nom;
        $inscription->prenom = auth()->user()->prenom;
        $inscription->email = auth()->user()->email;
        $inscription->telephone = auth()->user()->phone;
         $inscription->whatsapp = auth()->user()->phone;
          $inscription->addresse = auth()->user()->adresse;
        $inscription->event_id = $request->event_id;
        $inscription->vehicule_id = $request->vehicule_id;
        $inscription->prix_aller = $request->prix_aller;
        $inscription->prix_retour = $request->prix_retour;
        $inscription->prix_aller_retour = $request->prix_aller_retour;

       
        $inscription->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Inscription enregistrée avec succès.'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage(),
            'line' => $e->getLine()
        ], 500);
    }
}
  




   

}
