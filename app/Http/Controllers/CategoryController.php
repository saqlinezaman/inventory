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

    }
}
