<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\Front\ContactRequest;
use App\Models\{ Contact};

class ContactController  extends BaseController
{
    

    public function contacts()
    {

        $data = Contact::paginate(10);
        if ($data->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => "Aucun contact trouvé.",
                'data' => []
            ]);
        }

        return $this->getResponse($data, "Tous les contacts ");
    }

   

}