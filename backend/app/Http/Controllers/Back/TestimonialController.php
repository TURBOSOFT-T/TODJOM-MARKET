<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;

use App\Models\notifications;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use RealRashid\SweetAlert\Facades\Alert;
//use Illuminate\Support\Facade\Mail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;


class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::all();
        return view('back.temoignages.index', compact('testimonials'));
       
    }

    public function edit($id)
    {
        $testimonial = Testimonial::find($id);
        return view('admin.testimonials.show', compact('testimonial'));
    }


    public function update(Request $request, $id)
{
    $request->validate([
        'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'message' => 'required|string|max:500',
    ]);

    $testimonial = Testimonial::find($id);

    // Si une nouvelle photo est téléchargée
    if ($request->hasFile('photo')) {
        $imageName = time().'.'.$request->photo->extension();  
        $request->photo->move(public_path('uploads/testimonials'), $imageName);
        $testimonial->photo = $imageName;
    }

    // Mise à jour du message
    $testimonial->message = $request->message;

    $testimonial->save();

    return redirect()->route('testimonials')->with('success', 'Témoignage mis à jour avec succès.');
}


 
    public function store(StoreTestimonialRequest $request)
    {

   
   
        $testimonial = Testimonial::create($request->all());

        $notification = new notifications();
    
       
          $notification->titre = "Nouveau message.";
         $notification->message = "Envoyé passée par " . $testimonial->name;
          $notification->type = "message";
          $notification->save();
    
   
       return back()->with ('success', 'Témoignage créé avec succès! Il sera valide après confirmation des administrateurs');

  
    }

    public function approve($id)
    {
        $testimonial = Testimonial::find($id);
        
        if ($testimonial) {
            $testimonial->active = true; 
            $testimonial->save();
            
            return redirect()->back()
                             ->with('success', 'Témoignage approuvé avec succès.');
        }
    
        return redirect()->back()
                         ->with('error', 'Témoignage introuvable.');
    }

    public function disapprove($id)
{
    $testimonial = Testimonial::find($id);

    if ($testimonial) {
        $testimonial->active = false; 
        $testimonial->save();

        return redirect()->back()
                         ->with('success', 'Témoignage désapprouvé avec succès.');
    }

    return redirect()->back()
                     ->with('error', 'Témoignage introuvable.');
}

 
    public function destroy($id)
    {
        $testimonial = Testimonial::find($id);
    
        if ($testimonial) {
            $testimonial->delete();
    
            return redirect()->back()
                             ->with('success', 'Témoignage supprimé avec succès.');
        }
    
        return redirect()->back()
                         ->with('error', 'Témoignage introuvable.');
    }
}
