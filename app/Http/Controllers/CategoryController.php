<?php

namespace raplet\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;
use raplet\Category;
use Illuminate\Support\Facades\Validator;
use Cocur\Slugify\Slugify;



class CategoryController extends Controller
{

	/**
	 * only the guard type of admin can access fucntions in this controller
	 */
	public function __construct()
	{
		$this->middleware('auth:admin');
	}

	/**
	 * Create a new record
	 */
	public function create(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:200|unique:category',
		]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()->all()]);
		}
		$categoryslug = new Slugify();
		$slug = $categoryslug->slugify($request['name']);

		$category = new Category();
		$category->name = $request['name'];
		$category->slug = $slug;

		$category->save();

		while (count(Category::where('slug', $slug)->get()) > 1) {
			$category->slug = $category->slug . $category->id;
		}

		$message = trans('home.success');

		return response()->json(['message' => $message]);
	}

	/**
	 * update record with the id of content_id
	 */
	public function update(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => 'required|max:200|unique:category',
		]);
		if ($validator->fails()) {
			return response()->json(['errors' => $validator->errors()->all()]);
		}
		$result = Category::where('id', $request['content_id'])
			->update([
				'name' => $request['name'],
				'slug' => $request['slug'],
				'interest' => $request['interest'],
			]);

		if ($result) {
			return response()->json(['message' => "Category was updated successfully"]);
		} else {
			return response()->json(['message' => 'An Error was occurred']);
		}
	}

	/**
	 * Delete recorde with the id of content_id
	 */
	public function delete(Request $request)
	{
		$result = Category::where('id', $request['content_id'])->first()->delete();
		if ($result) {
			return response()->json(['message' => "Content was soft deleted!"]);
		} else {
			return response()->json(['message' => 'An Error was occurred']);
		}
	}

	/**
	 * Erase record from database
	 */
	public function forceDelete(Request $request)
	{
		$result = Category::withTrashed()->where('id', $request['content_id'])->first()->forceDelete();
		if ($result) {
			return response()->json(['message' => "Content was force deleted!"]);
		} else {
			return response()->json(['message' => 'An Error was occurred']);
		}
	}

	/**
	 * Restore soft deleted record
	 */
	public function restore(Request $request)
	{
		$result = Category::onlyTrashed()->where('id', $request['content_id'])->first()->restore();
		if ($result) {
			return response()->json(['message' => "Category was restored!"]);
		} else {
			return response()->json(['message' => 'An Error was occurred']);
		}
	}

	/**
	 * Index records 
	 */
	public function index()
	{
		return view('admin.category.index');
	}

	/**
	 * return the deleted records to a restore view
	 */
	public function restore_view()
	{
		$categories = DB::table('category')->where('deleted_at', '!=', null)->orderBy('id', 'desc')->get();
		return view('admin.category.restore', ['categories' => $categories]);
	}
}
