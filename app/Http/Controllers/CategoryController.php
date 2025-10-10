<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function createCategory(Request $request)
    {
        $user = $request->header('userId');

        Category::create([
            'name' => $request->name,
            'user_id' => $user
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully'
        ]);

    } //end method

    public function listCategory(Request $request)
    {
        $user = $request->header('userId');
        $categories = Category::where('user_id', $user)->get();
        return $categories;
    } //end method
    public function categoryById(Request $request)
    {
        $user = $request->header('userId');
        $category = Category::where('user_id',$user)->where('id',$request->id)->first();
        return $category;
    } //end method

    public function categoryUpdate(Request $request){
        $user = $request->header('userId');
        $id = $request->input('id');

        Category::where('user_id',$user)->where('id',$id)->update(['name' => $request->input('name')]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully'
        ]);
    }//end method
    public function deleteCategory(Request $request, $id){
        $user = $request->header('userId');

        Category::where('user_id',$user)->where('id',$id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully'
        ]);
    }//end method
}
