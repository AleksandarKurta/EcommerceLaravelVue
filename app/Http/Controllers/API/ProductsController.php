<?php

namespace App\Http\Controllers\API;

use App\Product;
use App\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res = [];
        foreach(Product::all() as $product){
            $product->brand;
            $product->categories;
            $res[] = $product;
        }
        return $res;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $attributes = request()->validate([
            'name' => 'required|string',
            'brand_id' => 'required',
            'price' => 'required',
            'description' => 'required',
            'image' => 'sometimes|required'
        ]);

        $imageName = time(). '.' . explode('/', explode(':', \substr($attributes['image'], 0, strpos($attributes['image'], ';')))[1])[1];
        \Image::make($attributes['image'])->save(public_path('img/products/').$imageName);

        $attributes['image'] = 'img/products/' . $imageName;

        $product = Product::create($attributes);

        $product->categories()->attach($request->categories);

        return ['message' => 'Success'];
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $attributes = request()->validate([
            'name' => 'required|string',
            'brand_id' => 'required',
            'price' => 'required',
            'description' => 'required',
        ]);

        $currentImage = $product->image;
        $attributes['image'] = $request->image; 
        if($attributes['image'] != $currentImage){
            $imageName = time(). '.' . explode('/', explode(':', \substr($attributes['image'], 0, strpos($attributes['image'], ';')))[1])[1];

            \Image::make($attributes['image'])->save(public_path('img/products/').$imageName);

            $productImage = public_path('img/products/').$currentImage;
            if(file_exists($productImage)){
                unlink($productImage);
            }
            $attributes['image'] = 'img/products/' . $imageName;
        }

        $product->update($attributes);
        
        $product->categories()->sync($request->categories);
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

        $product->delete();

        $product->categories()->detach();
    }
}
