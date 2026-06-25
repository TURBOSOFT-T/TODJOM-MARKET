<?php

namespace App\Http\Controllers;

use App\Models\domaines;
use App\Models\produits;
use App\Models\templates;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DevelopperController extends Controller
{
    public function developper()
    {
        return view("admin.developper.index");
    }

    public function add_template()
    {
        $produits = produits::all();
        $domaines = domaines::all();
        return view("admin.developper.add-template", compact("produits", "domaines"));
    }


    public function importation_excel(){
        return view("admin.developper.importation");
    }



    public function post_template(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'titre' => 'required|string',
            'domaine' => 'required|integer|exists:domaines,id',
            'produit' => 'required|integer|exists:produits,id',
            'reference' => 'required|string',
            'id' => 'nullable|integer|exists:templates,id',
            'meta' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }


        $id = $request->input("id") ?? null;
        $titre = $request->input("titre");
        $id_domaine = $request->input("domaine");
        $id_produit = $request->input("produit");
        $reference = $request->input("reference");
        $meta = $request->input("meta");


        if ($id != null) {
            $template = templates::find($id);
            if ($template) {
                if ($template->code) {
                    Storage::disk('local')->delete($template->code);
                };
                $template->titre = $titre;
                $template->id_domaine = $id_domaine;
                $template->id_produit = $id_produit;
                $template->meta = $meta;
                $template->reference = Str::slug($reference);

                //stockage du code
                $nomFichier = Str::slug($reference) . '.txt';
                Storage::put($nomFichier, $request->template);
                $template->code = $nomFichier;
                $template->save();
                return redirect()->route('developper')->with("success", "Le template a été Modifié !");
            }
        } else {

            $template = new templates();
            $template->titre = $titre;

            $template->id_domaine = $id_domaine;
            $template->id_produit = $id_produit;
            $template->reference = Str::slug($reference);

            //stockage du code
            $nomFichier = Str::slug($reference) . '.txt';
            Storage::put($nomFichier, $request->template);
            $template->code = $nomFichier;
            $template->save();

            return redirect()->route('developper')->with("success", "Le template a été ajouté !");
        }
    }




    public function edit_template($id)
    {
        $template = templates::find($id);
        if (!$template) {
            return redirect()->route('developper')->with("error", "Le template est introuvable !");
        }
        $code = Storage::get($template->code);
        $produits = produits::all();
        $domaines = domaines::all();
        return view("admin.developper.edit-template", compact("code", "template", "produits", "domaines"));
    }
}
