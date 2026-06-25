<?php

namespace App\Livewire\Evenements;

use App\Models\Category;
use App\Models\Event;
use Livewire\Livewire;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;


use Livewire\Component;
use phpDocumentor\Reflection\Types\Nullable;

class AddEvenement extends Component
{

    use WithFileUploads;

    public $titre, $description, $email, $category_id, $image, $image2, $start, $end, $event, $type, $free;
    public $updateMode = false;
    public $meta_description;
    public $autre_description;
    public $autre_description1;
    public $telephone, $heure, $location, $country, $adresse;

    public function mount($event)
    {
        if ($event) {
            //   $this->event = $event;
            $this->titre = $event->titre;
            $this->type = $event->type;
            $this->description = $event->description;
            
            $this->telephone = $event->telephone;
            $this->heure = $event->heure;
            $this->location = $event->location;
          //  $this->country = $event->country;
            $this->adresse = $event->adresse;
            $this->category_id = $event->category_id;
            $this->email = $event->email;
            $this->start = $event->start;
            $this->end = $event->end;

            $this->image2 = $event->image;
            $this->free = $event->free ?? 0;
        }
    }


    private function resetInputFields()
    {
        $this->titre = '';
        $this->description = '';

        $this->image = '';
        $this->image2 = '';
        $this->start = '';
        $this->end = '';
    }




    public function create()
    {
        $data =  $this->validate([
            'titre' => 'required|string',
            'description' => 'required|string|max:500260',


            'image' => 'sometimes|required|file|mimetypes:image/*',
          //  'category_id' => 'required|integer|exists:categories,id',
           // 'type' => 'required|in:webinaire,presentiel',
            'free' => 'nullable',


        ]);;
        [
            'titre.required' => 'Le titre',
            'description.required' => 'Veuillez entrer votre description',

        ];
     //   $categories = Category::findOrFail($data[('category_id')]);
        $event = new event();

        $event->titre = $this->titre;
        $event->user_id = auth()->id();
        $event->free = $this->free ?? false;
        $event->description = $this->description;
        $event->meta_description = $this->meta_description;
       
        $event->telephone = $this->telephone;
        $event->heure = $this->heure;
        $event->location = $this->location;
      //  $event->country = $this->country;
        $event->adresse = $this->adresse;


       // $event->type = $this->type;
        //  $event->email = $this->email;
        $event->start = $this->start;
        $event->end = $this->end;

        //  if($this->image){
        $event->image = $this->image->store('events', 'public');
        //  }


         $event->save();
      //  $categories->events()->save($event);

        $this->resetInputFields();

        session()->flash('success', 'event ajouté avec succès');
        return redirect()->route('events');
    }



    public function render()
    {
        $categories = Category::all();
        return view('livewire.evenements.add-evenement', compact('categories'));
    }
}
