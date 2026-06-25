<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Category;
use App\Models\Inscription;
use App\Models\Vehicule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{

    public function events()
{


     $user = auth()->user();

        
       
$data['events'] = Event::all();
///dd($data);
  
    return view('admin.evenements.list',$data );
}



  
    public function addVoitureEvent(Request $request)
    {
        try {
            $request->validate([
                'event_id' => 'required|exists:events,id',
               //  'country_id' => 'nullable|exists:countries,id',
               
               
              
              
            ]);

            
            $userId = Auth::check() ? Auth::id() : $user->id ?? null;

            // Vérifie si l'utilisateur est déjà inscrit à cet événement
            $exists = Inscription::where('email', $request->email)
            ->where('event_id', $request->event_id)
            ->exists();
        
        if ($exists) {
            return response()->json([
                'status' => 'duplicate',
                'message' => 'Vous êtes déjà inscrit à cet événement.'
            ]);
        }
        
            

            

            $userId = Auth::check() ? Auth::id() : null;

            $inscription = new Inscription([
                'user_id' => $userId,
             
                'event_id' => $request->event_id,
                'nbrplace'=>$request->nbrplace,
                'prix'=> $request->prix,
       

                'type' => 'Event',
            ]);



            $inscription->save();

         

            return response()->json([
                'message' => 'Inscription enregistrée avec succès.'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'line' => $e->getLine()], 500);
        }
    }


public function evenements(){
    $events = Event::all();
    $lastevents = Event::latest()->take(8)->get();
    return view('front.evenements.evenement', compact('events', 'lastevents') );
}


   
    public function destroy($id)
    {
     $event=   Event::find($id);

     if ($event) {
        // Supprimer l'image si elle existe
        if($event->image ?? ' '){
            Storage::disk('public')->delete($event->image ?? ' '); 
        }

        // Supprimer le event
        $event->delete();

     
    return redirect()->back()
    ->with('success', 'Event supprimé avec succès, ainsi que son image.');
    } else {
        return redirect()->back()('error', 'event non trouvé.');
    }
    }

    
    public function event_update($id){

        $event = Event::find($id);
       if (!$event) {
            $message = "Evènement non disponible !";
            abort(404, $message);
        } 
        $categories = Category::all();
 
        return view('admin.evenements.update', compact('event','categories'));
    }
    public function update(UpdateEventRequest $request, $id)
    {
        // Validation personnalisée
        $validator = Validator::make($request->all(), [
          //  'image' => 'sometimes|file|image|max:2048', // max en kilooctets (2MB)
            'image' => 'sometimes|required|file|mimetypes:image/*',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
         //   'category_id' => 'required|integer|exists:categories,id',
        ], [
            'image.max' => 'La taille de l\'image ne doit pas dépasser 2MB.',
            'titre.required' => 'Le titre est requis.',
            'titre.max' => 'Le titre ne doit pas dépasser 255 caractères.',
        ]);
     //   $categories = Category::findOrFail($validator[('category_id')]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Récupération de l'événement
        $event = Event::findOrFail($id);
        $event->titre = $request->titre;
        $event->description = $request->description;
    //    $event->category_id = $request->category_id; 
    
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image s'il y en a une
            if ($event->image && Storage::disk('public')->exists($event->image)) {
                Storage::disk('public')->delete($event->image);
            }
    
            // Enregistrer la nouvelle image
            $path = $request->file('image')->store('events', 'public');
            $event->image = $path;
        }
    
      //  $event->save();
      $event->save(); //
     //   $categories->events()->save($event);
    
        return redirect()->back()->with('success', 'Évènement mis à jour avec succès !');
    }
    

}
