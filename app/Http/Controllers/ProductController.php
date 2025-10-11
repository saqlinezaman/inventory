<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
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
    } //end method
    public function listProduct(Request $request)
    {
        $user = $request->header('userId');
        $products = Product::where('user_id', $user)->with('category')->get();
        return $products;
    } //end method

    public function productById(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);
        $product = Product::where('id', $request->id)->first();
        return $product;
    } //end method

    public function productUpdate(Request $request)
    {
        $user = $request->header('userId');
        $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string',
            'price' => 'required|numeric',
            'unit' => 'required|integer',
            'category_id' => 'required|integer',

        ]);

        $product = Product::where('user_id', $user)->findOrFail($request->id);

        $product->name = $request->name;
        $product->price = $request->price;
        $product->unit = $request->unit;
        $product->category_id = $request->category_id;



        if ($request->hasFile('image')) {

            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $image = $request->file('image');
            $fileName = rand(1000, 9999) . time() . '.' . $image->getClientOriginalExtension();
            $filePath = 'uploads/' . $fileName;
            $image->move(public_path('uploads'), $fileName);
            $product->image = $filePath;
        }
        $product->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
        ]);
    }
    public function deleteProduct($id, Request $request)
    {
        try {
            $user = $request->header('userId');
            $product = Product::where('user_id', $user)->findOrFail($id);

            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }

            $product->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Product deleted successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found or you do not have permission to delete this product',
            ], 404);           
        }
    } //end method
}
