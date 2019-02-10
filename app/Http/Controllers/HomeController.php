<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;
use Validator;

class HomeController extends Controller
{
    public function index(){
    	$categories = Categories::get();

    	return view('layout', ['categories' => $categories]);
    }

    public function addCategory(Request $request){
    	$validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories'
        ]);

    	if ($validator->fails()) {
            return response()->json([
                'errorMsg' => $validator->messages(),
                'isSuccess' => false
            ]);
        } else {
    		$name = $request->name;
	    	$category = Categories::create(['name' => $name]);
	    	return response()->json([
			    'name' => $name,
			    'id' => $category->id,
			    'isSuccess' => true
			]);
        }
    }

    public function deleteCategory(Request $request){
		$category = Categories::find($request->id);
		$category->delete();

    	return response()->json([
		    'isSuccess' => true
		]);
    }

    public function updateCategory(Request $request){
    	$validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories',
        ]);


    	if ($validator->fails()) {
            return response()->json([
                'errorMsg' => $validator->messages(),
                'isSuccess' => false
            ]);
        } else {
	    	$category = Categories::find($request->categoryId);
			$category->name = $request->value;
			$category->save();

            return response()->json([
                'isSuccess' => true,
                'categoryId' => $request->categoryId
            ]);
        }
    }

}
