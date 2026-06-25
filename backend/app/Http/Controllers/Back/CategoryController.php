<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
//use DataTables;
use DataTables;
use Illuminate\Http\JsonResponse;

use App\Models\Category;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
    
        if ($request->ajax()) {
    
            $data = Category::select('id', 'nom', 'description', 'photo')->get();


          
    
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
     
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="View" class="me-1 btn btn-info btn-sm showCategory"><i class="fa-regular fa-eye"></i> View</a>';
           
                           $btn =  $btn. '<a href="'.route('categories.update', $row->id).'" data-toggle="tooltip" class="btn btn-primary btn-sm"><i class="fa-regular fa-pen-to-square"></i> Edit</a>';

                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteProduct"><i class="fa-solid fa-trash"></i> Delete</a>';
    
                            return $btn;
                    })
                    ->addColumn('photo', function($row) {
                       
                        return '<img src="' . asset('storage/' . $row->photo) . '" alt="Image" style="max-width: 50px; height: auto;">';
                    })
                    ->rawColumns(['action', 'photo']) 
                    ->make(true);
        }
          
        return view('admin.categories.list');
    }

    public function show($id): JsonResponse
    {
        $category = Category::withCount('produits')->findOrFail($id);
        return response()->json([
            'nom' => $category->nom,
            'description' => $category->description,
            'produit_count' => $category->produits_count,
            'photo' => ($category->photo), 
        ]);
    }



  
    public function destroy($id): JsonResponse
    {
        Category::find($id)->delete();
        
        return response()->json(['success'=>'Category deleted successfully.']);
    }
}
