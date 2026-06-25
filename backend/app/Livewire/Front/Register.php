<?php

namespace App\Livewire\Front;

use App\Mail\register as MailRegister;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

//use App\Mail\register as MailRegister;




use Illuminate\Support\Facades\Hash;

use Illuminate\Validation\Rules;
use Livewire\Component;

class Register extends Component
{
    public $nom;
    public $prenom;
    public $email;
    public $password;
    public $password_confirmation;
    public $isRegistered = false;

    protected $rules = [
        'nom' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required|min:8',
    ];

    protected $messages = [
        'nom.required' => 'Le nom est obligatoire',
        'email.required' => 'L\'email est obligatoire',
        'email.email' => 'L\'email n\'est pas valide',
        'email.unique' => 'L\'email existe déjà',
        'password.required' => 'Le mot de passe est obligatoire',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
        'password.confirmed' => 'Les mots de passe ne correspondent pas',
        'password_confirmation.required' => 'La confirmation du mot de passe est obligatoire',
        'password_confirmation.min' => 'La confirmation du mot de passe doit contenir au moins 8 caractères',
    ];

    public function save()
    {
        $this->validate();

        $user = User::create([
            'nom' => $this->nom,
            'prenom' => $this->prenom,
          //  'telephone' => $this->telephone,  // Add your additional fields here...
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $this->isRegistered = true;
 
         Mail::to($user->email)->send(new  MailRegister($user));
       
       // event(new Registered($user));
        Auth::login($user);
          session()->flash('success', 'Votre compte a été créé avec succès!');

        return redirect()->route('home');

       // Auth::login($user);
       // return redirect('/')->back()->with("success", "Votre compte est crée ");
    }

    public function render()
    {
        return view('livewire.front.register');
    }


    public function save1(){
        $this->validate([
            'nom' =>'required|string',
            'prenom' =>'nullable|string',
            'email' =>'required|email|unique:users',
          //  'password' =>'required|string|min:8',
          'password' => ['required', 'min:8','string', 'confirmed', Rules\Password::defaults()],
            'telephone' =>'required|string',
           // 'password_confirmation' => 'required|string|same:password',
        ],[
            'nom.required' => 'Veuillez entrer votre nom',
            'prenom.required' => 'Veuillez entrer votre prénom',
            'email.required' => 'Veuillez entrer votre email',
            'email.email' => 'Veuillez entrer un email valide',
            'email.unique' => 'Votre email est déjà inscrit',
            'password.required' => 'Veuillez entrer votre mot de passe',
            'password.min' => 'Votre mot de passe doit contenir au moins 8 caractères',
            'telephone.required' => 'Veuillez entrer votre numéro de téléphone',
            'telephone.string' => 'Veuillez entrer un numéro de téléphone valide',
        ]);

        $user = new User();
        $user->nom = $this->nom;
       // $user->prenom = $this->prenom;
        $user->email = $this->email;
        $user->password =  $this->password;

        $user->phone = $this->telephone;
        $user->role = "client";
        $user->save();

        //send mail
       // Mail::to($user->email)->send(new MailRegister($user));

        Auth::login($user);
        return redirect('/')->back()->with("success", "Votre compte est crée ");
    }


}
