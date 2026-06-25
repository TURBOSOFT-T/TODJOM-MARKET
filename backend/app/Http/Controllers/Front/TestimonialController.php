<?php

namespace App\Http\Controllers\Front;

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


 
    
}
