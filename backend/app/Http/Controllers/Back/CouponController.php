<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;

use App\Models\Coupon;
use App\Models\produits;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   

    public function index()
    {
        $coupon=Coupon::orderBy('id','DESC')->paginate('10');
        return view('backend.coupon.index')->with('coupons',$coupon);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.coupon.create');
    }
    public function savecoupon(Request $request)
    {
       
        $this->validate($request,[
            'code'=>'string|required',
            'type'=>'required|in:fixed,percent',
            'value'=>'required|numeric',
            'status'=>'required|in:active,inactive'
        ]);
        $data=$request->all();
        $status=Coupon::create($data);
        if($status){
            request()->session()->flash('success','Coupon Successfully added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('coupons');
    }

   
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatecoupon($id)
    {
        $coupon=Coupon::find($id);
        if($coupon){
            return view('admin.coupons.update')->with('coupon',$coupon);
        }
        else{
            return view('admin.coupons.list')->with('error','Coupon not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $coupon=Coupon::find($id);
        $this->validate($request,[
            'code'=>'string|required',
            'type'=>'required|in:fixed,percent',
            'value'=>'required|numeric',
            'status'=>'required|in:active,inactive'
        ]);
        $data=$request->all();
        
        $status=$coupon->fill($data)->save();
        if($status){
            request()->session()->flash('success','Coupon Successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('coupons');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $coupon=Coupon::find($id);
        if($coupon){
            $status=$coupon->delete();
            if($status){
                request()->session()->flash('success','Coupon successfully deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('coupons');
        }
        else{
            request()->session()->flash('error','Coupon not found');
            return redirect()->back();
        }
    }

    public function couponStore(Request $request){
        // return $request->all();
        $coupon=Coupon::where('code',$request->code)->first();
        // dd($coupon);
        if(!$coupon){
            request()->session()->flash('error','Invalid coupon code, Please try again');
            return back();
        }
        if($coupon){
          //  $total=Cart::where('user_id',auth()->user()->id)->where('order_id',null)->sum('price');
            $paniers_session = session('cart', []);
            $paniers = [];
    $total = 0;
    foreach ($paniers_session as $session){
        $produit = Produit::find($session['id_produit']);
        if ($produit) {
            $paniers[] = [
              'nom' => $produit->nom,
              'id_produit' => $produit->id,
              'photo' => $produit->photo,
              'quantite' => $session['quantite'],
              'prix' => $produit->prix,
              'total' => $session['quantite'] * $produit->prix,
            ];
         //   $total += $session['quantite'] * $produit->prix;

            session()->put('coupon',[
                'id'=>$coupon->id,
                'code'=>$coupon->code,
                'value'=>$coupon->discount($total)
            ]);
        }
    }

           
            request()->session()->flash('success','Coupon successfully applied');
            return redirect()->back();
        }
    }





}
