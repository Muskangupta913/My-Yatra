<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoopingcart\Facades\Cart;

class CartContoller extends Controller
{
    // public function addTocart(Request $request){
    //     // Cart::add('293ad', 'Product 1', 1, 9.99);
    //     $package =package::find($request->id);

    //      if ($package==null){
    //         return response()->json([
    //             'status' =>false,
    //             'message'=>'package not fount'
    //         ]);
    //      }
    //      if(Cart::count()>0){
            
    //      }else{
    //         //cart is empty
    //         Card::add($package->id, $package-> , $package-> , $package-> , $package-> ,$package-> );

    //      }

    // }
    public function cart()
    {
        // Add any logic needed for the checkout page
        return view('frontend.checkout'); // Ensure you have a 'checkout.blade.php' view
    }

    public function cartbutton(){
        return view('frontend.checkout');
    }
}
