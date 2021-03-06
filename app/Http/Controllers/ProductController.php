<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Image;

class ProductController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $products = Product::all();
      return response()->json([
         'products' => $products
      ],200);
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      $product = new Product();
      
      $product->name = $request->name;
      $product->description = $request->description;
      if($request->photo != ""){
         $strpos = strpos($request->photo, ';');
         $sub = substr($request->photo,0,$strpos);
         $ex = explode('/',$sub)[1];
         $name = time().".".$ex;
         $img = Image::make($request->photo)->resize(200,200);
         $upload_path = public_path()."/upload/";
         $img->save($upload_path.$name);
         $product->photo = $name;
      }else{
         $product->photo = "image.png";
      }
      $product->photo = $name;
      $product->type = $request->type;
      $product->quantity = $request->quantity;
      $product->price = $request->price;
      $product->save();
   }

   /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function show($id)
   {
      //
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function edit($id)
   {
      $product = Product::find($id);
      return response()->json([
         'product' => $product
      ], 200);
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
      $product = Product::find($id);
      $product->name = $request->name;
      $product->description = $request->description;
      if ($product->photo != $request->photo) {
         $strpos = strpos($request->photo, ';');
         $sub = substr($request->photo, 0, $strpos);
         $ex = explode('/', $sub)[1];
         $name = time() . "." . $ex;
         $img = Image::make($request->photo)->resize(200, 200);
         $upload_path = public_path() . "/upload/";
         $image = $upload_path. $product->photo;
         $img->save($upload_path . $name);
         if(file_exists($image)){
            @unlink($image);
         }
      } else {
         $name = $product->photo;
      }
      $product->photo = $name;
      $product->type = $request->type;
      $product->quantity = $request->quantity;
      $product->price = $request->price;
      $product->save();
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      $product = Product::findOrFail($id);
      $image_path = public_path()."/upload/";
      $image = $image_path. $product->photo;
      if(file_exists($image)){
         @unlink($image);
      }
      $product->delete();
   }
}
