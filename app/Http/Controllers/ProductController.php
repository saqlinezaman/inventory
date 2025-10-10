<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function createProduct(Request $request)
    {
        // dd($request->all());
        $user_id = $request->header('userId');

        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'unit' => 'required|integer',
            'category_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'unit' => $request->unit,
            'category_id' => $request->category_id,
            'user_id' => $user_id,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = rand(1000, 9999) . time() . '.' . $image->getClientOriginalExtension();
            $filePath = 'uploads/' . $fileName;
            $image->move(public_path('uploads'), $fileName);
            $data['image'] = $filePath;
        }
        Product::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Product created successfully',
        ]);
    }//end method
    public function listProduct(Request $request)
    {
        $user = $request->header('userId');
        $products = Product::where('user_id', $user)->with('category')->get();
        return $products;
    } //end method
}
